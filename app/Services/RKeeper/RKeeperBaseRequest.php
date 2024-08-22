<?php

namespace App\Services\RKeeper;
use GuzzleHttp;
class RKeeperBaseRequest
{
    public function __construct()
    {

    }

    public function baseRequest($xml)
    {
        $client = new GuzzleHttp\Client;
        $res = $client->request('GET', 'https://109.233.168.27:30001/rk7api/v0/xmlinterface.xml', [
            'auth' => [env("R_KEEPER_USER"), env("R_KEEPER_PASS")],
            'headers' => ['Accept' => 'application/xml'],
            'verify' => false,
            'body'=>  $xml
        ]);
        return $res->getBody()->getContents();
    }
}
