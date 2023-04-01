<?php

namespace Modules\DigitalProduct\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalProductCategories extends Model
{
    use HasFactory;

    protected $table = 'digital_categories';
    protected $fillable = ['name', 'slug', 'description', 'digital_product_type', 'image_id'];

    protected static function newFactory()
    {
        return \Modules\DigitalProduct\Database\factories\DigitalProductCategoriesFactory::new();
    }
}
