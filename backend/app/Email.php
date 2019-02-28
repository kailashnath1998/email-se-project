<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    //
    protected $table = 'emails';

    protected $fillable = [
        'from'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'is_draft'
    ];

}
