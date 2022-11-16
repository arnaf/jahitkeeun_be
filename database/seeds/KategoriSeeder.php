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

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();


        $paymentmethode1 = ShippingMethode::insert([
            'name' => 'JNE',
            'photo' => 'jne.png'
        ]);

        $paymentmethode2 = ShippingMethode::insert([
            'name' => 'POS',
            'photo' => 'pos.png'
        ]);

        $paymentmethode3 = ShippingMethode::insert([
            'name' => 'JNT',
            'photo' => 'jnt.png'
        ]);

        $paymentmethode1 = PaymentMethode::insert([
            'name' => 'BCA Virtual Account',
            'photo' => 'bca.png'
        ]);

        $paymentmethode2 = PaymentMethode::insert([
            'name' => 'Credit Card',
            'photo' => 'credit.png'
        ]);

        $paymentmethode3 = PaymentMethode::insert([
            'name' => 'Gopay',
            'photo' => 'gopay.png'
        ]);

        $paymentmethode4 = PaymentMethode::insert([
            'name' => 'BNI Virtual Account',
            'photo' => 'bni.png'
        ]);

        $paymentmethode5 = PaymentMethode::insert([
            'name' => 'BRI Virtual Account',
            'photo' => 'bri.png'
        ]);

        $paymentmethode6 = PaymentMethode::insert([
            'name' => 'Permata Virtual Account',
            'photo' => 'permata.png'
        ]);



        $serviceCategory1 = ServiceCategory::insert([
            'name' => 'Gamis',
            'photo' => 'gamis.png'
        ]);

        $serviceCategory2 = ServiceCategory::insert([
            'name' => 'Kebaya / Atasan Tanpa Payet',
            'photo' => 'kebaya.png'
        ]);

        $serviceCategory3 = ServiceCategory::insert([
            'name' => 'Kemeja / Atasan ',
            'photo' => 'kemeja.png'
        ]);

        $serviceCategory4 = ServiceCategory::insert([
            'name' => 'Kemeja Batik ',
            'photo' => 'kemejabatik.png'
        ]);

        $serviceCategory5 = ServiceCategory::insert([
            'name' => 'Kerudung',
            'photo' => 'kerudung.png'
        ]);

        $serviceCategory6 = ServiceCategory::insert([
            'name' => 'Kupnat',
            'photo' => 'kupnat.png'
        ]);

        $serviceCategory7 = ServiceCategory::insert([
            'name' => 'Robek / Berlubang',
            'photo' => 'robek.png'
        ]);

        $serviceCategory8 = ServiceCategory::insert([
            'name' => 'Kancing',
            'photo' => 'kancing.png'
        ]);

    for($i = 1; $i <= 20; $i++) {
        $jasa1 = Service::insert([
            'name' => 'Jahit Exclude Bahan',
            'price' => 145000,
            'service_categories_id' => 1,
            'taylor_id' => $i,

        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa2 = Service::insert([
            'name' => 'Permak Resize Ukuruan (Premium)',
            'price' => 135000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa3 = Service::insert([
            'name' => 'Permak Resize Ukuruan (Reguler)',
            'price' => 100000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa4 = Service::insert([
            'name' => 'Potong Panjang Bawah (Premium)',
            'price' => 105000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa5 = Service::insert([
            'name' => 'Potong Panjang Bawah (Reguler)',
            'price' => 75000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {

        $jasa6 = Service::insert([
            'name' => 'Resleting Ganti Resleting (Premium)',
            'price' => 85000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }
    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Resleting Ganti Resleting (Reguler)',
            'price' => 60000,
            'service_categories_id' => 1,
            'taylor_id' => $i,
        ]);
    }


    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Kancing Model Standar (Premium)',
            'price' => 35000,
            'service_categories_id' => 8,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Kancing Model Standar (Reguler)',
            'price' => 25000,
            'service_categories_id' => 8,
            'taylor_id' => $i,
        ]);
    }


    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Jahit Exclude Bahan',
            'price' => 350000,
            'service_categories_id' => 2,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Premium)',
            'price' => 275000,
            'service_categories_id' => 2,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Reguler)',
            'price' => 200000,
            'service_categories_id' => 2,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Potong Panjang Bawah (Premium)',
            'price' => 275000,
            'service_categories_id' => 2,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Potong Panjang Bawah (Reguler)',
            'price' => 200000,
            'service_categories_id' => 2,
            'taylor_id' => $i,
        ]);
    }


    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Jahit Exclude Bahan',
            'price' => 150000,
            'service_categories_id' => 3,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Premium)',
            'price' => 130000,
            'service_categories_id' => 3,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Reguler)',
            'price' => 95000,
            'service_categories_id' => 3,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Potong Panjang Bawah (Premium)',
            'price' => 70000,
            'service_categories_id' => 3,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Jahit Exclude Bahan',
            'price' => 170000,
            'service_categories_id' => 4,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Premium)',
            'price' => 150000,
            'service_categories_id' => 4,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Reguler)',
            'price' => 100000,
            'service_categories_id' => 4,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Potong Panjang Bawah (Premium)',
            'price' => 100000,
            'service_categories_id' => 4,
            'taylor_id' => $i,
        ]);
    }


    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak Resize Ukuran (Premium)',
            'price' => 75000,
            'service_categories_id' => 5,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Permak 2 Sisi (Kanan & Kiri) (Premium)',
            'price' => 50000,
            'service_categories_id' => 6,
            'taylor_id' => $i,
        ]);
    }

    for($i = 1; $i <= 20; $i++) {


        $jasa7 = Service::insert([
            'name' => 'Robek Maks. Robek 20 Cm (Premium)',
            'price' => 40000,
            'service_categories_id' => 7,
            'taylor_id' => $i,
        ]);
    }


    for($i = 2; $i <= 11; $i++) {
        $cart = Cart::insert([
            'quantity' => 1,
            'service_id' => 2,
            'user_id' => $i,
        ]);
    }

    for($i = 2; $i <= 11; $i++) {
        $cart = Cart::insert([
            'quantity' => 1,
            'service_id' => 22,
            'user_id' => $i,
        ]);
    }

    for($i = 32; $i <= 41; $i++) {
        $cart = Cart::insert([
            'quantity' => 15,
            'service_id' => 2,
            'user_id' => $i,
        ]);
    }

    for($i = 32; $i <= 41; $i++) {
        $cart = Cart::insert([
            'quantity' => 5,
            'service_id' => 22,
            'user_id' => $i,
        ]);
    }


        $cart = Delivery::insert([
            'name' => 'JNE',
            'photo' => 'jne.png',
            'addressFrom' => 'Bandung',
            'addressTo' => 'Bogor',
            'price' => 30000,
        ]);

        $cart = Delivery::insert([
            'name' => 'JNE',
            'photo' => 'jne.png',
            'addressFrom' => 'Bandung',
            'addressTo' => 'Subang',
            'price' => 20000,
        ]);

        $cart = Delivery::insert([
            'name' => 'JNE',
            'photo' => 'jne.png',
            'addressFrom' => 'Bandung',
            'addressTo' => 'Cianjur',
            'price' => 25000,
        ]);

        $cart = Delivery::insert([
            'name' => 'JNE',
            'photo' => 'jne.png',
            'addressFrom' => 'Bandung',
            'addressTo' => 'Bandung',
            'price' => 10000,
        ]);


        for($i = 2; $i <= 11; $i++) {
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
                'user_id' => $i

            ]);
        }

        $a = 2;
        for($i = 12; $i <= 21; $i++) {

            $order = Order::insert([
                'invoice' => 'INVOICE'.'-'.$i,
                'totalPayment' => 280000,
                'paymentStatus' => 'LUNAS',
                'orderStatus'=> 'Konfirmasi Hasil Service',
                'address' => 'Bandung',
                'estimationDate' => date('Y-m-d H:i:s'),
                'deliveries_id' => 1,
                'payment_method_id' => 1,
                'shipping_method_id' => 1,
                'user_id' => $a

            ]);
            $a++;
        }

        for($i = 1; $i <= 10; $i++) {
            $order = Payment::insert([
                'paymentAmount' => 0,
                'order_id' => $i
            ]);
        }

        for($i = 11; $i <= 20; $i++) {
            $order = Payment::insert([
                'paymentAmount' => 280000,
                'order_id' => $i
            ]);
        }

        for($i = 1; $i <= 10; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 145000,
                'service_id'  => 2,
                'order_id'  => $i,
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

            ]);
        }

        for($i = 1; $i <= 10; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 135000,
                'service_id'  => 22,
                'order_id'  => $i,
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

            ]);
        }


        for($i = 11; $i <= 20; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 145000,
                'service_id'  => 2,
                'order_id'  => $i,
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

            ]);
        }

        for($i = 11; $i <= 20; $i++) {
            $cart = OrderDetail::insert([
                'quantity'  => 1,
                'price'  => 135000,
                'service_id'  => 22,
                'order_id'  => $i,
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

            ]);
        }





    }
}
