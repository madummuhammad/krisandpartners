<?php

namespace App\Console\Commands;
use App\Models\CompetitionJoinPayment;
use App\Models\CompetitionJoin;

use Illuminate\Console\Command;

class MidtransCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:midtrans-check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payment_unpaid=CompetitionJoinPayment::where('status','unpaid')->get();
        foreach ($payment_unpaid as $key => $value) {
            $serverKey = env('SERVER_KEY_SANDBOX');
            $payment_number=$value->id;
            if(env('APP_ENV')=='development'){
                $api_url = 'https://api.sandbox.midtrans.com/v2/'.$payment_number.'/status';
            } else {
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

            $status=json_decode($response);

            if($status->status_code==200)
            {
                if($status->transaction_status=='settlement' OR $status->transaction_status=='capture'){
                    CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'paid']);
                    CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'paid']);

                    
                }
            }

            if($status->status_code==404)
            {
                CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'pending']);
                CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'pending']);

                
            }

            if($status->status_code==407)
            {
                CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'failed']);
                CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'failed']);

                
            }
        }



        $payment_pending=CompetitionJoinPayment::where('status','pending')->get();
        foreach ($payment_pending as $key => $value) {
            $serverKey = env('SERVER_KEY_SANDBOX');
            $payment_number=$value->id;
            if(env('APP_ENV')=='development'){
                $api_url = 'https://api.sandbox.midtrans.com/v2/'.$payment_number.'/status';
            } else {
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

            $status=json_decode($response);

            if($status->status_code==200)
            {
                if($status->transaction_status=='settlement' OR $status->transaction_status=='capture'){
                    CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'paid']);
                    CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'paid']);

                    
                }
            }

            if($status->status_code==404)
            {
                CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'pending']);
                CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'pending']);

                
            }

            if($status->status_code==407)
            {
                CompetitionJoinPayment::where('id',$value->id)->update(['status'=>'failed']);
                CompetitionJoin::where('id',$value->competition_join_id)->update(['status'=>'failed']);

                
            }
        }
    }
}
