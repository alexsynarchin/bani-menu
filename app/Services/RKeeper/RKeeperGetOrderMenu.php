<?php

namespace App\Services\RKeeper;
use App\Services\RKeeper\RKeeperBaseRequest;
class RKeeperGetOrderMenu
{

    protected RKeeperBaseRequest $rKeeperBaseRequest;
    public function __construct(rKeeperBaseRequest $rKeeperBaseRequest)
    {
        $this->rKeeperBaseRequest = $rKeeperBaseRequest;
    }

    public function execute() {
        $xml = '<RK7Query>
                    <RK7CMD CMD="GetRefData" RefName="MENUITEMS" onlyActive="1"/>
                </RK7Query>';
        return simplexml_load_string($this->rKeeperBaseRequest->baseRequest($xml));
    }


}
