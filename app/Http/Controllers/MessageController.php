<?php

namespace App\Http\Controllers;


use App\Models\Contact;
use App\Models\Message;
use App\Resources\MessageCollection;
use App\Resources\MessageResource;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return MessageCollection
     */
    public function index()
    {
        return new MessageCollection(Message::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return MessageResource
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'forename'  => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'email'     => 'required|string|email|max:255',
            'phone'     => 'present|string|max:255',
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string|max:255',
        ]);

        $contact = Contact::where('email', $validatedData['email'])->first();

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
        }

        $message = $contact->messages()->create(
            array_only($validatedData, ['subject', 'message' ])
        );

        return new MessageResource($message);
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     * @return MessageResource
     */
    public function show(string $id)
    {
        $message = Message::find($id)->first();

        return new MessageResource($message);
    }

}