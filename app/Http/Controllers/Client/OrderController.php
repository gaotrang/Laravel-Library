<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        // dd(session()->get('cart'));
        $cart = session()->get('cart') ?? [];
        return view('client.pages.check-out', compact('cart'));
    }
}
