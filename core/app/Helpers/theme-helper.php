<?php

use App\Facades\ThemeDataFacade;


function getFooterWidgetArea()
{
    return ThemeDataFacade::getFooterWidgetArea();
}

function getHeaderNavbarArea()
{
    return ThemeDataFacade::getHeaderNavbarArea();
}

function getHeaderBreadcrumbArea()
{
    return ThemeDataFacade::getHeaderBreadcrumbArea();
}

function getAllThemeSlug()
{
    return ThemeDataFacade::getAllThemeSlug();
}
