<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Certificate;
use PDF;

class CertificateController extends Controller
{
    public function index($id)
    {
        $data['certificate']=Certificate::where('id',$id)->with('competition_join_category.member','competition_join_category.competition_join.competition','competition_join_category.categories')->first();
        return view('admin.competition.edit-certificate',$data);
    }

    public function update(Request $request,$id){
        Certificate::where('id',$id)->update(['name'=>$request->input('name')]);
        return back();
    }
    public function download($id)
    {
        $data['settings']=Setting::first();

        // return view('admin.competition.download.certificate',$data);
        $data['certificate']=Certificate::where('id',$id)->first();
        $pdf = PDF::loadView('admin.competition.download.certificate', $data)->setPaper('a4', 'landscape');

        return $pdf->download('certificate.pdf');
    }

    public function formGenerate()
    {
        return view('admin.certificate-generate');
    }

    public function generate(Request $request)
    {
        $request->validate(['name'=>'required']);
        $data['settings']=Setting::first();
        $data['certificate']=$request->input('name');
        $pdf = PDF::loadView('admin.competition.download.generate-certificate', $data)->setPaper('a4', 'landscape');

        return $pdf->download('certificate.pdf');
    }
}
