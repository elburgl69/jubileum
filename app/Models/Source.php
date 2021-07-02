<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Bestelling
 *
 * @property integer $id                Unieque ID
 * @property string  $name              Name of the source
 * @property \Carbon\Carbon $created_at Date the source was creted
 * @property \Carbon\Carbon $updated_at Date the source was last updated
 */
class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    protected $dates = ['created_at', 'updated_at'];
    // protected $casts = [
    //     'xxx' => 'boolean',
    //     'created_at' => 'datetime:Y-m-d',
    // ];


}