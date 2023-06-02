<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Member;
use App\Models\Competition;
use App\Models\CompetitionJoin;
use App\Models\CompetitionCategory;
use App\Models\CompetitionJoinCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $competitions = Competition::with('competition_join')->get();
        return view('admin.competition.competition',['competitions' => $competitions]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('admin.competition.add', ['categories' => $categories]);
    }

    public function edit($id)
    {
        $categories=Category::all();
        $competition = Competition::with('categories')->findOrFail($id);
        return view('admin.competition.edit', compact('competition','categories'));
    }

    public function view($id)
    {
        $categories=Category::all();
        $competition = Competition::with('categories')->findOrFail($id);
        return view('admin.competition.view', compact('competition','categories'));
    }

    public function participant($id)
    {
        $data['participant']=CompetitionJoin::where('competition_id',$id)->where('status','paid')->with('competition_join_category.categories','member','competition_join_category.certificate')->get();
        $data['category']=Category::get();
        $data['member']=Member::get();
        return view('admin.competition.participant',$data);
    }

    public function participant_detail($id)
    {
        $data['competition']=CompetitionJoinCategory::with('member','categories','competition_join')->where('id',$id)->first();
        return view('admin.competition.participant-detail',$data);   
    }

    public function participant_win(Request $request,$id)
    {
        $status=$request->input('status');
        $win_date=date('Y-m-d H:i:s');
        if(!$status==0){
            $win_date=NULL;
            Certificate::where('competition_join_category_id',$id)->delete();
        }
        CompetitionJoinCategory::where('id',$id)->update(['win_status'=>!$status,'win_date'=>$win_date]);
        if(!$status==1){
            $certificate=Certificate::create([
                'competition_join_category_id'=>$id,
                'no_certificate'=>1,
                'name'=>CompetitionJoinCategory::where('id',$id)->with('member')->first()->member->certificate_name
            ]);
            return redirect('admin/competition/participant/certificate/'.$certificate->id);
        } else {
            return back();
        }
    }

    public function showCertificate($id)
    {
        $data['certificate']=Certificate::where('id',$id)->with('competition_join_category.member','competition_join_category.competition_join.competition','competition_join_category.categories')->first();
        return view('admin.competition.certificate',$data);
    }

    public function downloadImage($filename)
    {
        $path = storage_path('app/public/images/' . $filename);

        return response()->download($path);
    }
    public function create(Request $request)
    {
        $categories = $request->input('categories');

        if(!$categories){
            return redirect('admin/competition/add')->with('category','Pilih dan isi harga kategori dengan benar')->withInput();
        }
        $prices = $request->input('prices');
        foreach ($categories as $categoryId) {
            $index=explode('|',$categoryId)[0];
            if(!$prices[$index]){
                return redirect('admin/competition/add')->with('category','Pilih dan isi harga kategori dengan benar')->withInput();
            }
        }
        $validatedData = $request->validate([
            'title' => 'required',
            'range' => 'required',
            'banner' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:max_width=700,max_height=1080',
            'description' => 'required',
        ]);
        $explode = explode(' - ', $request->input('range'));
        $from = Carbon::createFromFormat('d/m/Y', $explode[0])->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $explode[1])->format('Y-m-d');

        $bannerPath = $request->file('banner')->store('banners');

        $competition = new Competition;
        $competition->title = $request->input('title');
        $competition->from = $from;
        $competition->to = $to;
        $competition->banner = $bannerPath;
        $competition->description = $request->input('description');
        $competition->save();

        $categories = $request->input('categories');
        $prices = $request->input('prices');
        foreach ($categories as $categoryId) {
            $explode=explode('|',$categoryId);
            $index=$explode[0];
            $price = $prices[$index];
            $competition_category = new CompetitionCategory;
            $competition_category->competition_id = $competition->id;
            $competition_category->category_id = $explode[1];
            $competition_category->price = $price;
            $competition_category->save();
        }
        return redirect('admin/competition')->with('success', 'Kompetisi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $categories = $request->input('categories');

        if(!$categories){
            return redirect()->back()->withInput();
        }

        $prices = $request->input('prices');
        foreach ($categories as $categoryId) {
            $index=explode('|',$categoryId)[0];
            if(!$prices[$index]){
                return redirect()->back()->withInput();
            }
        }
        $validatedData = $request->validate([
            'title' => 'required',
            'range' => 'required',
            'banner' => 'image|mimes:jpeg,png,jpg,gif|dimensions:max_width=700,max_height=700',
            'description' => 'required',
        ]);

        $competition = Competition::findOrFail($id);
        $competition->title = $request->input('title');

        $explode = explode(' - ', $request->input('range'));
        $from = Carbon::createFromFormat('d/m/Y', $explode[0])->format('Y-m-d');
        $to = Carbon::createFromFormat('d/m/Y', $explode[1])->format('Y-m-d');
        $competition->from = $from;
        $competition->to = $to;

        if ($request->hasFile('banner')) {
            $validatedData['banner'] = $request->validate([
                'banner' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:max_width=700,max_height=700',
            ]);
            $bannerPath = $request->file('banner')->store('banners');
            $competition->banner = $bannerPath;
        }

        $competition->description = $request->input('description');
        $competition->save();

        $categories = $request->input('categories');
        $prices = $request->input('prices');
        $competition->categories()->sync([]);
        foreach ($categories as $index => $categoryId) {
            $explode = explode('|', $categoryId);
            $index = $explode[0];
            $price = $prices[$index];
            CompetitionCategory::updateOrCreate(['category_id'=>$explode[1],'competition_id'=>$id],['price'=>$price]);
        }

        return redirect('admin/competition')->with('success', 'Kompetisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        CompetitionCategory::where('competition_id',$id)->delete();
        $competition->delete();
        return redirect('admin/competition')->with('success', 'User berhasil dihapus');
    }
}