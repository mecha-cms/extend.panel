<?php

// `http://127.0.0.1/panel/::g::/page/foo-bar.page`
$GLOBALS['_']['content'] = $_['content'] = [
    'archive' => 'page',
    'data' => 'data',
    'draft' => 'page',
    'page' => 'page'
][pathinfo($_['f'], PATHINFO_EXTENSION)] ?? (is_dir($_['f']) ? 'folder' : 'file');

return require __DIR__ . DS . '..' . DS . $_['content'] . '.php';