<?php

$chop = explode('/', $p);

// `http://127.0.0.1/panel`
// `http://127.0.0.1/panel/::g::`
if (count($chop) < 3) {
    Guard::kick("");
}

// Remove the first path
array_shift($chop);

$task = $chop[0] && strpos($chop[0], '::') === 0 && substr($chop[0], -2) === '::' ? substr(array_shift($chop), 2, -2) : null;

$_['chop'] = $chop;
$_['path'] = $task ? '/' . implode('/', $chop) : null;
$_['task'] = $task;

// Normalize path value and remove any `\..` to prevent directory traversal attack
$f = LOT . str_replace(DS . '..', "", strtr($_['path'], '/', DS));
$_['f'] = stream_resolve_include_path($f) ?: null;

// Make sure to have page offset on `items` view
if ($i === null && $task === 'g' && count($chop) === 1 && is_dir($f)) {
    Guard::kick($url->clean . '/1' . $url->query . $url->hash);
}

$GLOBALS['_'] = $_; // Update data

require __DIR__ . DS . 'f.php';
require __DIR__ . DS . 'r' . DS . 'alert.php';
require __DIR__ . DS . 'r' . DS . 'asset.php';
require __DIR__ . DS . 'r' . DS . 'file.php';
require __DIR__ . DS . 'r' . DS . 'hook.php';
require __DIR__ . DS . 'r' . DS . 'language.php';
require __DIR__ . DS . 'r' . DS . 'route.php';