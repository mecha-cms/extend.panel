<?php

// `http://127.0.0.1/panel/::g::/x/foo-bar/1`
$i = count($_['chop']);
if ($i > 1) {
    $lot = require __DIR__ . DS . '..' . DS . $_['content'] . 's.php';
    if ($i === 2) {
        $GLOBALS['_']['lot']['bar']['lot'][0]['lot']['folder']['icon'] = 'M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z';
        $GLOBALS['_']['lot']['bar']['lot'][0]['lot']['folder']['url'] = $url . $_['/'] . '::g::' . dirname($_['path']) . '/1' . $url->query('&', ['content' => false, 'tab' => false]) . $url->hash;
        $GLOBALS['_']['lot']['bar']['lot'][0]['lot']['folder']['lot'] = false;
        if (is_file($f = ($ff = $_['f']) . DS . 'about.page')) {
            $page = new Page($f);
            // Hide some file(s) from the list
            foreach ([
                // Parent folder
                $ff,
                // About file
                $ff . DS . 'about.page',
                // License file
                $ff . DS . 'LICENSE',
                // Custom stack data
                $ff . DS . basename($ff)
            ] as $p) {
                $lot['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['files']['lot']['files']['lot'][$p]['hidden'] = true;
            }
            $lot['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['info'] = [
                'title' => 'Info',
                'lot' => [
                    0 => [
                        'title' => $page->title,
                        'description' => _\lot\x\panel\h\w($page->description, 'a'),
                        'type' => 'Section',
                        'content' => $page->content,
                        'stack' => 10
                    ]
                ],
                'stack' => 20
            ];
        }
        if (is_file($f = $ff . DS . 'LICENSE')) {
            $lot['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['license'] = [
                'lot' => [
                    0 => [
                        'type' => 'Section',
                        'content' => '<pre class="is:text"><code class="txt">' . htmlspecialchars(file_get_contents($f)) . '</code></pre>',
                        'stack' => 10
                    ]
                ],
                'stack' => 30
            ];
        }
    }
    return $lot;
}

// `http://127.0.0.1/panel/::g::/x/1`
$GLOBALS['_']['content'] = $_['content'] = 'page';

$lot = require __DIR__ . DS . '..' . DS . $_['content'] . 's.php';

$lot['bar']['lot'][0]['lot']['search']['hidden'] = true; // Hide search form

$pages = [];
$count = 0;

if (is_dir($folder = LOT . strtr($_['path'], '/', DS))) {
    $before = $url . $_['/'] . '::';
    foreach (g($folder, 'page', 1) as $k => $v) {
        if (basename($k) !== 'about.page') {
            continue;
        }
        $after = '::' . strtr($kk = dirname($k), [
            LOT => "",
            DS => '/'
        ]);
        $n = basename($kk);
        $page = new Page($k);
        $image = glob($kk . DS . 'lot' . DS . 'asset' . DS . '{gif,jpg,jpeg,png}' . DS . $n . '.{gif,jpg,jpeg,png}', GLOB_BRACE | GLOB_NOSORT);
        $image = $image ? To::URL($image[0]) : null;
        $pages[$k] = [
            'path' => $k,
            'title' => _\lot\x\panel\h\w($page->title),
            'description' => _\lot\x\panel\h\w($page->description),
            'type' => 'Page',
            'image' => $image,
            'url' => $before . 'g' . $after . '/1' . $url->query('&', ['tab' => ['info']]),
            'time' => $page->time . "",
            'tasks' => [
                'g' => [
                    'title' => 'Edit',
                    'description' => 'Edit',
                    'icon' => 'M5,3C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19H5V5H12V3H5M17.78,4C17.61,4 17.43,4.07 17.3,4.2L16.08,5.41L18.58,7.91L19.8,6.7C20.06,6.44 20.06,6 19.8,5.75L18.25,4.2C18.12,4.07 17.95,4 17.78,4M15.37,6.12L8,13.5V16H10.5L17.87,8.62L15.37,6.12Z',
                    'url' => $before . 'g' . $after . '/1' . $url->query('&', ['tab' => ['files']]) . $url->hash,
                    'stack' => 20
                ],
                'l' => [
                    'title' => 'Delete',
                    'description' => 'Delete',
                    'icon' => 'M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19M8,9H16V19H8V9M15.5,4L14.5,3H9.5L8.5,4H5V6H19V4H15.5Z',
                    'url' => $before . 'l' . $after . $url->query('&', ['tab' => false, 'token' => $_['token']]),
                    'stack' => 30
                ]
            ]
        ];
        ++$count;
    }
    $pages = (new Anemon($pages))->sort($_['sort'], true)->get();
    $lot['desk']['lot']['form']['lot'][1]['lot']['tabs']['lot']['pages']['lot']['pages']['lot'] = $pages;
    $lot['desk']['lot']['form']['lot'][2]['lot']['pager']['count'] = $count;
}

$lot['desk']['lot']['form']['lot'][0]['lot']['tasks']['lot']['page']['hidden'] = true;
$lot['desk']['lot']['form']['lot'][0]['lot']['tasks']['lot']['blob']['hidden'] = false;
$lot['desk']['lot']['form']['lot'][0]['lot']['tasks']['lot']['blob']['title'] = 'Upload';
$lot['desk']['lot']['form']['lot'][0]['lot']['tasks']['lot']['blob']['description'] = false;

return $lot;