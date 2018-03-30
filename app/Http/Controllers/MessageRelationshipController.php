<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Resources\JsonApiRelationshipResource;
use Illuminate\Http\Request;

class MessageRelationshipController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiRelationshipResource
     */
    public function showSender(string $id)
    {
        $message = Message::find($id);

        return (new JsonApiRelationshipResource($message->sender))->setParent($message)->setRelationName(__FUNCTION__);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiRelationshipResource
     */
    public function showReceiver(string $id)
    {
        $message = Message::find($id);

        return (new JsonApiRelationshipResource($message->receiver))->setParent($message)->setRelationName(__FUNCTION__);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @param Request $request
     * @return JsonApiRelationshipResource
     */
    public function updateSender(string $id, Request $request)
    {
       return $request->getContent();
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiRelationshipResource
     */
    public function updateReceiver(string $id)
    {
        $message = Message::find($id);

        return (new JsonApiRelationshipResource($message->receiver))->setParent($message)->setRelationName(__FUNCTION__);
    }
}