<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;

class JsonApiIdentifierResource extends Resource
{
    use JsonApiTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        $model = $this->resource;

        return [
            'type' => $this->getTypeFrom($model),
            'id'   => $this->getIdFrom($model),
        ];
    }
}