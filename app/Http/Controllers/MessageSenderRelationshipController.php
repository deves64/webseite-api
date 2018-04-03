<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Person;
use App\Resources\JsonApiRelationshipResource;
use Illuminate\Http\Request;

class MessageSenderRelationshipController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiRelationshipResource
     */
    public function show(string $id)
    {
        $message = Message::find($id);

        return new JsonApiRelationshipResource($message->sender());
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @param Request $request
     * @return JsonApiRelationshipResource
     */
    public function update(string $id, Request $request)
    {
        $validatedData = $this->validate($request, [
            'data'  => 'present',
        ]);

        if(empty($validatedData['data'])) {
            $message = Message::find($id);
            $message->sender()->dissociate()->save();
        }

        $validatedData = $this->validate($request, [
           'data.type'  => 'required|string|max:255|in_array:person',
           'data.id'   => 'required|string|max:255|exists:persons',
       ]);

       $person = Person::find($data['id']);

        $message->sender()->associate($person)->save();

        return new JsonApiRelationshipResource($message->sender());
    }
}