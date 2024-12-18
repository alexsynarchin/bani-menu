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

    /**
     * @param RKeeperBaseRequest $rKeeperBaseRequest
     * @param Order $order
     */
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
            $quantityMultiplier = 1000;
            if($orderItem->divider) {
                $quantityMultiplier = $orderItem->divider;
            }
            $comment = '';
            if($orderItem -> comment) {
                $comment =  '<Modi code="151" openName="'.$orderItem -> comment.'"/>';
            }
           $dishes .= '<Dish id="'.$orderItem -> product -> r_id.'" quantity="'. $orderItem -> quantity * $quantityMultiplier
               .'">' . $comment .'</Dish>' . PHP_EOL;
        }
        $waiter = '';
        $user = $this->order -> user;

        if($user -> r_code) {
            $waiter = '<Author code="'.$user -> r_code.'"/>' . PHP_EOL;
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <RK7Query>
         <RK7CMD CMD="SaveOrder" sendtovdu="true">
          <Order visit="'. $this -> order -> visit .'"orderIdent="'.$this -> order -> orderIdent . '"
           persistentComment="'.$order->comment .'"/>
          <Session>
            '.$waiter.'
            <Station id="'. $this -> stationID .'"/> ' . PHP_EOL .
            $dishes  . '
          </Session>
         </RK7CMD>
        </RK7Query>
        ';

        $result = $this->rKeeperBaseRequest->baseRequest($xml);

        return simplexml_load_string($result);
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
