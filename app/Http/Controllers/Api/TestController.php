<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp;


class TestController extends Controller
{
    public function index()
    {
        $username =  "broni";
        $password = "3(7#m7)Tt6Sw";
        $client = new GuzzleHttp\Client;
        $xml = '
        <RK7Query>
            <RK7CMD CMD="GetOrderMenu" >
            <Station code="1"/>
            </RK7CMD>
        </RK7Query>
        ';
        $res = $client->request('GET', 'https://109.233.168.27:30001/rk7api/v0/xmlinterface.xml', [
            'auth' => [$username, $password],
            'headers' => ['Accept' => 'application/xml'],
            'verify' => false,
            'body'=>  $xml
        ]);
        dd($res->getBody()->getContents());
        echo $res->getBody()->getContents();
        echo $res->getStatusCode();
    }
}
