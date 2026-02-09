<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class ExportSqlResultsController
{
    public function __invoke(\Illuminate\Http\Request $request)
    {
        $query = $request->input('query');

        try {
            $results = \DB::select($query);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['query' => $e->getMessage()]);
        }

        // Export logic here (e.g., CSV, Excel)
        $filename = 'export.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array_keys((array) $results[0]));

        foreach ($results as $row) {
            fputcsv($handle, (array) $row);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
