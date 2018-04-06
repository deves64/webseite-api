<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Resources\JsonApiCollection;
use App\Resources\JsonApiResource;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonApiCollection
     */
    public function index()
    {
        return new JsonApiCollection(Person::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonApiResource
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'forename'  => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'email'     => 'required|string|email|max:255',
            'phone'     => 'present|string|max:255',
        ]);

        /*$contact = Contact::where('email', $validatedData['email'])->first();

        if(!$contact) {
            $contact = new Contact(
                array_except($validatedData, ['subject', 'message' ])
            );
            $contact->save();
        }
        else {
            if (empty($contact->phone) && !empty($validatedData['phone'])) {
               $contact->update(array_only($validatedData, ['phone']));
            }
        }*/

        $message = new Person($validatedData);

        $message->save();

        return new JsonApiResource($message);
    }


    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return JsonApiResource
     */
    public function show(string $id)
    {
        $contact = Person::find($id);

        return new JsonApiResource($contact);
    }
}