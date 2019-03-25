<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordTag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'records_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'record_id', 'tag_id',
    ];
}
