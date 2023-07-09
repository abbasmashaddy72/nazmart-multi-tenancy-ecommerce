<?php

namespace App\Facades;

use App\Http\Services\RenderImageMarkupService;
use Illuminate\Support\Facades\Facade;

/**
 * @see RenderImageMarkupService
 * */
class ImageRenderFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
   public static function getFacadeAccessor(){
       return 'ImageRenderFacade';
   }
}
