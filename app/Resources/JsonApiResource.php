<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Collection;

class JsonApiResource extends Resource implements JsonApiInterface
{
    /**
     * Create a new resource instance.
     *
     * @param  Model  $resource
     * @return void
     */
    public function __construct(Model $resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'type'       => $this->getType(),
            'id'         => $this->getId(),
            'attributes' => $this->getAttributes(),
        ];

        if($relationships = $this->getRelationsShips()) {
            $resource['relationships'] = $relationships;
        }

        $resource['links'] = $this->getLinks();

        return $resource;
    }

    public function getId()
    {
        return $this->resource->getKey();
    }

    public function getType(Model $model)
    {
        return strtolower(class_basename(get_class($model)));
    }

    public function getLinks()
    {
        return ['self' => route($this->getType() . '.show', ['id' => $this->getId()])];
    }

    public function getAttributes()
    {
        return array_except($this->resource->attributesToArray(), ['id']);
    }

    public function getRelationsShips()
    {
        if(empty($this->resource->getRelationNames())) {
            return false;
        }

        $relationNames = $this->resource->getRelationNames();

        if(! is_array($relationNames)) {
            return false;
        }

        $relationObjects = $this->getRelationObjectsFromModel($this->resource);

        if(count($relationNames) > 1) {
            $relationsShips = new JsonApiRelationshipCollection($relationObjects);
        }
        else {
            $relationsShips = new JsonApiRelationshipResource($relationObjects);
        }

        return $relationsShips;
    }

    public function getRelationObjectsFromModel(Model $model)
    {
        $relationNames = $model->getRelationNames();
        $relationObjects = [];

        foreach ($relationNames as $name) {
            $relationObjects[] = $model->$name();
        }

        if(count($relationObjects) === 1) {
            return $relationObjects[0];
        }

        return new Collection($relationObjects);
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