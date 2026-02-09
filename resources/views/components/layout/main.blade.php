<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@php
    $basePath = config('database-gui.base_path', 'db');
    $appRoute = config('database-gui.app_path', '/');
    $homeRoute = route("$basePath.home");
    $sqlRoute = route("$basePath.sql");
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }} | DB ({{ config('app.name', 'Laravel') }})</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] p-6 lg:p-8 lg:justify-center transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 gap-4">
    <div class="flex p-6 lg:p-8 sm:items-center sm:justify-center  w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 gap-4 sm:flex-row flex-col">
        {{-- List of database tables for current connection --}}
        <div class="flex flex-col sticky top-6 self-start h-full border-r border-[#e3e3e0] dark:border-[#3E3E3A] pr-4">
            <a href="{{ $appRoute }}" class="hover:text-blue-600 hover:underline dark:text-gray-400">Return</a>
            <hr class="my-4 border-white" />
            <div class="flex flex-col gap-y-2">
                <a href="{{ $homeRoute }}" @class([
                    'hover:text-blue-600 dark:text-gray-400',
                    'font-semibold text-blue-500' => request()->routeIs("$basePath.home"),
                ])>Home</a>
                <a href="{{ $sqlRoute }}" @class([
                    'hover:text-blue-600 dark:text-gray-400',
                    'font-semibold text-blue-500' => request()->routeIs("$basePath.sql"),
                ])>SQL</a>
            </div>
            <hr class="my-4 border-white" />
            <div class="flex flex-col gap-1">
                <h2 class="font-semibold mb-2 dark:text-white">Tables</h2>
                @foreach ($tables as $table)
                    @isset($selectedTable)
                        <a href="{{ route("$basePath.table.data.index", $table['name']) }}" @class([
                            'hover:text-blue-600 dark:text-gray-400',
                            'font-semibold text-blue-500' => $table['name'] === $selectedTable,
                            'text-gray-500' => $table['name'] !== $selectedTable,
                        ])>
                            {{ $table['name'] }}
                        </a>
                    @else
                        <a href="{{ route("$basePath.table.data.index", $table['name']) }}" @class(['hover:text-blue-600 dark:text-gray-400'])>
                            {{ $table['name'] }}
                        </a>
                    @endisset
                @endforeach
            </div>
        </div>
        <main
            class="flex flex-col text-[13px] leading-5 flex-1 p-6 pb-12 lg:p-10 dark:text-[#EDEDEC] m-3 overflow-y-auto overflow-x-auto">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
