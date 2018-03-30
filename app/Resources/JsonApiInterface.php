<?php

namespace App\Resources;

use Illuminate\Database\Eloquent\Model;

interface JsonApiInterface
{
    public function getId();

    public function getType(Model $model);

    public function getLinks();
}