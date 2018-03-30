<?php

namespace App\Http\Controllers;

use App\Models\RadiusConfirm;
use App\Models\RadiusUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Webpatser\Uuid\Uuid;
use Zend\Math\Rand;
use Carbon\Carbon;

class RadiusUserController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $this->validate($request, [
            'forename'  => 'required|string|max:255',
            'surname'   => 'required|string|max:255',
            'email'     => 'required|string|email|max:255'
        ]);

        $validatedData = array_only($validatedData, ['forename', 'surname', 'email']);

        $validatedData = array_add($validatedData,
            'username', $this->generateUsername($validatedData)
        );

        $validatedData = array_add($validatedData,
            'password', $this->generatePassword()
        );

        $user = RadiusUser::create(
            $validatedData
        );

        $user->confirm()->create([
            'hash' => Uuid::generate()->string,
        ]);

        return $user->toArray();
    }

    public function confirm(Request $request)
    {
        $validatedData = $this->validate($request, [
            'hash'  => [
                'required',
                'string',
                'max:255',
                Rule::exists('radius_confirms')->where(function ($query) {
                    $query->where('completed', false)
                          ->whereBetween('created_at', array(Carbon::now()->subHours(24), Carbon::now()));
                }),
            ],
        ]);

        $confirm = RadiusConfirm::where('hash', array_only($validatedData, ['hash']))->first();
        $confirm->update(['completed' => true]);

        $confirm->user->update(['suspended' => false]);

        return $confirm->toArray();
    }

    protected function generateUsername($data)
    {
        $length = 8;
        $alphabet  = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet .= strtoupper($alphabet);
        $alphabet .= '0123456789';

        $username = [];

        array_push(
            $username,
            strtolower($data['forename']),
            strtolower($data['surname']),
            Rand::getString($length, $alphabet)
        );

        return implode('.', $username);
    }

    protected function generatePassword()
    {
        $length = 18;
        $alphabet  = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet .= strtoupper($alphabet);
        $alphabet .= '0123456789';
        $alphabet .= '$%&=!?,.-_;:#<>+*';

        return Rand::getString($length, $alphabet);
    }
}