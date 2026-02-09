<x-database-gui::layout.main :tables="$tables" :selectedTable="$table" title="Structure | {{ $table }} Table">
    <x-database-gui::layout.main.table :table="$table">
        {{-- This should be a table with the following fields: Name, Type, Collation, Nullable, Default, Auto Increment, Comment, Generation --}}
        <h2 class="text-2xl font-semibold">
            Table Structure
        </h2>
        <table class="table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Type</th>
                    <th class="border border-gray-300 px-4 py-2">Collation</th>
                    <th class="border border-gray-300 px-4 py-2">Nullable</th>
                    <th class="border border-gray-300 px-4 py-2">Default</th>
                    <th class="border border-gray-300 px-4 py-2">Auto Increment</th>
                    <th class="border border-gray-300 px-4 py-2">Comment</th>
                    <th class="border border-gray-300 px-4 py-2">Generation</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($columns as $column)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $column['name'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $column['type'] }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => $column['collation'] === null,
                        ])>{{ $column['collation'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'font-semibold' => empty($column['nullable']),
                        ])>{{ $column['nullable'] ? 'Yes' : 'No' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($column['default']),
                        ])>{{ $column['default'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($column['auto_increment']),
                        ])>{{ $column['auto_increment'] ? 'Yes' : 'No' }}
                        </td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($column['comment']),
                        ])>{{ $column['comment'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($column['generation']),
                        ])>{{ $column['generation'] ?? 'n/a' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="border border-gray-300 px-4 py-2 text-gray-500 text-center">No columns
                            found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Indexes --}}
        <h2 class="text-2xl font-semibold">
            Indexes
        </h2>
        <table class="table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Type</th>
                    <th class="border border-gray-300 px-4 py-2">Columns</th>
                    <th class="border border-gray-300 px-4 py-2">Unique</th>
                    <th class="border border-gray-300 px-4 py-2">Primary</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($indexes as $index)
                    <tr>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($index['name']),
                        ])>{{ $index['name'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($index['type']),
                        ])>{{ $index['type'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($index['columns']),
                        ])>{{ implode(', ', $index['columns']) }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($index['unique']),
                        ])>{{ $index['unique'] ? 'Yes' : 'No' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($index['primary']),
                        ])>{{ $index['primary'] ? 'Yes' : 'No' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border border-gray-300 px-4 py-2 text-gray-500 text-center">No indexes
                            found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Foreign Keys --}}
        <h2 class="text-2xl font-semibold">
            Foreign Keys
        </h2>
        <table class="table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Name</th>
                    <th class="border border-gray-300 px-4 py-2">Column</th>
                    <th class="border border-gray-300 px-4 py-2">Referenced Table</th>
                    <th class="border border-gray-300 px-4 py-2">Referenced Column</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($foreignKeys as $foreignKey)
                    <tr>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($foreignKey['name']),
                        ])>{{ $foreignKey['name'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($foreignKey['column']),
                        ])>{{ $foreignKey['column'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($foreignKey['referenced_table']),
                        ])>{{ $foreignKey['referenced_table'] ?? 'n/a' }}</td>
                        <td @class([
                            'border border-gray-300 px-4 py-2',
                            'text-gray-500' => empty($foreignKey['referenced_column']),
                        ])>{{ $foreignKey['referenced_column'] ?? 'n/a' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-gray-300 px-4 py-2 text-gray-500 text-center">No foreign
                            keys found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-database-gui::layout.main.table>
</x-database-gui::layout.main>
