<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body class="font-sans antialiased">

<div class="min-h-screen flex items-center justify-center bg-slate-950">

    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/20 via-transparent to-cyan-500/20">
    </div>


    <div class="relative w-full max-w-md">


        <div class="bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-3xl p-8">


            <div class="flex justify-center mb-6">
                <x-application-logo class="w-24 h-24 fill-current text-orange-400"/>
            </div>


            <h1 class="text-center text-3xl font-bold text-white mb-2">
                Global Supply Chain AI
            </h1>


            <p class="text-center text-gray-300 mb-6">
                Export Risk Intelligence Platform
            </p>


            {{ $slot }}


        </div>

    </div>

</div>


</body>
</html>