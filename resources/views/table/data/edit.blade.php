@php
    $basePath = config('database-gui.base_path', 'db');
@endphp

<x-database-gui::layout.main :tables="$tables" :selectedTable="$table"
    title="Edit | Row {{ $row->id ?? $row->key ?? null }} | Data | {{ $table }} Table">
    <x-database-gui::layout.main.table :table="$table">
        <x-database-gui::layout.main.table.data.row :table="$table" :row="$row">
            <form action="{{ route("$basePath.table.data.update", ['table' => $table, 'id' => $row->id ?? $row->key]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($columns as $column)
                        @if (!($column['auto_increment'] ?? false))
                            <div class="mb-4">
                                <label for="{{ $column['name'] }}" class="block text-sm font-medium text-gray-700">
                                    {{ $column['name'] }}
                                    @if (!($column['nullable'] ?? false))
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <input type="{{ convert_sql_to_html_input_type($column['type']) }}" name="{{ $column['name'] }}"
                                    id="{{ $column['name'] }}" @required(!($column['nullable'] ?? false))
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:focus:border-indigo-500 dark:focus:ring-indigo-500"
                                    value="{{ $row->{$column['name']} }}" autocomplete="off" />
                                @isset($errors)
                                    @error($column['name'])
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                @endisset
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <button type="submit"
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                        Update
                    </button>
                </div>
            </form>
        </x-database-gui::layout.main.table.data.row>
    </x-database-gui::layout.main.table>
</x-database-gui::layout.main>
