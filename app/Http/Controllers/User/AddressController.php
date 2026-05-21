<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function __construct(private readonly ShippingService $shippingService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id = $request->user()->id;
        $address  = UserAddress::with('user')
            ->where('user_id', $id)
            ->when($request->search, function ($query, $search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('type', 'like', '%' . $search . '%')
                        ->orWhere('province', 'like', '%' . $search . '%')
                        ->orWhere('address1', 'like', '%' . $search . '%')
                        ->orWhere('no_hp', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10)->withQueryString();

        return Inertia::render('User/UserAddress/Index',[
            'address' => $address,
            'provinces' => $this->shippingService->getProvinces(),
        ]);
    }

    public function getCity($id)
    {
        return response()->json(['data' => $this->shippingService->getCitiesByProvince($id)]);
    }

    public function getProvince()
    {
        return response()->json(['data' => $this->shippingService->getProvinces()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'isMain' => $request->boolean('isMain'),
            'country_code' => $request->input('country_code') ?: 'ID',
        ]);

        $validated = $request->validate([
            'type' => ['required', 'string', 'max:45'],
            'address1' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'isMain' => ['required', 'boolean'],
            'postcode' => ['required', 'string', 'max:45'],
            'country_code' => ['required', 'string', 'max:3'],
            'city_id' => ['required', 'integer'],
            'prov_id' => ['required', 'integer'],
        ]);

        if ($validated['isMain']) {
            UserAddress::where('user_id', $request->user()->id)->update(['isMain' => false]);
        }

        $address = new UserAddress;
        $address->type = $validated['type'];
        $address->address1 = $validated['address1'];
        $address->no_hp = $validated['no_hp'];
        $address->isMain = $validated['isMain'];
        $address->postcode = $validated['postcode'];
        $address->country_code = $validated['country_code'];
        $address->city_id = $validated['city_id'];
        $address->prov_id = $validated['prov_id'];
        $address->user_id = $request->user()->id;

        $location = $this->shippingService->resolveAddressLocation($validated['prov_id'], $validated['city_id']);
        $address->province = $location['province'];
        $address->city = $location['city'];

        if ($address->save()){
            return redirect()->route('address')->with('success', 'Address created successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create address');
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->merge([
            'isMain' => $request->boolean('isMain'),
            'country_code' => $request->input('country_code') ?: 'ID',
        ]);

        $validated = $request->validate([
            'type' => ['required', 'string', 'max:45'],
            'address1' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'isMain' => ['required', 'boolean'],
            'postcode' => ['required', 'string', 'max:45'],
            'country_code' => ['required', 'string', 'max:3'],
            'city_id' => ['required', 'integer'],
            'prov_id' => ['required', 'integer'],
        ]);

        $address = UserAddress::where('user_id', $request->user()->id)->findOrFail($id);
        if ($validated['isMain']) {
            UserAddress::where('user_id', $request->user()->id)
                ->where('id', '!=', $address->id)
                ->update(['isMain' => false]);
        }

        $address->type = $validated['type'];
        $address->address1 = $validated['address1'];
        $address->no_hp = $validated['no_hp'];
        $address->isMain = $validated['isMain'];
        $address->postcode = $validated['postcode'];
        $address->country_code = $validated['country_code'];
        $address->city_id = $validated['city_id'];
        $address->prov_id = $validated['prov_id'];
        $address->user_id = $request->user()->id;

        $location = $this->shippingService->resolveAddressLocation($validated['prov_id'], $validated['city_id']);
        $address->province = $location['province'];
        $address->city = $location['city'];

        if ($address->save()){
            return redirect()->route('address')->with('success', 'Address updated successfully.');
        }else{
            return redirect()->back()->with('errors', 'Failed create address');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);
        if($address){
            $address->delete();
        }
        return redirect()->route('address')->with('success', 'Address deleted successfully.');
    }
}
