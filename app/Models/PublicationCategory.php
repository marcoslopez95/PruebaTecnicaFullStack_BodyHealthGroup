<?php

namespace App\Models;

use App\Traits\IsDeletedModelTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicationCategory extends Model
{
    use HasFactory, SoftDeletes;
    use IsDeletedModelTrait;

    protected $fillable = [
        'name',
        'description'
    ];

}
