<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'project';

    protected $fillable = [
        'name',
        'date',
        'estimate_start_date',
        'estimate_end_date',
    ];

    
}
