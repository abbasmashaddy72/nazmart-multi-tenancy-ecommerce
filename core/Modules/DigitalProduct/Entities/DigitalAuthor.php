<?php

namespace Modules\DigitalProduct\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DigitalAuthor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'status', 'image_id'];
    protected $table = 'digital_authors';

    protected static function newFactory()
    {
        return \Modules\DigitalProduct\Database\factories\DigitalAuthorFactory::new();
    }
}
