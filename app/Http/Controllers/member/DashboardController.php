<?php

namespace App\Http\Controllers\member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Competition;
use App\Models\Notification;
use App\Models\Member;
use App\Models\CompetitionJoin;
use App\Models\CompetitionCategory;
use App\Models\CompetitionJoinCategory;
use App\Models\CompetitionJoinPayment;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Setting;
use Illuminate\Validation\Rule;
use Auth;
use PDF;
use Validator;
use Storage;
use Google\Cloud\Storage\StorageClient;
class DashboardController extends Controller
{
    public function index()
    {
        // echo date_default_timezone_get();
        // return 1;
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();

        $this->checkPaymentUnpaid();
        $this->checkPaymentPending();
        $notification=Notification::where('member_id',Auth::guard('member')->user()->id)->get();

        $category=CompetitionJoinCategory::where('member_id',Auth()->guard('member')->user()->id)
        ->with('categories')
        ->with(['competition_join'=>function($query){
            return $query->where('status','paid');
        },'competition_join.competition','competition_join.competition_join_category.certificate','competition_join.payment'])
        ->orderBy('created_at', 'desc')
        ->get();
        $filterCategory=Category::orderBy('created_at', 'desc')->get();
        return view('member.dashboard.dashboard',['competition'=>$competition,'category'=>$category,'filterCategory'=>$filterCategory,'notification'=>$notification]);
    }

