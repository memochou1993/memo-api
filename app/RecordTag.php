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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
