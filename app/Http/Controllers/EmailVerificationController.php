<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $member = Member::findOrFail($id);

        if (hash_equals((string) $hash, sha1($member->getEmailForVerification()))) {
            if (!$member->hasVerifiedEmail()) {
                $member->markEmailAsVerified();
                event(new Verified($member));

                $message['message']=[
                    'status'=>'success',
                    'title'=>'Verifikasi Berhasil',
                    'message'=>'Anda telah berhasil melakukan verifikasi email'
                ];
                return view('web.success',$message);
            }
            abort(404);
            // Sudah terverifikasi
        }
        // Tidak valid
        abort(404);
    }

    public function notify(){
        if(session('email')){
            return view('web.verify');
        } else {
            return redirect('register');
        }
    }
}


