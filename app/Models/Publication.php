<?php

namespace App\Models;

use App\Models\Scopes\OrderByIdScope;
use App\Traits\IsDeletedModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Publication extends Model
{
    use HasFactory, SoftDeletes, IsDeletedModelTrait;

    protected $fillable = [
        'content',
        'labels',
        'region_id',
        'publication_category_id',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderByIdScope);
    }

    protected function labels(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !empty($value) ? explode(',', $value) : null,
            set: fn (array $value) => !empty($value) ? implode(',', $value) : null,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function publicationCategory(): BelongsTo
    {
        return $this->belongsTo(PublicationCategory::class);
    }

    public function externalReferences(): BelongsToMany
    {
        return $this->belongsToMany(ExternalReference::class);
    }

    public function scopeFilter(Builder $query, $filter)
    {
        return $query->when($filter->search, function (Builder $q, string $search) {
            if (count(explode(' ', $search)) > 2) {

                return $q->where(DB::raw('UPPER(content)'), 'like', '%' . Str::upper($search) . '%');
            }
            return $q->where(DB::raw("FIND_IN_SET('$search',labels)"), '>', 0);
        });
    }
}
