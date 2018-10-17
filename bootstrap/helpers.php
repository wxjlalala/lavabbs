<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function get_category()
{
    return \App\Models\Category::all()->toArray();
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}