@php
    $basePath = config('laravel-database-gui.base_path', 'db');
@endphp

<div class="flex flex-col gap-20">
    <div class="self-end flex gap-4 flex-col">
        <div class="self-end flex gap-4">
            <a href="{{ route("$basePath.table.data.index", ['table' => $table]) }}" @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs("$basePath.table.data.index"),
            ])>
                Data
            </a>
            <a href="{{ route("$basePath.table.structure", ['table' => $table]) }}" @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs(
                    "$basePath.table.structure"),
            ])>
                Structure
            </a>
            <a href="{{ route("$basePath.table.info", ['table' => $table]) }}" @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs("$basePath.table.info"),
            ])>
                Info
            </a>
        </div>
        <div class="self-end flex gap-4">
            <a href="{{ route("$basePath.table.data.create", ['table' => $table]) }}" @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs(
                    "$basePath.table.data.create"),
            ])>
                Insert Data
            </a>
        </div>
    </div>
    <div class="flex flex-col gap-2">
        {{ $slot }}
    </div>
</div>
