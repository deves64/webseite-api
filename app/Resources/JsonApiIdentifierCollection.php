<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JsonApiIdentifierCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => JsonApiIdentifierResource::collection($this->collection),
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param $request
     * @param $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('Content-Type', 'application/vnd.api+json');
    }
}