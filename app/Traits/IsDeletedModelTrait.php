<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait IsDeletedModelTrait {
    public function isDeleted(): Attribute
    {
        return Attribute::make(
            get: fn()=> is_null($this->deleted_at)
        );
    }
}
