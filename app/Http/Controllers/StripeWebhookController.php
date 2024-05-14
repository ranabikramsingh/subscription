<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{User};

class StripeWebhookController extends Controller
{
    //
    public function handleWebhook()
    {
        @dd('here');
    }
}
