<?php

namespace App\Http\Controllers;

use App\Mail\SupportTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function postContact(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'question'      => 'required',
            'verification'  => 'required|in:5,five',
        ]);

        Mail::to('admin@test.ru')->send( new SupportTiket($request->input('email'), $request->input('question')));

        return response()->json([
            'message' => 'Your message was send to admin please waitng'
        ]);
    }
}
