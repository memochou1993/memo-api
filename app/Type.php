<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
