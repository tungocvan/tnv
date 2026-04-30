<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
//use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
        'icon',
        'can',
        'type',
        'parent_id',
        'description',
        'image',
        'is_active',
        'sort_order',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order');
    }

    // Đệ quy để lấy toàn bộ cây con
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }


    public function scopePostType($query)
    {
        return $query->where('type', 'post');
    }

    public function scopeProductType($query)
    {
        return $query->where('type', 'product');
    }
    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Chỉ lấy các record là Menu
    public function scopeMenu($query)
    {
        return $query->where('type', 'menu');
    }

    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers (Logic Taxonomy Lõi)
    |--------------------------------------------------------------------------
    */
    public function getAllChildrenIds(): array
    {
        $ids = [$this->id];

        foreach ($this->childrenRecursive as $child) {
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }

        return $ids;
    }

    protected static function booted()
    {
        // ======================
        // CREATED / UPDATED
        // ======================
        static::saved(function ($category) {

            if ($category->type !== 'menu') {
                return;
            }
           
            // chỉ clear nếu field ảnh hưởng menu thay đổi
            if ($category->wasChanged([
                'name',
                'url',
                'icon',
                'parent_id',
                'sort_order',
                'is_active',
                'can'
            ])) {
                self::clearMenuCache();
            }
        });

        // ======================
        // DELETED
        // ======================
        static::deleted(function ($category) {
            if ($category->type === 'menu') {
                self::clearMenuCache();
            }
            
        });
    }

    // ======================
    // CLEAR CACHE
    // ======================
    protected static function clearMenuCache()
    {
        \Cache::forget('admin_sidebar_menu');
    }
}
