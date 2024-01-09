<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\CompetitionJoinPayment;

class MidtransController extends Controller
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;

    public function __construct()
    {
    }


    public function create_url($payment_id,$name,$email,$phone,$total)
    {
        $serverKey = env('SERVER_KEY_SANDBOX');

        $isProduction = false;
        if(env('APP_ENV')=='development'){
            $isProduction = false;
        }

        if(env('APP_ENV')=='production'){
            $isProduction = true;
        }
        $isSanitized = true;
        $is3ds = true;

        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = $isSanitized;
        Config::$is3ds = $is3ds;

        $params = array(
            'transaction_details' => array(
                'order_id' => $payment_id,
                'gross_amount' => $total,
            ),
            'customer_details' => array(
                'first_name' => $name,
                'last_name' => ' ',
                'email' => $email,
                'phone' => $phone,
            ),
        );

        $snapToken = Snap::getSnapToken($params);
        CompetitionJoinPayment::where('id',$payment_id)->update(['midtrans_order_id'=>$snapToken]);

        if(env('APP_ENV')=='development'){
            return 'https://app.sandbox.midtrans.com/snap/v2/vtweb/'.$snapToken;
        }

        if(env('APP_ENV')=='local'){
            return 'https://app.sandbox.midtrans.com/snap/v2/vtweb/'.$snapToken;
        }

        if(env('APP_ENV')=='production'){
            return 'https://app.midtrans.com/snap/v2/vtweb/'.$snapToken;
        }
    }

    public function get_status()
    {
        $serverKey = env('SERVER_KEY_SANDBOX');
        $payment_number='1a3fc1ad-9d94-4bb9-a719-4bbc6e68a0a4';
        if(env('APP_ENV')=='development' OR env('APP_ENV')=='local'){
            $api_url = 'https://api.sandbox.midtrans.com/v2/'.$payment_number.'/status';
        }

        if(env('APP_ENV')=='production'){
            $api_url = 'https://api.midtrans.com/v2/'.$payment_number.'/status';
        }

        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic '.base64_encode($serverKey)
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        return $decode=json_decode($response);

        var_dump($decode);

        return $decode->status_code;
    }

    public function callback(Request $request)
    {
        // Handle callback dari Midtrans
        $transaction = $request->input('transaction_status');
        
        if ($transaction === 'capture') {
            // Pembayaran berhasil
            // Lakukan tindakan yang diperlukan di sini
        } else if ($transaction === 'settlement') {
            // Pembayaran berhasil dan telah terverifikasi
            // Lakukan tindakan yang diperlukan di sini
        } else if ($transaction === 'pending') {
            // Pembayaran tertunda
            // Lakukan tindakan yang diperlukan di sini
        } else if ($transaction === 'deny') {
            // Pembayaran ditolak
            // Lakukan tindakan yang diperlukan di sini
        } else if ($transaction === 'expire') {
            // Pembayaran kadaluarsa
            // Lakukan tindakan yang diperlukan di sini
        } else if ($transaction === 'cancel') {
            // Pembayaran dibatalkan
            // Lakukan tindakan yang diperlukan di sini
        }
    }
}
