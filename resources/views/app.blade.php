<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript"
                src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{config('midtrans.client_key')}}"></script>

        <title inertia>{{ config('app.name', 'PondasiKu') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" sizes="32x32" href="{{ url('/images/logo/favicon-32.svg') }}" />
        <link rel="icon" type="image/svg+xml" sizes="16x16" href="{{ url('/images/logo/favicon-16.svg') }}" />
        
        <!-- Open Graph -->
        <meta property="og:title" content="PondasiKu - Material Bangunan Berkualitas" />
        <meta property="og:description" content="Toko material bangunan online dengan kalkulator material, shipping, dan payment gateway." />
        <meta property="og:image" content="{{ url('/images/logo/og-image.png') }}" />
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary_large_image" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="antialiased bg-surface text-ink">
        @inertia
    </body>
</html>
