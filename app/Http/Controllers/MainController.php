<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    private function showRawData(mixed $data)
    {
        echo '<pre>';

        print_r($data);

        echo '</pre>';
    }

    private function showDataTable(mixed $data)
    {
        echo '<table border=1>';

        echo '<tr>';

        foreach ($data[0] as $key => $value) {
            echo '<th>' . $key . '</th>';
        }

        echo '</tr>';

        echo '<tr>';

        foreach ($data as $row) {
            echo '<tr>';

            foreach ($row as $value) {
                echo '<th>' . $value . '</th>';
            }

            echo '</tr>';
        }

        echo '</tr>';

        echo '</table>';
    }

    public function index()
    {
        // INSERT 
        // $new_client = [
        //     'client_name' => 'Felipe',
        //     'email' => 'felipe@gmail.com',
        //     'active' => 1,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ];

        // UPDATE

        // DB::table('clients')
        //     ->where('id', 1)
        //     ->update([
        //         'client_name' => 'Felipão',
        //         'updated_at' => now()
        //     ]);

        // DELETE

        // hard delete
        DB::table('clients')->delete(1);

        // soft delete
        DB::table('clients')
            ->where('id', 2)
            ->update([
                'deleted_at' => now()
            ]);

        $clients = DB::table('clients')
            ->whereNull('deleted_at')
            ->find(2);

        $this->showRawData($clients);
    }
}
