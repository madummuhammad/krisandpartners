<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\CompetitionJoinCategory;
use Illuminate\Validation\Rule;
use Validator;
use Auth;

class MemberController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $member=Member::with('win')->get();
        return view('admin.member.member',['members'=>$member]);
    }

    public function edit($id)
    {
        $member = Member::find($id);
        $competition_join_categories=CompetitionJoinCategory::where('member_id',$id)->where('win_status',1)->with('competition_join.competition','certificate')->get();
        return view('admin.member.edit',compact('member','competition_join_categories'));
    }

    public function update(Request $request, $id)
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
            'note' => 'nullable',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member->name = $request->input('name');
        $member->username = $request->input('username');
        $member->certificate_name = $request->input('certificate_name');
        $member->phone = $request->input('phone');
        $member->email = $request->input('email');
        $member->note = $request->input('note');

        if ($request->filled('password')) {
            $member->password = bcrypt($request->input('password'));
            $member->password_text = $request->input('password');
        }

        $member->save();

        return back()->with('success', 'Data member berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return back()->with('error', 'Member tidak ditemukan.');
        }

        $member->delete();

        return back()->with('success', 'Member berhasil dihapus.');
    }
}
