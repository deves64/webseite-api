<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JsonApiRelationshipCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function toArray($request)
    {
        $zeug = [];
        foreach ($this->collection as $key => $value) {
            $item = new JsonApiRelationshipResource($value);

            $zeug[kebab_case($item->getRelationName())] = $item;
        }

        return  $zeug;
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