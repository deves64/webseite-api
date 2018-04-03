<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Message extends Model implements RelationNamesInterface
{
    use Uuids;

    public $relationNames = [
        'sender',
        'receiver',
        'senderClient',
        'receiverClient'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'message', 'sender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'sender_id',
        'receiver_id',
        'sender_client_id',
        'receiver_client_id'
    ];

    /**
     * Get the person that sent the message.
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\Person');
    }

    /**
     * Get the person that received the message.
     */
    public function receiver()
    {
        return $this->belongsTo('App\Models\Person');
    }

    /**
     * Get the client with which the message was sent.
     */
    public function senderClient()
    {
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * Get the client with which the message was received.
     */
    public function receiverClient()
    {
        return $this->belongsTo('App\Models\Client');
    }

    /**
     * @return array
     */
    public function getRelationNames(): array
    {
        return $this->relationNames;
    }

    /**
     * @param array $relationNames
     * @return Message
     */
    public function setRelationNames(array $relationNames): Message
    {
        $this->relationNames = $relationNames;
        return $this;
    }
}