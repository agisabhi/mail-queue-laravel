<?php

namespace App\Http\Controllers;

use App\Jobs\SendQueueMailJob;
use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Send Mail Page',
        ];
        return view('mail.index', $data);
    }

    public function sendMail(Request $request)
    {
        $user = User::where('role', $request->role)->get();
        foreach ($user as $value) {
            $maildata = [
                'email' => $value['email'],
                'subject' => $request->subject,
                'message' => $request->message,
            ];
        }



        try {
            dispatch(new SendQueueMailJob($maildata));
            return redirect('/')->with('success', 'Berhasil Kirim Email');
        } catch (\Exception $e) {
        }
    }
}
