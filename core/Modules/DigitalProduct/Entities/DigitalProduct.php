<?php

namespace Modules\DigitalProduct\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class DigitalProduct extends Model
{
    use HasFactory;

    protected $table = 'digital_products';
    protected $fillable = [
        'name', 'slug', 'summary', 'description', 'image_id',
        'included_files', 'version', 'release_date', 'update_date', 'preview_link', 'accessibility', 'is_licensable',
        'tax', 'file', 'regular_price', 'sale_price', 'free_date', 'promotional_date', 'promotional_price'
    ];

    public function category() : HasOneThrough {
        return $this->hasOneThrough(DigitalCategories::class,DigitalProductCategories::class,'product_id','id','id','category_id');
    }

    public function subCategory(): HasOneThrough {
        return $this->hasOneThrough(DigitalSubCategories::class,DigitalProductSubCategories::class,"product_id","id","id","sub_category_id");
    }

    public function childCategory(): hasManyThrough {
        return $this->hasManyThrough(DigitalChildCategories::class, DigitalProductChildCategories::class,"product_id","id","id","child_category_id");
    }

    protected static function newFactory()
    {
        return \Modules\DigitalProduct\Database\factories\DigitalProductFactory::new();
    }
}
