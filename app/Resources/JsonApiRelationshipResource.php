<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Resources\Json\Resource;

class JsonApiRelationshipResource extends Resource implements JsonApiInterface
{
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
        $resource = $parent->$relationName;

        $relationship['data'] = get_class($resource);

        $data = [];

        if(get_parent_class
            ($resource) === Model::class) {
            $data = new JsonApiIdentifierResource($resource);
        }
        else if(get_class($resource) === Collection::class) {
            $data = new JsonApiIdentifierCollection($resource);
        }

        $relationship = [
            kebab_case($relationName) => [
                'links' => $this->getLinks(),
                'data'      => $data
            ]
        ];


        return $relationship;
    }

    public function getId()
    {
        $parent = $this->getParent();

        return (string) array_only($parent->toArray(), ['id'])['id'];
    }

    public function getType()
    {
        $resource = $this->resource;

        return strtolower(class_basename(get_class($resource)));
    }

    public function getLinks()
    {
        return [
            'self'    => route($this->getParentType() . ucfirst($this->getRelationName())  . 'Relationship.show', ['id' => $this->getId()]),
            'related' => route($this->getParentType() . ucfirst($this->getRelationName())  . 'Child.show', ['id' => $this->getId()]),
        ];
    }

    protected function getParentType()
    {
        $parent = $this->getParent();

        return strtolower(class_basename(get_class($parent)));
    }

    public function getParent()
    {
        $parent = '';

        switch (get_class($this->resource)) {
            case BelongsTo::class:
            case BelongsToMany::class:
                    $parent = $this->resource->getParent();
                break;
            case 'Illuminate\\Database\\Eloquent\\Model':

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
            case 'Illuminate\\Database\\Eloquent\\Model':

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