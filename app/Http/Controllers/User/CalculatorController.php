<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalculatorController extends Controller
{
    /**
     * Display the material calculator page.
     */
    public function index()
    {
        return Inertia::render('User/Calculator/Index');
    }

    /**
     * Calculate material requirements.
     */
    public function calculate(Request $request)
    {
        $type = $request->type;
        $result = match($type) {
            'cat' => $this->calculatePaint($request),
            'cement' => $this->calculateCement($request),
            'brick' => $this->calculateBrick($request),
            'steel' => $this->calculateSteel($request),
            'roof' => $this->calculateRoof($request),
            default => ['error' => 'Kalkulator tidak ditemukan']
        };

        return response()->json($result);
    }

    /**
     * Calculate paint requirements.
     * Formula: Luas dinding (m²) / 10 m² per liter * jumlah coating
     */
    private function calculatePaint(Request $request): array
    {
        $luas = (float) $request->luas_dinding; // m²
        $coating = (int) $request->jumlah_coating; // 1-3

        $luas_per_liter = 10; // 1 liter = 10 m² (2 lapis standar)
        $jumlah_liter = ($luas / $luas_per_liter) * $coating;
        
        // Tambah 10% cadangan
        $jumlah_liter_cadangan = $jumlah_liter * 1.1;
        
        $jumlah_kaleng_20l = floor($jumlah_liter_cadangan / 20);
        $sisa = $jumlah_liter_cadangan - ($jumlah_kaleng_20l * 20);
        $jumlah_kaleng_5l = floor($sisa / 5);
        $jumlah_kaleng_1l = ceil($sisa - ($jumlah_kaleng_5l * 5));

        return [
            'type' => 'cat',
            'title' => 'Kalkulator Cat',
            'input' => [
                'luas_dinding' => $luas . ' m²',
                'jumlah_coating' => $coating . ' lapis',
            ],
            'output' => [
                'total_liter' => round($jumlah_liter, 1) . ' liter',
                'total_dengan_cadangan' => round($jumlah_liter_cadangan, 1) . ' liter (+10%)',
                'kaleng_20l' => $jumlah_kaleng_20l,
                'kaleng_5l' => $jumlah_kaleng_5l,
                'kaleng_1l' => max(0, $jumlah_kaleng_1l),
            ],
            'tips' => 'Tambahkan 10% cadangan untuk antisipasi. 1 liter cat menutupi ±10 m² untuk 2 lapis.',
        ];
    }

    /**
     * Calculate cement requirements.
     * Formula: Volume (m³) * 7 sak semen per m³
     */
    private function calculateCement(Request $request): array
    {
        $luas = (float) $request->luas_area; // m²
        $tebal = (float) $request->ketebalan; // cm

        $volume = $luas * ($tebal / 100); // m³
        $semen_per_m3 = 7; // sak per m³ (untuk campuran 1:3:6)
        $pasir_per_m3 = 0.5; // m³ pasir per m³ beton
        $kerikil_per_m3 = 0.8; // m³ kerikil per m³ beton

        return [
            'type' => 'cement',
            'title' => 'Kalkulator Semen',
            'input' => [
                'luas_area' => $luas . ' m²',
                'ketebalan' => $tebal . ' cm',
            ],
            'output' => [
                'volume_total' => round($volume, 2) . ' m³',
                'semen_sak' => ceil($volume * $semen_per_m3) . ' sak (50kg)',
                'pasir_m3' => round($volume * $pasir_per_m3, 2) . ' m³',
                'kerikil_m3' => round($volume * $kerikil_per_m3, 2) . ' m³',
            ],
            'tips' => 'Perhitungan untuk campuran beton standar 1:3:6 (PC:Pasir:Kerikil).',
        ];
    }

    /**
     * Calculate brick requirements.
     * Formula: Luas dinding * 70 bata per m²
     */
    private function calculateBrick(Request $request): array
    {
        $luas = (float) $request->luas_dinding; // m²

        $bata_per_m2 = 70; // bata merah ukuran standar
        $jumlah_bata = $luas * $bata_per_m2;
        
        // Semen: 1 sak per 100 bata
        $semen = ceil($jumlah_bata / 100);
        
        // Pasir: 0.05 m³ per m² dinding
        $pasir = $luas * 0.05;

        return [
            'type' => 'brick',
            'title' => 'Kalkulator Bata Merah',
            'input' => [
                'luas_dinding' => $luas . ' m²',
            ],
            'output' => [
                'bata_pcs' => ceil($jumlah_bata) . ' buah',
                'semen_sak' => $semen . ' sak (50kg)',
                'pasir_m3' => round($pasir, 2) . ' m³',
            ],
            'tips' => 'Perhitungan untuk bata merah ukuran standar (20x10x5 cm). Tambah 5% untuk rusak/cacat.',
        ];
    }

    /**
     * Calculate steel reinforcement requirements.
     */
    private function calculateSteel(Request $request): array
    {
        $luas = (float) $request->luas_lantai; // m²
        $jenis = $request->jenis; // 'plat' atau 'pondasi'

        if ($jenis === 'plat') {
            // Plat lantai: asumsikan 2 lapis anyaman besi dengan jarak 15cm (150mm)
            // Kira-kira membutuhkan ~16 meter lari per m²
            // 1 batang = 12 meter
            $meter_lari_per_m2 = 16;
            $diameter = 10; // mm
        } else {
            // Pondasi: asumsikan struktur yang lebih rapat/padat
            $meter_lari_per_m2 = 24;
            $diameter = 13; // mm
        }

        $total_meter_lari = $luas * $meter_lari_per_m2;
        $jumlah_besi = ceil($total_meter_lari / 12); // konversi ke batang (12m)
        $berat_per_meter = $diameter === 10 ? 0.62 : 1.04; // kg per meter (10mm = 0.617kg, 13mm = 1.04kg)
        $total_berat = $total_meter_lari * $berat_per_meter; 

        return [
            'type' => 'steel',
            'title' => 'Kalkulator Besi Tulangan',
            'input' => [
                'luas_lantai' => $luas . ' m²',
                'jenis' => $jenis === 'plat' ? 'Plat Lantai' : 'Pondasi/Balok',
            ],
            'output' => [
                'besi_batang' => ceil($jumlah_besi) . ' batang',
                'diameter' => $diameter . ' mm',
                'total_berat' => round($total_berat, 1) . ' kg',
            ],
            'tips' => 'Besi tulangan standar 12m per batang. Konfigurasi aktual bergantung pada gambar struktur dari engineer.',
        ];
    }

    /**
     * Calculate roof material requirements.
     */
    private function calculateRoof(Request $request): array
    {
        $luas = (float) $request->luas_atap; // m²
        $material = $request->material; // 'genteng' atau 'seng'

        if ($material === 'genteng') {
            $genteng_per_m2 = 15; // genteng keramik/beton
            $jumlah = ceil($luas * $genteng_per_m2 * 1.05); // +5% cadangan
            $unit = 'buah';
            $nama_material = 'Genteng Keramik/Beton';
        } else {
            $seng_per_m2 = 1.1; // dengan overlap 10%
            $jumlah = ceil($luas * $seng_per_m2);
            $unit = 'lembar';
            $nama_material = 'Seng/Genteng Metal';
        }

        // Rangka atap (kuda-kuda)
        $kuda_kuda = ceil($luas / 9); // 1 kuda-kuda per 9m²

        return [
            'type' => 'roof',
            'title' => 'Kalkulator Atap',
            'input' => [
                'luas_atap' => $luas . ' m²',
                'material' => $nama_material,
            ],
            'output' => [
                'material_utama' => $jumlah . ' ' . $unit,
                'kuda_kuda' => $kuda_kuda . ' set',
                'usuk' => ceil($luas * 1.2) . ' batang (5x7cm)',
                'reng' => ceil($luas * 3) . ' batang (3x5cm)',
            ],
            'tips' => 'Tambah 5-10% cadangan untuk potongan dan kerusakan. Kebutuhan rangka bervariasi sesuai desain atap.',
        ];
    }
}
