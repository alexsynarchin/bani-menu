<?php

namespace App\Services\RKeeper;
use App\Services\RKeeper\RKeeperBaseRequest;
class RKeeperGetOpenTables
{
    protected RKeeperBaseRequest $rKeeperBaseRequest;
    public function __construct(RKeeperBaseRequest $rKeeperBaseRequest)
    {
        $this->rKeeperBaseRequest = $rKeeperBaseRequest;
    }

    public function getTables(): array
    {
        $resultXml = $this->getOrders();
        $tables = $this -> ordersXmlToArray($resultXml);
        return $tables;
    }

    private function getOrders()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <RK7Query>
                     <RK7CMD CMD="GetOrders">
                     </RK7CMD>
                </RK7Query>';

        return  $this->rKeeperBaseRequest->baseRequest($xml);

    }

    private function ordersXmlToArray($resultXml)
    {
        $ordersXml = simplexml_load_string($resultXml);

        $orders = [];
        foreach ($ordersXml -> OrdersList -> rbrow as $orderItem) {
                if($orderItem -> Paid == 0) {
                    $orders[] = [
                        'OrderIdent' => (int) $orderItem->OrderIdent,
                        'Visit' => (int) $orderItem->Visit,
                        'Table' => (string) $orderItem->Table,
                    ];
                }

        }

        return $orders;
    }



}
