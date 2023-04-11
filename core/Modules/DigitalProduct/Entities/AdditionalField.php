<?php

namespace Modules\DigitalProduct\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalField extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'badge_id', 'pages', 'language', 'formats',
        'words', 'tool_used', 'database_used', 'compatible_browsers',
        'compatible_os', 'high_resolution', 'author_id'
    ];

    protected static function newFactory()
    {
        return \Modules\DigitalProduct\Database\factories\AdditionalFieldFactory::new();
    }
}
