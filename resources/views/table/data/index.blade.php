@php
    $basePath = config('laravel-database-gui.base_path', 'db');
@endphp

<x-database-gui::layout.main :tables="$tables" :selectedTable="$table" title="Data | {{ $table }} Table">
    <x-database-gui::layout.main.table :table="$table">
        <div class="flex gap-x-2">
            <form id="reset-form" class="mb-4" action="{{ route("$basePath.table.data.index", ['table' => $table]) }}"
                method="GET">
                <button type="submit"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                    Reset
                </button>
            </form>
            <form id="table-sort-form-show-toggle-form" class="mb-4">
                @if (request()->has('page'))
                    <input type="hidden" name="page" value="{{ request('page') }}">
                @endif
                @if (isset($showSortForm) && $showSortForm)
                    <input type="hidden" name="show_sort_form" value="0">
                    <button
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Hide
                        Sort
                        Form</button>
                @else
                    <input type="hidden" name="show_sort_form" value="1">
                    <button
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Show
                        Sort
                        Form</button>
                @endif
                @if (request()->has('sort'))
                    @foreach (request('sort') as $column => $direction)
                        <input type="hidden" name="sort[{{ $column }}]" value="{{ $direction }}">
                    @endforeach
                @endif
            </form>
        </div>
        @if (isset($showSortForm) && $showSortForm)
            <form id="table-sort-form" method="GET"
                action="{{ route("$basePath.table.data.index", ['table' => $table]) }}"
                class="mb-6 rounded-lg border border-gray-200 p-4 shadow-sm">
                @if (request()->has('page'))
                    <input type="hidden" name="page" value="{{ request('page') }}">
                @endif
                @if (request()->has('show_sort_form'))
                    <input type="hidden" name="show_sort_form" value="{{ request('show_sort_form') }}">
                @endif
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($columns as $column)
                        <label
                            class="flex flex-col items-center justify-between gap-3 rounded-md border border-gray-200 px-3 py-2">
                            <span class="text-sm font-medium text-gray-700">{{ $column }}</span>
                            <select name="sort[{{ $column }}]"
                                class="rounded-md border border-gray-300 px-2 py-1 text-sm">
                                <option value="" @selected(($sorts[$column] ?? '') === '')>No Sort</option>
                                <option value="asc" @selected(($sorts[$column] ?? '') === 'asc')>Ascending</option>
                                <option value="desc" @selected(($sorts[$column] ?? '') === 'desc')>Descending</option>
                            </select>
                        </label>
                    @endforeach
                </div>
                <div class="mt-4 flex items-center justify-end">
                    <button type="submit"
                        class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                        Apply
                    </button>
                </div>
            </form>
        @endif

        <div class="w-full overflow-x-auto">
            <table class="table-auto border-collapse border border-gray-300">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th class="border border-gray-300 px-4 py-2">{{ $column }}</th>
                        @endforeach
                        @if (isset($rows[0]->id) || isset($rows[0]->key))
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $row)
                        <tr>
                            @foreach ($columns as $column)
                                @if ($row->$column)
                                    <td class="border border-gray-300 px-4 py-2 truncate max-w-64">
                                        {{ $row->$column }}
                                    </td>
                                @elseif ($row->$column === '')
                                    <td class="border border-gray-300 px-4 py-2">-</td>
                                @else
                                    <td class="border border-gray-300 px-4 py-2 text-gray-400">NULL</td>
                                @endif
                            @endforeach
                            @if (isset($row->id) || isset($row->key))
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route("$basePath.table.data.show", ['table' => $table, 'id' => $row->id ?? $row->key]) }}"
                                        class="text-blue-500 hover:underline">View</a>
                                    <a href="{{ route("$basePath.table.data.edit", ['table' => $table, 'id' => $row->id ?? $row->key]) }}"
                                        class="text-yellow-500 hover:underline">Edit</a>
                                    <form
                                        action="{{ route("$basePath.table.data.destroy", ['table' => $table, 'id' => $row->id ?? $row->key]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this row?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="my-4">
            {{ $rows->links() }}
        </div>
    </x-database-gui::layout.main.table>
</x-database-gui::layout.main>
