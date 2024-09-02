<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Laravue\Models\User;
class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'quantity', 'amount',  'name', 'orderIdent', 'visit', 'table'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
