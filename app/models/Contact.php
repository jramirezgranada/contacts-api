<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = ["firstname", "lastname", "photo_url"];

    /**
     * Relationship with contact_emails table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(ContactEmail::class);
    }

    /**
     * Relationship with contact_phones table
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany(ContactPhone::class);
    }
}