<?php

use App\ServiceCategory;
use App\PaymentMethode;
use App\ShippingMethode;
use App\Service;
use App\Cart;
use App\OrderDetail;
use App\Order;
use App\Payment;
use App\Delivery;
use App\Address;
use App\User;
use App\Admin;
use App\Client;
use App\Taylor;
use App\Convection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        $a = 42;
        for($i = 22; $i <= 23; $i++) {
            $order = Order::insert([
                'invoice' => 'INVOICE'.'-'.$i,
                'totalPayment' => 280000,
                'paymentStatus' => 'BELUM BAYAR',
                'orderStatus'=> 'Menunggu Pickup',
                'address' => 'Bandung',
                'estimationDate' => date('Y-m-d H:i:s'),
                'deliveries_id' => 1,
                'payment_method_id' => 1,
                'shipping_method_id' => 1,
                'user_id' => $a,
                'created_at' => date('Y-m-d H:i:s'),

            ]);
            $a++;
        }

        for($i = 21; $i <= 22; $i++) {
            $order = Payment::insert([
                'paymentAmount' => 0,
                'order_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for($i = 21; $i <= 22; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 145000,
                'service_id'  => 1,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
        }

        for($i = 21; $i <= 22; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 135000,
                'service_id'  => 21,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
        }

        // Taylor Id 3
        $a = 44;
        for($i = 24; $i <= 25; $i++) {
            $order = Order::insert([
                'invoice' => 'INVOICE'.'-'.$i,
                'totalPayment' => 280000,
                'paymentStatus' => 'BELUM BAYAR',
                'orderStatus'=> 'Menunggu Pickup',
                'address' => 'Bandung',
                'estimationDate' => date('Y-m-d H:i:s'),
                'deliveries_id' => 1,
                'payment_method_id' => 1,
                'shipping_method_id' => 1,
                'user_id' => $a,
                'created_at' => date('Y-m-d H:i:s'),

            ]);
            $a++;
        }

        for($i = 23; $i <= 24; $i++) {
            $order = Payment::insert([
                'paymentAmount' => 0,
                'order_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        for($i = 23; $i <= 24; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 145000,
                'service_id'  => 3,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
        }

        for($i = 23; $i <= 24; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 135000,
                'service_id'  => 23,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
        }



        // Taylor Id 3

        for($i = 26; $i <= 42; $i++) {
            $order = Order::insert([
                'invoice' => 'INVOICE'.'-'.$i,
                'totalPayment' => 280000,
                'paymentStatus' => 'BELUM BAYAR',
                'orderStatus'=> 'Menunggu Pickup',
                'address' => 'Bandung',
                'estimationDate' => date('Y-m-d H:i:s'),
                'deliveries_id' => 1,
                'payment_method_id' => 1,
                'shipping_method_id' => 1,
                'user_id' => $faker->numberBetween(2,11),
                'created_at' => date('Y-m-d H:i:s'),

            ]);

        }

        for($i = 25; $i <= 41; $i++) {
            $order = Payment::insert([
                'paymentAmount' => 0,
                'order_id' => $i,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $service=4;
        for($i = 25; $i <= 41; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 145000,
                'service_id'  => $service,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
            $service++;
        }

        $service=24;
        for($i = 25; $i <= 41; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 135000,
                'service_id'  => $service,
                'order_id'  => $i,
                'pickup' => now(),
                'desc'      => 'Ini deskripsi',
                'photoClient1'  => 'photoclient1.png',
                'photoClient2'  => 'photoclient2.png',
                'photoClient3'  => 'photoclient3.png',
                'photoClient4'  => 'photoclient4.png',
                'photoClient5'  => 'photoclient5.png',
                'photoTaylor1'  => 'phototaylor1.png',
                'photoTaylor2'  => 'phototaylor1.png',
                'photoTaylor3'  => 'phototaylor1.png',
                'photoTaylor4'  => 'phototaylor1.png',
                'photoTaylor5'  => 'phototaylor1.png',
                'orderStatus'=> 'Proses Order Customer',

            ]);
            $service++;
        }






    }
}
