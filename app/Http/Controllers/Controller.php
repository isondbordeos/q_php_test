<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        $response = Http::post('https://symfony-skeleton.q-tests.com/api/v2/token', [
            'email' => 'ahsoka.tano@q.agency',
            'password' => 'Kryze4President',
        ]);

        $response = json_decode($response, 1);
        echo "<pre>";
        print_r($response);
    }
}
