<x-database-gui::layout.main :tables="$tables" :selectedTable="$table" title="Info | {{ $table }} Table">
    <x-database-gui::layout.main.table :table="$table">
        <h2 class="text-2xl font-semibold">
            Table Info
        </h2>
        <table class="table-auto border-collapse border border-gray-300">
            <tbody>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $table === null,
                    ])>{{ $table }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Rows</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $rowCount === 0,
                    ])>{{ $rowCount }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Columns</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => count($columns) === 0,
                    ])>{{ count($columns) }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Engine</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $engine === null,
                    ])>{{ $engine ?? 'n/a' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Collation</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $collation === null,
                    ])>{{ $collation ?? 'n/a' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Comment</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $comment === null,
                    ])>{{ $comment ?? 'n/a' }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Create Query</th>
                    <td @class([
                        'border border-gray-300 px-4 py-2',
                        'text-gray-500' => $createQuery === null,
                    ])>
                        <span
                            class="font-mono text-sm text-gray-700 dark:text-gray-300">{{ $createQuery ?? 'n/a' }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </x-database-gui::layout.main.table>
</x-database-gui::layout.main>
