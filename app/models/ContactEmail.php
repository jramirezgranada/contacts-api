<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ContactEmail extends Model
{
    protected $table = 'contact_emails';

    protected $fillable = ["email"];
}