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

        if(!Auth::check()) {
            return response()->json(['errors'=>  ['auth' => 'Вы должны авторизоваться на сайте']], 422);
        }
        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => Auth::user()->name,
            'amount' => $request->amount,
            'orderIdent' => $request-> get('table')['OrderIdent'],
            'visit' => $request-> get('table')['Visit'],
            'table' => $request-> get('table')['Table'],
        ]);
        foreach ($request -> products as $product) {
           $orderItem = OrderItem::create([
               'product_id' => $product['id'],
               'order_id' => $order->id,
                'title' => $product['title'],
               'quantity' => $product['quantity'],
               'price' => $product['price'],
               'cost' => $product['price'] * $product['quantity'],
           ]);
           if(isset($product['comment'])) {
               $orderItem -> comment = $product['comment'];
               $orderItem -> save();
           }
        }
        $this->rKeeperOrder->saveOrder($order);
        return $order;
    }
}
