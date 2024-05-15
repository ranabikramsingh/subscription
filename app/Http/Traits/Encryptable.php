<?php
// app/Traits/Encryptable.php

namespace App\Http\Traits;

trait Encryptable
{
    public function getSecureIdAttribute()
    {
        return encryptID($this->attributes['id']);
    }

    public function setSecureIdAttribute($value)
    {
        $this->attributes['id'] = decryptID($value);
    }

    public function scopeFindSecureOrFail($query, $encryptedId)
    {
        $id = decryptID($encryptedId);
        return $query->findOrFail($id);
    }
}
