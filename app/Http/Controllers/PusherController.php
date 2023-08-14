<?php

namespace App\Http\Controllers;

use App\Events\Chat;
use Illuminate\Http\Request;

class PusherController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function broadcast(Request $request)
    {
        broadcast(new Chat($request->get("message")))->toOthers();
        return view('broadcast', ['message' => $request->get('message')]);
    }
    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }
}