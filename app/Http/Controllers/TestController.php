<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Location;
use App\Models\Party;

class TestController extends Controller
{
    public function index()
    {
        /*
        $data = Location::all();
        if($data->count()){
            echo 'Location[';
            foreach($data as $d){
                echo '
                        {
                            "short_name":"'.$d->short_name.'",
                            "title":"'.$d->title.'",
                            "address":"'.$d->address.'"
                        },
                    ';
            }
            echo ']';
        }
        */

        //$data = Party::all();
        $data = Party::withTrashed()->all();
        echo "<pre>";
        print_r($data);
        if($data->count()){
            echo 'Party[';
            foreach($data as $d){
                echo '
                        {
                            "short_name":"'.$d->short_name.'",
                            "party_type_id":"'.$d->party_type_id.'",
                            "title":"'.$d->title.'",
                            "address":"'.$d->address.'",
                            "email":"'.$d->email.'",
                            "contact":"'.$d->contact.'",
                            "bank_name":"'.$d->bank_name.'",
                            "iban":"'.$d->iban.'",
                            "contact_person":"'.$d->contact_person.'"
                        },
                    ';
            }
            echo ']';
        }

    }
}