    function checkPaymentUnpaid()
    {
        $payment_unpaid=CompetitionJoinPayment::where('status','unpaid')->where('member_id',Auth::guard('member')->user()->id)->get();
        foreach ($payment_unpaid as $key => $value) {
            $serverKey = env('SERVER_KEY_SANDBOX');
            $payment_number=$value->id;

            if(env('APP_ENV')=='development'){
                $api_url = 'https://api.sandbox.midtrans.com/v2/'.$payment_number.'/status';
            }

            if(env('APP_ENV')=='local'){
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

    function checkPaymentPending()
    {
        $payment_pending=CompetitionJoinPayment::where('status','pending')->where('member_id',Auth::guard('member')->user()->id)->get();
        foreach ($payment_pending as $key => $value) {
            $serverKey = env('SERVER_KEY_SANDBOX');
            $payment_number=$value->id;
            if(env('APP_ENV')=='development'){
                $api_url = 'https://api.sandbox.midtrans.com/v2/'.$payment_number.'/status';
            }

            if(env('APP_ENV')=='local'){
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

    public function competition_detail(Request $request,$id){
        $data['competition']=CompetitionJoinCategory::with('member','categories','competition_join')->where('id',$id)->first();
        return view('member.dashboard.competition-detail',$data);
    }

    public function submision(Request $request,$id)
    {
        // $competition=CompetitionJoinCategory::where('id',$id)->with('member','categories','competition_join.competition')->first();

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg|max:3000',
            'url' => 'required',
            'description'=>'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $competition=CompetitionJoinCategory::where('id',$id)->with('member','categories','competition_join.competition')->first();
        $video=$request->url;
        // $video=$this->upload_video($competition,$request->url,'/video/');
        // $video=$this->upload($request,'url','/video/',$competition);
        $new_image=$this->upload($request,'image','/image/',$competition);
        $url='http://127.0.0.1:8000/storage/';

        if(env('APP_ENV')=='production'){
            $url='https://krisandpartners.com/';
        }

        if(env('APP_ENV')=='development'){
            $url='https://dev.krisandpartners.com/';
        }

        $data=[
            'image'=>$new_image,
            'url'=>$video,
            'description'=>$request->input('description'),
            'submision_status'=>1
        ];

        CompetitionJoinCategory::where('id',$id)->update($data);

        return back();
    }

    private function upload($request,$name,$folder,$competition)
    {
        $url = 'http://127.0.0.1:8000/storage/';

        if (env('APP_ENV') == 'production') {
            $url = 'https://krisandpartners.com/';
        } elseif (env('APP_ENV') == 'development') {
            $url = 'https://dev.krisandpartners.com/';
        }

        $file=$request->file($name);
        $fileExtension=$file->getClientOriginalExtension();
        $fileName = $competition->competition_join->competition->title.$folder.$competition->categories->name.'/'.$competition->member->username . $this->generate_transaction_number() . '.' . $fileExtension;

        $projectId = env('GOOGLE_CLOUD_PROJECT_ID');
        $keyFilePath = storage_path(env('GOOGLE_CLOUD_KEY_FILE'));
        $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');
        $storage = new StorageClient([
            'projectId' => $projectId,
            'keyFilePath' => $keyFilePath,
        ]);
        $bucket = $storage->bucket($bucketName);


        $bucket->upload(
            fopen($file->getPathname(), 'r'),
            [
                'name' => $fileName,
                'predefinedAcl' => 'publicRead',
            ]
        );

        $fileUrl = "https://storage.googleapis.com/{$bucketName}/{$fileName}";

        return $fileUrl;
    }

    private function upload_video($competition,$file_url,$folder)
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
        $fileName = $competition->competition_join->competition->title.$folder.$competition->member->username . $this->generate_transaction_number() . '.' . $fileExtension;

        $bucket->upload(
            fopen($file, 'r'),
            [
                'name' => $fileName,
            'predefinedAcl' => 'publicRead', // Set predefinedAcl untuk akses publik
        ]
    );

        $fileUrl = "https://storage.googleapis.com/{$bucketName}/{$fileName}";

        if (file_exists($file)) {
            unlink($file);
        }

        return $fileUrl;
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

    public function certificate($id)
    {
        $data['settings']=Setting::first();
        $data['certificate']=Certificate::where('id',$id)->first();
        $pdf = PDF::loadView('member.competition.certificate', $data)->setPaper('a4', 'landscape');

        return $pdf->download('certificate.pdf');
    }

    public function joinForm($id)
    {
        $competition=Competition::where('id',$id)->with('categories')->first();
        return view('member.dashboard.join',['competition' => $competition]);
    }

    public function profile()
    {
        $data['member'] = Member::find(Auth::guard('member')->user()->id);
        return view('member.profile',$data);
    }

    public function profile_update(Request $request,$id)
    {
        $member = Member::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => [
                'required',
                Rule::unique('members')->ignore($member->id),
            ],
            'certificate_name' => 'required',
            'phone' => 'required|numeric',
            'email' => ['required', 'email', Rule::unique('members')->ignore($id)],
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return redirect('profile')->withErrors($validator)->withInput();
        }

        $member->name = $request->input('name');
        $member->username = $request->input('username');
        $member->certificate_name = $request->input('certificate_name');
        $member->phone = $request->input('phone');
        $member->email = $request->input('email');

        if ($request->filled('password')) {
            $member->password = bcrypt($request->input('password'));
            $member->password_text=$request->input('password');
        }

        $member->save();

        return redirect('profile')->with('success', 'Data member berhasil diperbarui.');
    }


    public function join(Request $request,$id)
    {
        $selected_category=$request->selected_category;
        $category_array=json_decode($selected_category);
        $validator = Validator::make($request->all(), [
            // 'image' => 'required|image|max:3000',
            // 'url' => 'required|mimetypes:video/avi,video/mpeg,video/quicktime,video/mp4|max:50000', 
            // 'description' => 'required|string',
            'total' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        // $image = $request->file('image')->store('images');
        // $video = $request->file('url')->store('images');

        $url='http://127.0.0.1:8000/storage/';

        if(env('APP_ENV')=='production'){
            $url='https://krisandpartners.com/';
        }

        if(env('APP_ENV')=='development'){
            $url='https://dev.krisandpartners.com/';
        }

        // $imagePath=$url.$image;


        if(!$request->input('categories')){
            return back()->withInput();
        }

        $total = 0;
        foreach ($category_array as $key => $category) {
            if ($category->checked == true) {
                if ($category->free !== true) {
                    $total = $total + ($category->price * $category->qty);
                } else {
                    $total = $total + ($category->price * ($category->qty - $category->free_count));
                }
            }
        }

        $total;

        $data=[
            'competition_id'=>$id,
            'member_id'=>Auth::guard('member')->user()->id,
            'join_date'=>date('Y-m-d H:i:s'),
            // 'image'=>$imagePath,
            // 'url'=>$video,
            // 'description'=>$request->input('description'),
            'total'=>$total
        ];

        $competition=CompetitionJoin::create($data);

        foreach ($category_array as $key => $value) {
            $competition_category = CompetitionCategory::where('competition_id', $id)->where('category_id', $value->category_id)->first();
            if ($value->checked == true) {
             $freeCount = $value->free_count;
             for ($i = 0; $i < $value->qty; $i++) {
                if($value->free==true){
                    if($freeCount>0){
                        $price=0;
                        $freeCount--;
                    } else{
                        $price = $competition_category->price;
                    }
                } else {
                    $price = $competition_category->price;
                }
                $competition_join_category[$key][$i] = CompetitionJoinCategory::create([
                    'competition_join_id' => $competition->id,
                    'member_id' => Auth::guard('member')->user()->id,
                    'category_id' => $value->category_id,
                    'price' => $price
                ]);
            }
        }
    }

    return redirect('competition/summary/'.$competition->id);
}
}
