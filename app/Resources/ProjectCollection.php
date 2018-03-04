<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\URL;

class ProjectCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($page){

                $attributes = [
                    'attributes' => array_except($page->toArray(), ['id']),
                    'id' => array_only($page->toArray(), ['id'])['id'],
                    'type' => 'message',
                    'included' => ContactResource::make($page->contact),
                ];

                return $attributes;
            }),
        ];
    }
}