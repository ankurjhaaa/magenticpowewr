<?php
namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @property string|null $slug
 * @property string $name
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }

    public function generateUniqueSlug(): string
    {
        $slug     = Str::slug($this->slugSource());
        $original = $slug;
        $i        = 1;

        while ($this->slugExists($slug)) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }

    protected function slugSource(): string
    {
        return $this->name;
    }

    protected function slugExists(string $slug): bool
    {
        return static::withTrashed()
            ->where('slug', $slug)
            ->when($this->exists, fn($query) => $query->where($this->getKeyName(), '!=', $this->getKey()))
            ->exists();
    }
}
