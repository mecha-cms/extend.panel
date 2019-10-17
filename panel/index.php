<?php

if (!defined('USER')) {
    return;
}

$state = State::get('x.panel', true);

$GLOBALS['_'] = $_ = array_replace_recursive([
    'alert' => [],
    'chop' => [],
    'chunk' => $state['chunk'] ?? 20,
    'sort' => $state['sort'] ?? 1,
    'content' => $_GET['content'] ?? 'file',
    'f' => null,
    'i' => $i = $url['i'],
    'kick' => null,
    'lot' => [],
    'path' => null,
    'peek' => $state['peek'] ?? 2,
    'state' => $state,
    'user' => $u = State::get('x.user', true),
    'task' => null,
    'token' => content(USER . DS . Cookie::get('user.key') . DS . 'token.data'),
    '/' => $pp = ($u['guard']['path'] ?? $state['guard']['path']) . '/'
], $GLOBALS['_'] ?? []);

$p = trim($url->path, '/');
if (strpos('/' . $p, $pp . '::') === 0) {
    Asset::let(); // Remove all asset(s)
    Route::let(); // Remove all route(s)
    require __DIR__ . DS . 'engine' . DS . 'fire.php';
}

require __DIR__ . DS . 'engine' . DS . 'r' . DS . 'user.php';