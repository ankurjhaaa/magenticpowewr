<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'product_id', 'sku', 'name', 'slug', 'voltage', 'capacity',
        'chemistry', 'is_default', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected function slugExists(string $slug): bool
    {
        return static::withTrashed()
            ->where('slug', $slug)
            ->where('product_id', $this->product_id)
            ->when($this->exists, fn ($query) => $query->where($this->getKeyName(), '!=', $this->getKey()))
            ->exists();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(VariantImage::class, 'variant_id');
    }

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'variant_applications', 'variant_id', 'application_id');
    }

    public function specifications(): BelongsToMany
    {
        return $this->belongsToMany(Specification::class, 'variant_specifications', 'variant_id', 'specification_id')
            ->withPivot('value', 'sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'variant_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    protected static function booted(): void
    {
        static::deleting(function (ProductVariant $variant) {
            if (! $variant->isForceDeleting()) {
                $variant->images()->get()->each->delete();
            }
        });

        static::restoring(function (ProductVariant $variant) {
            $variant->images()->onlyTrashed()->get()->each->restore();
        });
    }
}
