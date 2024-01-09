<?php

namespace App\Http\Controllers;
use App\Models\Competition;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\ForgotEmail;
use Auth;
use Validator;
use App\Mail\ContactUsEmail;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function RegisterForm()
    {
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();
        return view('web.home',['competition'=>$competition]);
    }

    public function LoginForm()
    {
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();
        return view('web.login',['competition'=>$competition]);
    }

    public function contact_us()
    {
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();
        return view('web.contact_us',['competition'=>$competition]);
    }

    public function forgot_password_form()
    {
        $currentDateTime = Carbon::now();
        $competition=Competition::where('to', '>=', $currentDateTime)
        ->latest()
        ->first();
        return view('web.forgot',['competition'=>$competition]);
    }
    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:members,email',
        // 'g-recaptcha-response' => 'required|captcha'
        ], [
            'email.exists' => 'Email not registered.'
        ]);

        $member = Member::where('email', $request->email)->first();

        if ($member) {
            Mail::to($member->email)->send(new ForgotEmail($member));
            return back()->with('success','Password berhasil terkirim ke email anda');
        } else {
            return back()->with('error', 'Member not found.');
        }
    }

    public function contact_us_send(Request $request)
    {
        $settings=Setting::first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::to($settings->email)->send(new ContactUsEmail());

        session()->flash('success', 'Pesan anda berhasil dikirim');
        return redirect()->back();
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:members',
            'email' => 'required|email|unique:members',
            'phone' => 'required',
            'password' => 'required|min:6',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);


        $member = new Member();
        $member->name = $request->input('name');
        $member->certificate_name=$request->input('name');
        $member->username = $request->input('username');
        $member->email = $request->input('email');
        $member->phone = $request->input('phone');
        $member->token=sha1($request->input('email'));
        $member->password = Hash::make($request->input('password'));
        $member->password_text=$request->input('password');

        $member->save();
        Mail::to($member->email)->send(new EmailVerification($member));
        return redirect('email/verify')->with('email', $member->email);
    }

    public function login(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'username' => ['required'],
            'password' => ['required'],
            // 'g-recaptcha-response' => 'required|captcha'
        ]) ;

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $data=[
            'username'=>$request->input('username'),
            'password'=>$request->input('password'),
        ];

        if (Auth::guard('member')->attempt($data)) {
            if (Auth::guard('member')->user()->hasVerifiedEmail()) {
                return redirect('/');
            } else {
                return redirect('/login')->with('error', 'Your email is not verified.');
            }
        } else {
            return redirect('/login')->with('error', 'Invalid username or password.');
        }
    }

    public function term_condition()
    {
        $data['term_condition']=Setting::first();
        return view('web.term_condition',$data);
    }

    public function logout(Request $request)
    {
        Auth::guard('member')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login'); 
    }

}
