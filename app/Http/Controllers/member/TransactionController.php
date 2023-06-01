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

class TransactionController extends Controller
{
    public function summary($id){
        $data['competition']=CompetitionJoin::with('competition_join_category.categories','competition','payment')->where('id',$id)->first();
        return view('member.transaction.summary',$data);
    }

    public function index()
    {
     $data['transaction']=CompetitionJoin::where('member_id',Auth::guard('member')->user()->id)->with('competition')->get();
     return view('member.transaction.transaction',$data);
 }

 public function transaction($id)
 {
    $competition=CompetitionJoin::with('member')->where('id',$id)->where('status','unpaid')->first();

    $payment=CompetitionJoinPayment::updateOrcreate(['competition_join_id'=>$id],[
        'member_id'=>$competition->member_id,
        'competition_join_id'=>$id,
        'midtrans_order_id'=>NULL,
        'total'=>$competition->total,
        'status'=>'unpaid'
    ]);

    $midtrans=New MidtransController();
    $url=$midtrans->create_url($payment->id,$competition->member->name,$competition->member->email,$competition->member->phone,$competition->total);

    header("Location: " . $url);
    exit();

        // return back();
}

}
