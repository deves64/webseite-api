<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\URL;

class ProjectResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          return [
              'data' => [
                  'attributes' => array_except(parent::toArray($request), ['id']),
                  'id' => array_only(parent::toArray($request), ['id'])['id'],
                  'type' => 'message'
              ]/*,
              'links' => [
                  'self' => URL::current() . '/' . $this->id
              ]*/
          ];
    }
}