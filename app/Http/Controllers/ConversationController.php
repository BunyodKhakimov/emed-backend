<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Http\Resources\ConversationCollection;
use App\Http\Resources\ConversationResource;

class ConversationController extends Controller
{
    public function index()
    {
        return new ConversationCollection(auth()->user()->conversations);
    }

    public function show(Conversation $conversation)
    {
        return new ConversationResource($conversation);
    }
}
