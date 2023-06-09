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

class DashboardController extends Controller
{
    public function index()
    {
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();

        $this->checkPaymentUnpaid();
        $this->checkPaymentPending();
        $notification=Notification::where('member_id',Auth::guard('member')->user()->id)->get();

        $category=CompetitionJoinCategory::where('member_id',Auth()->guard('member')->user()->id)->with('categories')->with(['competition_join'=>function($query){
            return $query->where('status','paid');
        },'competition_join.competition','competition_join.competition_join_category.certificate'])->get();
        $filterCategory=Category::get();
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

    function checkPaymentPending()
    {
        $payment_pending=CompetitionJoinPayment::where('status','pending')->where('member_id',Auth::guard('member')->user()->id)->get();
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

    public function competition_detail(Request $request,$id){
        $data['competition']=CompetitionJoinCategory::with('member','categories','competition_join')->where('id',$id)->first();
        return view('member.dashboard.competition-detail',$data);
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
        $request->validate([
            'image' => 'required|image|max:3000',
            'url' => 'required|string',
            'description' => 'required|string',
            'total' => 'required|numeric',
        ]);
        $imagePath = $request->file('image')->store('images');
        if(!$request->input('categories')){
            return back()->withInput();
        }

        $total=0;
        foreach ($request->input('categories') as $index => $category) {
           $competition_category=CompetitionCategory::where('competition_id',$id)->where('category_id',explode('|', $category)[1])->first();

           $total=$total+$competition_category->price;
       }

       $data=[
        'competition_id'=>$id,
        'member_id'=>Auth::guard('member')->user()->id,
        'join_date'=>date('Y-m-d H:i:s'),
        'image'=>$imagePath,
        'url'=>$request->input('url'),
        'description'=>$request->input('description'),
        'total'=>$total
    ];

    $competition=CompetitionJoin::create($data);

    foreach ($request->input('categories') as $index => $category) {
       $competition_category=CompetitionCategory::where('competition_id',$id)->where('category_id',explode('|', $category)[1])->first();
       $competition_join_category=CompetitionJoinCategory::create([
        'competition_join_id'=>$competition->id,
        'member_id'=>Auth::guard('member')->user()->id,
        'category_id'=>explode('|', $category)[1],
        'price'=>$competition_category->price
    ]);
   }

   return redirect('competition/summary/'.$competition->id);
}
}
