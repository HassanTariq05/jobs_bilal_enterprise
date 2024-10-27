<?php

namespace App\Exports;

use App\Models\Party;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartiesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //return Party::all();
        return Party::select('id', 'title', 'email', 'contact')->get();
/*
        $output = "";
        $rows = '';

        $parties =  Party::select('id', 'title')->all();
        $c = 1;
        foreach ($parties as $party) {
            $rows .= '<tr>
                        <td>' . $c . '</td>
                        <td>' . $party->title . '</td>
                    </tr>';
            $c++;
        }

        $output = "
                    <table>
                        <tr>
                            <th>S.No.</th>
                            <th>Party Name</th>
                        </tr>
                        $rows
                    </table>
                ";

        return $output;
        */
    }
}
