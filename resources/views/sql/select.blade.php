@php
    $basePath = config('database-gui.base_path', 'db');
    $sqlRoute = route("$basePath.sql");
@endphp

<x-database-gui::layout.main :tables="$tables" title="SQL Select">
    <div class="flex flex-col gap-4">
        <div class="p-4 text-center">
            <form action="{{ route("$basePath.sql") }}" method="GET">
                <textarea name="query" rows="2" class="w-full p-2 border border-gray-300 rounded"
                    placeholder="Enter your SQL SELECT query here...">{{ old('query') ?? $query }}</textarea>
                @isset($error)
                    <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
                @endisset
                <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Execute</button>
            </form>
        </div>
        @if (isset($results) && count($results) > 0)
            <div class="text-end">
                {{-- Export Button --}}
                <form action="{{ route("$basePath.sql.results.export") }}" method="POST">
                    @csrf
                    <input type="hidden" name="query" value="{{ $query }}">
                    <button type="submit" class="mt-2 px-4 py-2 bg-slate-500 text-white rounded">Export</button>
                </form>
            </div>
        @endif
        <div class="w-full overflow-x-auto flex flex-col gap-4">
            @if (isset($results) && count($results) > 0)
                <div>
                    <h2 class="text-lg font-semibold">Query Stats</h2>
                    <ul class="list-disc list-inside">
                        <li>Count: {{ count($results) }}</li>
                        <li>Time To Result: {{ $timeToResult }} ms</li>
                    </ul>
                </div>
                <table class="table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            @foreach (array_keys((array) $results[0]) as $column)
                                <th class="border border-gray-300 px-4 py-2">{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $row)
                            <tr>
                                @foreach ((array) $row as $value)
                                    <td class="border border-gray-300 px-4 py-2">{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif ($query)
                <p class="text-gray-500 text-sm mt-2 text-center">No results found.</p>
            @endif
        </div>
    </div>
</x-database-gui::layout.main>