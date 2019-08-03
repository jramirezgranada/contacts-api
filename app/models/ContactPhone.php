<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ContactPhone extends Model
{
    protected $table = 'contact_phones';

    protected $fillable = ["phone"];
}