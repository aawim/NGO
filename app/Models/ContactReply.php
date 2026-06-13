<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = ['contact_message_id', 'user_id', 'body'];

    // Links back to the original message
    public function message()
    {
        return $this->belongsTo(Contact::class, 'contact_message_id');
    }

    // Links to the Admin who sent the reply
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
