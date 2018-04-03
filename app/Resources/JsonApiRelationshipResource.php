<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Resources\Json\Resource;

class JsonApiRelationshipResource extends Resource implements JsonApiLinksInterface
{
    use JsonApiTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $relationName = $this->getRelationName();
        $parent = $this->getParent();
        $model = $parent->$relationName;

        $data = [];

        if(get_parent_class($model) === Model::class) {
            $data = new JsonApiIdentifierResource($model);
        }
        else if(get_class($model) === Collection::class) {
            $data = new JsonApiIdentifierCollection($model);
        }

        $parent = $this->getParent();

        $relationship = [
                'links' => $this->getLinksFrom($parent),
                'data'      => $data
            ];

        return $relationship;
    }

    public function getLinksFrom(Model $model)
    {
        return [
            'self'    => route($this->getTypeFrom($model) . ucfirst($this->getRelationName())  . 'Relationship.show', ['id' => $this->getIdFrom($model)]),
            'related' => route($this->getTypeFrom($model) . ucfirst($this->getRelationName())  . 'Child.show', ['id' => $this->getIdFrom($model)]),
        ];
    }

    public function getParent()
    {
        $parent = '';

        switch (get_class($this->resource)) {
            case BelongsTo::class:
            case BelongsToMany::class:
                    $parent = $this->resource->getParent();
                break;
            case HasOne::class:
            case HasMany::class:
                    $parent = $this->resource->getParent();
                break;
            default:

                break;
        }

        return $parent;
    }

    public function getRelationName()
    {
        $relationName = '';

        switch (get_class($this->resource)) {
            case BelongsTo::class:
            case BelongsToMany::class:
                    $relationName = $this->resource->getRelation();
                break;
            case HasOne::class:
            case HasMany::class:

                break;
            default:

                break;
        }
        return $relationName;
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