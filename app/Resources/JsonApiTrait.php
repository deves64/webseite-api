<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;

trait JsonApiTrait
{
    public function getIdFrom(Model $model)
    {
        return $model->getKey();
    }

    public function getTypeFrom(Model $model)
    {
        return strtolower(class_basename(get_class($model)));
    }
}