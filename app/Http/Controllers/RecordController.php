<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RecordController extends Controller
{
    public function index(): array
    {
        $file = File::get(storage_path('database/mock.txt'));

        $records = explode(PHP_EOL, $file);

        $columnsRecord = array_shift($records);

        $columns = explode(',', $columnsRecord);

        return array_map(static function ($record) use ($columns) {
            if ($record === '') {
                return false;
            }

            $explodedRecord = explode(',', $record);

            return [
                $columns[0] => $explodedRecord[0],
                $columns[1] => $explodedRecord[1],
                $columns[2] => $explodedRecord[2],
                $columns[3] => $explodedRecord[3],
                $columns[4] => $explodedRecord[4],
                $columns[5] => $explodedRecord[5]
            ];
        },
            $records);
    }
}
