<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MidtransController;
use App\Models\Category;
use App\Models\CompetitionCategory;
use App\Models\CompetitionJoin;
use App\Models\CompetitionJoinPayment;
use Illuminate\Http\Request;
use Auth;
use Storage;
use Google\Cloud\Storage\StorageClient;
class TransactionController extends Controller
{
    public function summary($id){
        $data['competition']=CompetitionJoin::with('competition_join_category.categories','competition','payment')->where('id',$id)->first();
        return view('member.transaction.summary',$data);
    }

    public function index()
    {
     $data['transaction']=CompetitionJoin::where('member_id',Auth::guard('member')->user()->id)
     ->with('competition','payment')
     ->whereHas('payment')
     ->orderBy('created_at', 'desc')
     ->get();
     return view('member.transaction.transaction',$data);
 }

 public function transaction($id)
 {
    $competition=CompetitionJoin::with('member','competition','competition_join_category.categories')->where('id',$id)->where('status','unpaid')->first();
    $number=$this->generate_transaction_number();
    $payment=CompetitionJoinPayment::updateOrcreate(['competition_join_id'=>$id],[
        'member_id'=>$competition->member_id,
        'competition_join_id'=>$id,
        'midtrans_order_id'=>NULL,
        'payment_number'=>$number,
        'total'=>$competition->total,
        'status'=>'pending'
    ]);

    // $video=$this->upload($competition,$competition->url,'/video/');
    // $new_image=$this->upload($competition,$competition->image,'/image/');

    // foreach ($competition->competition_join_category as $key => $value) {
    //     $video=$this->upload($competition,$competition->url,'/video/'.$value->categories->name.'/');
    //     $new_image=$this->upload($competition,$competition->image,'/image/'.$value->categories->name.'/');
    // }

    // $this->unlink_file($competition->url);
    // $this->unlink_file($competition->image);



    // CompetitionJoin::where('id',$id)->where('status','unpaid')->update(['image'=>$new_image,'url'=>$video]);

    $midtrans=New MidtransController();
    $url=$midtrans->create_url($payment->id,$competition->member->name,$competition->member->email,$competition->member->phone,$competition->total);
    CompetitionJoin::with('member')->where('id',$id)->where('status','unpaid')->update(['status'=>'pending']);
    header("Location: " . $url);
    exit();
}

public function generate_transaction_number()
{
    $year = date('Y'); 
    $month = date('m'); 
    $sequence = CompetitionJoinPayment::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->count() + 1;

    $sequence_padded = str_pad($sequence, 2, '0', STR_PAD_LEFT);

    $transaction_number = $year . $month . $sequence_padded;
    return $transaction_number;
}

private function upload($competition,$file_url,$folder)
{
    $url = 'http://127.0.0.1:8000/storage/';

    if (env('APP_ENV') == 'production') {
        $url = 'https://krisandpartners.com/';
    } elseif (env('APP_ENV') == 'development') {
        $url = 'https://dev.krisandpartners.com/';
    }

    $image = str_replace($url, "", $file_url);
    $file = storage_path('app/public/' . $image);
    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

    $projectId = env('GOOGLE_CLOUD_PROJECT_ID');
    $keyFilePath = storage_path(env('GOOGLE_CLOUD_KEY_FILE'));
    $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');
    $storage = new StorageClient([
        'projectId' => $projectId,
        'keyFilePath' => $keyFilePath,
    ]);
    $bucket = $storage->bucket($bucketName);
    $fileName = $competition->competition->title.$folder.$competition->member->username . $this->generate_transaction_number() . '.' . $fileExtension;

    $bucket->upload(
        fopen($file, 'r'),
        [
            'name' => $fileName,
            'predefinedAcl' => 'publicRead', // Set predefinedAcl untuk akses publik
        ]
    );

    $fileUrl = "https://storage.googleapis.com/{$bucketName}/{$fileName}";

    // if (file_exists($file)) {
    //     unlink($file);
    // }

    return $fileUrl;
}

private function unlink_file($file_url)
{
    $url = 'http://127.0.0.1:8000/storage/';

    if (env('APP_ENV') == 'production') {
        $url = 'https://krisandpartners.com/';
    } elseif (env('APP_ENV') == 'development') {
        $url = 'https://dev.krisandpartners.com/';
    }
    
    $image = str_replace($url, "", $file_url);
    $file = storage_path('app/public/' . $image);
    if (file_exists($file)) {
        unlink($file);
    }
}

}
