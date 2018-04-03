<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;

interface JsonApiLinksInterface
{
    public function getLinksFrom(Model $model);
}