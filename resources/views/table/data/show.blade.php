@php
    $rowJson = json_encode($row, JSON_PRETTY_PRINT);
    $json = '<pre style="white-space: pre-wrap; word-break: break-word;">' . htmlspecialchars($rowJson) . '</pre>';
@endphp

<x-database-gui::layout.main :tables="$tables" :selectedTable="$table"
    title="Details | Row {{ $row->id ?? ($row->key ?? null) }} | Data | {{ $table }} Table">
    <x-database-gui::layout.main.table :table="$table">
        <x-database-gui::layout.main.table.data.row :table="$table" :row="$row">
            <div style="justify-items:center;">
                {!! $json !!}
            </div>
        </x-database-gui::layout.main.table.data.row>
    </x-database-gui::layout.main.table>
</x-database-gui::layout.main>
