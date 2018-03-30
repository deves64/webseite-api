<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Message;
use App\Policies\MessagePolicy;
use App\Resources\JsonApiCollection;
use App\Resources\JsonApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Lcobucci\JWT\Parser;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonApiCollection
     */
    public function index(Request $request)
    {
        //$this->authorizeForUser($request->user(), 'view', Message::class);

        //$this->authorize('view', Message::class);

     /*   $parser = new Parser();
        $token = $parser->parse('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ2MWQ2YWJjN2E4MzNmZGQxZjc1YzAxYWZhYjQyOTU3Yzc5ZjI5YjZmMWE4NGRhZmE5MTU3MGUzMGEzYjA0OTFiZmRhZmZhZDkzMDAyMWEyIn0.eyJhdWQiOiIxIiwianRpIjoiZDYxZDZhYmM3YTgzM2ZkZDFmNzVjMDFhZmFiNDI5NTdjNzlmMjliNmYxYTg0ZGFmYTkxNTcwZTMwYTNiMDQ5MWJmZGFmZmFkOTMwMDIxYTIiLCJpYXQiOjE1MjE1NjA0MTYsIm5iZiI6MTUyMTU2MDQxNiwiZXhwIjoxNTUzMDk2NDE2LCJzdWIiOiIyZGFiNGU4MC0yYjgxLTExZTgtYWIwNC01MTE1MWRiMTQ0N2UiLCJzY29wZXMiOltdfQ.YKL15e7Y204gvAlQUrK2liLzoB1lEPgyGJwSBtSN27cBnanz0ib7yzk0XYDcscIMI1uXiPOnfiDDveqqRrUz1I9kWnYwLan_a9ANRwroiONMP_9q0tUjD8dRmFN4ZyCMH8I1vgPxhm01402fiwPox-fWyQKwMdhg1RMb5zdv5SrvC5pxwe3QmNtvadEMQbAdI4Enoa0tWCOY4D0i0hc34GGvsQA4Ce8K-yphkFphZJQAvvw-U076Ny75W3z5NSa5b0a95MPFqtvS6Q5g4pU0a-VL02LM8j6PCUvYGSszq5kItM_s8wMubgxxm6WoB-rxcdycWlyaQCPtXwsOPD0xW92Q2Dq5LPnXPRATWf4Wq6Z3YgG1jpLdxxNZgCr6VGQzf1twPV3f_gogm8Rp0SkYONGYhkosaQEB_JZ1QbA465tVP_knG-gsmOgGLDiCU8wNRIGjBf1A-iiuhCg-6o_Prk8PId1HKdNjbtulD1BVjOcaX5XWM3zTzAhBRC-gNwToRl5vIFxFMG4HhrzCBBzrYmBDGZa00uths64kRv83OovgfSPVT9TuNICqDFMoLxgob_SmSqtZaAkYcvYYzoFYgWKCicRSynkFTXRdeuvZdjgf-UqJYJvVmpVHiRN913zMTIWqVoe5bh3Cv6lztF7LwWyNMNnuRBAoS1aVROAMJlo');

        return $token->getClaim('sub');*/

    /* $app = App::getFacadeApplication();

     return get_class($app['db.connection']);*/

     //return get_class( DB::connection('laravel_website'));

        /*$message = Message::find('de104ab0-3100-11e8-af39-21894cbb16b9');
        $relation = $message->receiver();

        $parent = $relation->getParent();
        $nameOfRelation = $relation->getRelation();*/

        return new JsonApiCollection(Message::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonApiResource
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
         /*   'forename'  => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'email'     => 'required|string|email|max:255',
            'phone'     => 'present|string|max:255',*/
            'subject'   => 'required|string|max:255',
            'message'   => 'required|string|max:255',
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

        $message = new Message(
            array_only($validatedData, ['subject', 'message' ])
        );

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
        $message = Message::find($id);

        return new JsonApiResource($message);
    }
}