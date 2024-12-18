<?php

namespace App\Http\Controllers;

use Log;
use index;
use App\Cart;
use Exception;
use Midtrans\Snap;

use App\Transaction;
use Midtrans\Config;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {

        //save user
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //proses checkout
        $code = 'AISHASTORE-' . mt_rand(00000, 99999);
        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)->get();

        //transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'code' => $code,
            'fee_cost' => 0,
            'shipping_cost' => 15000,
            'total_price' => $request->total_price,
            'transaction_status' => 'MENUNGGU PEMBAYARAN',
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000, 99999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'code' => $trx,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
            ]);
            $cart->product->decrement('stock', $cart->quantity);
        }

        Cart::where('users_id', Auth::user()->id)->delete();

        //konfigurasi midtrans
        // Set your Merchant Server Key
        Config::$serverKey = config('services.midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = config('services.midtrans.isProduction');
        // Set sanitization on (default)
        Config::$isSanitized =  config('services.midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        Config::$is3ds = config('services.midtrans.$is3ds');

        //buat array untuk midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,

            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay',
                'permata_va',
                'bank_tranfer',
                'other_va',
                'indomaret'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request) {}
}
