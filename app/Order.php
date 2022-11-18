<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;
//use AutoNumberTrait;

class Order extends Model
{
    use AutoNumberTrait;
    protected $fillable = [
        'invoice', 'totalPayment', 'paymentStatus', 'orderStatus','address',
        'estimationDate','deliveries_id','payment_method_id','shipping_method_id',
        'user_id'
    ];

    protected $hidden = [

    ];

    public function items()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getAutoNumberOptions()
    {
        return [
            'invoice' => [
                'format' => 'INV-?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 5 // The number of digits in an autonumber
            ]
        ];
    }

    // public function getAutoNumberOptions()
    // {
    //     return [
    //         'order_number' => [
    //             'format' => function () {
    //                 return 'INV-' . date('Ymd') . '-?'; // autonumber format. '?' will be replaced with the generated number.
    //             },
    //             'length' => 5 // The number of digits in the autonumber
    //         ]
    //     ];
    // }
}
