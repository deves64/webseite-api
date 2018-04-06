<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Person;
use App\Models\Message;
use App\Resources\JsonApiCollection;
use App\Resources\JsonApiResource;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonApiCollection
     */
    public function index(Request $request)
    {
        //$this->authorizeForUser($request->user(), 'view', Message::class);

        //$this->authorize('view', Message::class);

        return new JsonApiCollection(Message::paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiResource
     */
    public function show(string $id)
    {
        $message = Message::find($id);

        return new JsonApiResource($message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonApiResource
     */
    public function store(Request $request)
    {

        $validatedData = $this->validate($request, [
            'data'               => 'required|array',
            'data.type'          => 'required|string|in:message',
            'data.attributes'    => 'required|array',
            'data.attributes.subject'   => 'required|string|max:255',
            'data.attributes.message'   => 'required|string|max:255',
            'data.relationships' => 'required|array',
            'data.relationships.sender' => 'required|array',
            'data.relationships.receiver' => 'required|array',
            'data.relationships.sender-client' => 'required|array',
            'data.relationships.receiver-client' => 'required|array',
            'data.relationships.sender.data' => 'required|array',
            'data.relationships.receiver.data' => 'required|array',
            'data.relationships.sender-client.data' => 'required|array',
            'data.relationships.receiver-client.data' => 'required|array',
            'data.relationships.sender.data.type' => 'required|string|max:255',
            'data.relationships.sender.data.id' => 'required|string|max:255|exists:persons,id',
            'data.relationships.receiver.data.type' => 'required|string|max:255',
            'data.relationships.receiver.data.id' => 'required|string|max:255|exists:persons,id',
            'data.relationships.sender-client.data.type' => 'required|string|max:255',
            'data.relationships.sender-client.data.id' => 'required|string|max:255|exists:clients,id',
            'data.relationships.receiver-client.data.type' => 'required|string|max:255',
            'data.relationships.receiver-client.data.id' => 'required|string|max:255|exists:clients,id',
        ]);

        $message = new Message();
        $message->fill([
            'subject' => array_get($validatedData, 'data.attributes.subject'),
            'message' => array_get($validatedData, 'data.attributes.message'),
        ]);

        $sender = Person::find(
            array_get($validatedData, 'data.relationships.sender.data.id')
        );

        $message->sender()->associate($sender);

        $receiver = Person::find(
            array_get($validatedData, 'data.relationships.receiver.data.id')
        );

        $message->receiver()->associate($receiver);

        $senderClient = Client::find(
            array_get($validatedData, 'data.relationships.sender-client.data.id')
        );

        $message->senderClient()->associate($senderClient);

        $receiverClient = Client::find(
            array_get($validatedData, 'data.relationships.receiver-client.data.id')
        );

        $message->receiverClient()->associate($receiverClient);

        $message->save();

        return new JsonApiResource($message);
    }
}