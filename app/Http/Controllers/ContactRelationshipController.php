<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Resources\JsonApiRelationshipCollection;

class ContactRelationshipController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiRelationshipCollection
     */
    public function message(string $id)
    {
        $contact = Person::find($id);

       

        return (new JsonApiRelationshipCollection($contact->messages))->setParent($contact);
    }
}