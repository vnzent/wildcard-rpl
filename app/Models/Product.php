<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;
use TomatoPHP\FilamentCms\Models\Category;

/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $keywords
 * @property string $slug
 * @property string $sku
 * @property string $barcode
 * @property string $type
 * @property string $about
 * @property string $description
 * @property string $details
 * @property float $price
 * @property float $discount
 * @property string $discount_to
 * @property float $vat
 * @property bool $is_in_stock
 * @property bool $is_activated
 * @property bool $is_shipped
 * @property bool $is_trend
 * @property bool $has_options
 * @property bool $has_multi_price
 * @property bool $has_unlimited_stock
 * @property bool $has_max_cart
 * @property int $min_cart
 * @property int $max_cart
 * @property bool $has_stock_alert
 * @property int $min_stock_alert
 * @property int $max_stock_alert
 * @property string $created_at
 * @property string $updated_at
 * @property Category[] $categories
 * @property Product[] $collection
 * @property Tags[] $tags
 * @property ProductMeta[] $productMetas
 * @property ProductReview[] $productReviews
 * @property Category $category
 */
class Product extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'keywords',
        'name',
        'slug',
        'sku',
        'barcode',
        'type',
        'about',
        'description',
        'details',
        'price',
        'discount',
        'discount_to',
        'vat',
        'is_in_stock',
        'is_activated',
        'is_shipped',
        'is_trend',
        'has_options',
        'has_multi_price',
        'has_unlimited_stock',
        'has_max_cart',
        'min_cart',
        'max_cart',
        'has_stock_alert',
        'min_stock_alert',
        'max_stock_alert',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_in_stock' => 'boolean',
        'is_activated' => 'boolean',
        'is_shipped' => 'boolean',
        'is_trend' => 'boolean',
        'has_options' => 'boolean',
        'has_multi_price' => 'boolean',
        'has_unlimited_stock' => 'boolean',
        'has_max_cart' => 'boolean',
        'has_stock_alert' => 'boolean',
    ];

    public array $translatable = [
        'name',
        'about',
        'description',
        'details',
        'keywords',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_has_categories', 'product_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_has_tags', 'product_id', 'tag_id');
    }

    public function collection(): BelongsToMany
    {
        return $this->belongsToMany('TomatoPHP\FilamentEcommerce\Models\Product', 'product_has_collection', 'collection_id');
    }

    public function productMetas(): HasMany
    {
        return $this->hasMany(ProductMeta::class);
    }

    public function meta(string $key, string|array|object|null $value = null): Model|string|null|array
    {
        if ($value !== null) {
            if ($value === 'null') {
                return $this->productMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            } else {
                return $this->productMetas()->updateOrCreate(['key' => $key], ['value' => $value]);
            }
        } else {
            $meta = $this->productMetas()->where('key', $key)->first();
            if ($meta) {
                return $meta->value;
            } else {
                return $this->productMetas()->updateOrCreate(['key' => $key], ['value' => null]);
            }
        }
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
