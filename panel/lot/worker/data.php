<?php

require __DIR__ . DS . 'file.php';

$f = LOT . DS . $id . DS . $panel->path;
if ($c === 's' && is_file($f)) {
    Guardian::kick(str_replace('::s::', '::g::', $url->current . $url->query));
}

// Remove folder and blob tab(s)
Config::reset('panel.desk.body.tabs.folder');
Config::reset('panel.desk.body.tabs.blob');

Config::set('panel.desk.body.tabs.file.fields', [
    'name' => [
        'key' => 'key',
        'value' => $c === 'g' ? Path::N($path) : null,
        'pattern' => '^-?[a-z\\d]+(-[a-z\\d]+)*$'
    ],
    'x' => [
        'type' => 'hidden',
        'value' => 'data',
        'stack' => 0
    ],
    'file[consent]' => [
        'type' => 'hidden',
        'value' => '0600'
    ]
]);

// Modify back menu destination
if ($x = HTTP::get('x')) {
    Hook::set('on.ready', function() use($c, $language, $panel, $path, $x) {
        if ($c === 'g') {
            Config::set('panel.nav.s', [
                'description' => $language->new__($language->data, true),
                'icon' => [['M2,16H10V14H2M18,14V10H16V14H12V16H16V20H18V16H22V14M14,6H2V8H14M14,10H2V12H14V10Z']]
            ]);
            $path = dirname($path);
        }
        $path .= '.' . $x;
        if (file_exists($path)) {
            Config::set('panel.nav.lot', [
                'c' => 'g',
                'path' => Path::R($path, LOT, '/'),
                'query' => [
                    'tab' => ['data'],
                    'view' => false,
                    'x' => false
                ]
            ]);
        }
    });
}