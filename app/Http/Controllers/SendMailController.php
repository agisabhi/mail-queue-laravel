<?php

namespace App\Http\Controllers;

use App\Jobs\SendQueueMailJob;
use App\Models\User;
use Illuminate\Http\Request;

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
            $data[] = [
                'email' => $value['email'],
                'subject' => $request->subject,
                'message' => $request->message,
            ];
        }

        try {
            dispatch(new SendQueueMailJob($data));
            return redirect('/send-mail')->with('success', 'Berhasil Kirim Email');
        } catch (\Exception $e) {
        }
    }
}
