<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\RKeeper\RKeeperOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected RKeeperOrder $rKeeperOrder;

    public function __construct(RKeeperOrder $rKeeperOrder)
    {
        $this -> rKeeperOrder = $rKeeperOrder;
    }

    public function saveOrder(Request $request)
    {


        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'amount' => $request->amount,
            'orderIdent' => $request-> get('table')['OrderIdent'],
            'visit' => $request-> get('table')['Visit'],
            'table' => $request-> get('table')['Table'],
        ]);
        foreach ($request -> products as $product) {
           OrderItem::create([
               'product_id' => $product['id'],
               'order_id' => $order->id,
                'title' => $product['title'],
               'quantity' => $product['quantity'],
               'comment' => $product['comment'],
               'price' => $product['price'],
               'cost' => $product['price'] * $product['quantity'],
           ]);
        }
        $this->rKeeperOrder->saveOrder($order);
        return $order;
    }
}
