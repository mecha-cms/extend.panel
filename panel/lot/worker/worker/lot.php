<?php

$__ = explode('/+/', $__path . '/');
$__key = isset($__[1]) ? To::key(rtrim($__[1], '/')) : null;

$__step = $__step - 1;
$__sort = $__state->sort;
$__chunk = $__state->chunk;
$__is_get = Request::is('get');
$__is_post = Request::is('post');
$__is_has_step = $__sgr === 'g' && (count($__chops) === 1 || is_numeric(Path::B($url->path))) ? '/1' : ""; // Force index view by appending page offset to the end of URL

$__folder = LOT . DS . $__path;
$__file = File::exist([
    $__folder . '.draft',
    $__folder . '.page',
    $__folder . '.archive'
], $__folder);

$__seeds = [
    '__folder' => $__folder,
    '__file' => $__file,
    '__child' => [[], []],
    '__data' => [[], []],
    '__kin' => [[], []],
    '__page' => [[], []],
    '__parent' => [[], []],
    '__source' => [[], []],
    // Why “child(s)” and “data(s)”? Please open `lot\language\en-us.page` for more info
    '__childs' => [[], []],
    '__datas' => [[], []],
    '__kins' => [[], []],
    '__pages' => [[], []],
    '__parents' => [[], []],
    '__sources' => [[], []],
    '__pager' => [null, null],
    '__is_has_step' => $__is_has_step,
    '__is_has_step_child' => false,
    '__is_has_step_data' => false,
    '__is_has_step_kin' => false,
    '__is_has_step_page' => false,
    '__is_has_step_parent' => false,
    '__is_has_step_source' => false
];

extract(Lot::set($__seeds)->get(null, []));