<?php

namespace App\Http\Controllers;

use App\Events\ChatPrivateEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    const ANSWERS = [
        'This is supposed to be an AI Response',
        'I am a very smart answer created by our wise AI',
        'Just random babble'
    ];

    public function send(Request $request)
    {
        dump($request);
        $message = $request->get('message');


        event(
            new ChatPrivateEvent(
                auth()->user()->id,
                ChatController::ANSWERS[array_rand(ChatController::ANSWERS)]
            )
        );
        return new Response('', 200);
    }
}
