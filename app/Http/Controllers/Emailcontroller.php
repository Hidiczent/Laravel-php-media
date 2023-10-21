<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class Emailcontroller extends Controller
{
    //

    public function sendEmailOTP(Request $request){
        dispatch(new SendEmailJob($request->email));    
    }
}