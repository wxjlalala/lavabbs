<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function get_category()
{
    return \App\Models\Category::all()->toArray();
}