<?php

namespace App\Resources;

use App\Models\RelationNamesInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Collection;

class JsonApiResource extends Resource implements JsonApiLinksInterface
{
    use JsonApiTrait;
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
        $model = $this->resource;

        $resource = [
            'type'       => $this->getTypeFrom($model),
            'id'         => $this->getIdFrom($model),
            'attributes' => $this->getAttributesFrom($model),
        ];

        if($relationships = $this->getRelationsShipsFrom($model)) {
            $resource['relationships'] = $relationships;
        }

        $resource['links'] = $this->getLinksFrom($model);

        return $resource;
    }

    public function getLinksFrom(Model $model)
    {
        return ['self' => route($this->getTypeFrom($model) . '.show', ['id' => $this->getIdFrom($model)])];
    }

    public function getAttributesFrom(Model $model)
    {
        return array_except($model->attributesToArray(), ['id']);
    }

    public function getRelationsShipsFrom(RelationNamesInterface $model)
    {
        if(empty($model->getRelationNames())) {
            return false;
        }

        $relationNames = $model->getRelationNames();

        if(! is_array($relationNames)) {
            return false;
        }

        $relationObjects = $this->getRelationObjectsFromModel($model);

        if(count($relationNames) > 1) {
            $relationsShips = new JsonApiRelationshipCollection($relationObjects);
        }
        else {
            $relationsShips = new JsonApiRelationshipResource($relationObjects);
        }

        return $relationsShips;
    }

    public function getRelationObjectsFromModel(RelationNamesInterface $model)
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