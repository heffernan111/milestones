<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

	protected $fillable = [
        'user_id', 'credit', 'debit','description','reference','date'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
