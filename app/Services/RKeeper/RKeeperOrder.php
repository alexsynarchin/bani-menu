<?php

namespace App\Services\RKeeper;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\RKeeper\RKeeperBaseRequest;
class RKeeperOrder
{
    protected RKeeperBaseRequest $rKeeperBaseRequest;
    protected Order $order;
    protected string $stationID;

    public function __construct(RKeeperBaseRequest $rKeeperBaseRequest, Order $order)
    {
        $this->rKeeperBaseRequest = $rKeeperBaseRequest;
        $this->order = $order;
    }

    public function saveOrder($order)
    {
        $this->order = $order;
        $this->getOrder();
            $orderItems = OrderItem::where('order_id', $this->order->id) -> with('product')->get();
        $dishes = '';
        foreach ($this -> order -> orderItems as $orderItem) {
            $comment = '';
            if($orderItem -> comment) {
                $comment =  '<Modi code="1174" openName="'.$orderItem -> comment.'"/>';
            }
           $dishes .= '<Dish id="'.$orderItem -> product -> r_id.'" quantity="'. $orderItem -> quantity * 1000
               .'">' . $comment .'</Dish>' . PHP_EOL;
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <RK7Query>
         <RK7CMD CMD="SaveOrder" sendtovdu="true">
          <Order visit="'. $this -> order -> visit .'"orderIdent="'.$this -> order -> orderIdent . '"
           persistentComment="'.$order->comment .'"/>
          <Session>
            <Station id="'. $this -> stationID .'"/> ' . PHP_EOL .
            $dishes  . '<Course code="3"/>
          </Session>
         </RK7CMD>
        </RK7Query>
        ';
        $result = $this->rKeeperBaseRequest->baseRequest($xml);


    }
    public function getOrder()
    {


        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<RK7Query>
                <RK7Command CMD="GetOrder">
                    <Order visit="'. $this -> order -> visit .'" orderIdent="'.$this -> order -> orderIdent . '"/>
                </RK7Command>
            </RK7Query>';
        $orderXml = simplexml_load_string($this->rKeeperBaseRequest->baseRequest($xml));
        $this -> stationID = (string) $orderXml->CommandResult->Order->Station['id'];
    }





}
