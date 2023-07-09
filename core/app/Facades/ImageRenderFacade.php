<?php

namespace App\Facades;

use App\Http\Services\RenderImageMarkupService;
use Illuminate\Support\Facades\Facade;

/**
 * @see RenderImageMarkupService
 * @method getParent($image, $class_list)
 * */
class ImageRenderFacade extends Facade
{
   public static function getFacadeAccessor(){
       return 'ImageRenderFacade';
   }
}
