<?php

namespace App\Http\Controllers;

use App\Jobs\SendQueueMailJob;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Send Mail Page',
        ];
        return view('mail.send_mail', $data);
    }

    public function sendMail(Request $request)
    {
        //Kirim semua inputan ke $data
        $data = $request->all();

        dispatch(new SendQueueMailJob($data));
        return redirect('/send-mail')->with('success', 'Berhasil Kirim Email');
    }
}
