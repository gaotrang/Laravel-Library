<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order';

    const STATUS = [
        'pending' => 'pending',
        'success' => 'success',
        'cancel' => 'cancel',
        'shipping' => 'shipping',
        'failed' => 'failed',
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCEL = 'cancel';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_FAILED = 'failed';


    protected $fillable = [
        'user_id',
        'address',
        'city',
        'note',
        'status',
        'payment_method',
        'subtotal',
        'total'
    ];

    public function order_payment_methods()
    {
        return $this->hasMany(OrderPaymentMethod::class, 'order_id');
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}