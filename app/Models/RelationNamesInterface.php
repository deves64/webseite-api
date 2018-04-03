<?php

namespace App\Models;

interface RelationNamesInterface
{
    public function getRelationNames(): array;

    public function setRelationNames(array $relationNames): Message;
}