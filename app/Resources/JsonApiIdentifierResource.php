<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JsonApiIdentifierResource extends Resource implements JsonApiInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)

    {
        return [
            'type' => $this->getType(),
            'id'   => $this->getId(),
        ];
    }

    public function getId()
    {
        return $this->resource->getKey();
    }

    public function getType()
    {
        return strtolower(class_basename(get_class($this->resource)));
    }

    public function getLinks()
    {
        return null;
    }
}