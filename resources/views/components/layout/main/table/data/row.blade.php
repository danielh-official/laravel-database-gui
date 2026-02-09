@php
    $basePath = config('database-gui.base_path', 'db');
@endphp

<div class="flex flex-col gap-8">
    <div class="self-end flex gap-4">
        <a href="{{ route("$basePath.table.data.show", ['table' => $table, 'id' => $row->id ?? $row->key]) }}"
            @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs(
                    "$basePath.table.data.show"),
            ])>
            Details
        </a>
        <a href="{{ route("$basePath.table.data.edit", ['table' => $table, 'id' => $row->id ?? $row->key]) }}"
            @class([
                'hover:text-blue-600 dark:text-gray-400',
                'font-semibold text-blue-500' => request()->routeIs(
                    "$basePath.table.data.edit"),
            ])>
            Edit
        </a>
        <form action="{{ route("$basePath.table.data.destroy", ['table' => $table, 'id' => $row->id ?? $row->key]) }}" method="POST"
            class="inline" onsubmit="return confirm('Are you sure you want to delete this row?');">

            @csrf
            @method('DELETE')

            <button type="submit" class="text-red-500 hover:underline">Delete</button>
        </form>
    </div>

    <div>
        {{ $slot }}
    </div>

</div>
