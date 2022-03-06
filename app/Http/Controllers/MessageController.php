<?php

namespace App\Http\Controllers;

use App\Conversation;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Message;
use App\User;

class MessageController extends Controller
{
    public function store(MessageRequest $request)
    {
        $data = $request->validated();

        $data['conversation_id'] = $this->getConversationId($data);
        $data['author'] = $data['from'];

        unset($data['to'], $data['from']);

        $message = Message::create($data);

        return new MessageResource($message);
    }

    public function destroy(Message $message)
    {
        $message->delete();
    }

    private function getConversationId($data)
    {
        $conversation = User::find($data['from'])->conversations->intersect(User::find($data['to'])->conversations);

        if ($conversation->isEmpty()) {
            $conversation = Conversation::create();
            $conversation->users()->attach([$data['from'], $data['to']]);
            return $conversation->id;
        }

        return $data['conversation_id'] = $conversation->pop()->id;
    }
}
