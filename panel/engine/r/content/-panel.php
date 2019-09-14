<?php

// Default panel data
return (function($icons) {
    extract($GLOBALS, EXTR_SKIP);
    $id = explode('/', $_['path'], 3)[1];
    $folders = [];
    foreach (g(LOT) as $k => $v) {
        if ($v === 0) {
            $n = basename($k);
            if (strpos('._', $n[0]) !== false) {
                continue; // Skip hidden folder(s)
            }
            $folders[$n] = [
                'current' => strpos($_['path'] . '/', '/' . $n . '/') === 0,
                'icon' => $icons[$n] ?? 'M10,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V8C22,6.89 21.1,6 20,6H12L10,4Z',
                'title' => $language->{$n === 'x' ? 'extension' : $n},
                'url' => $url . $_['//'] . '/::g::/' . $n . '/1'
            ];
        }
    }
    $i = 10;
    $list = [];
    foreach ((new Anemon($folders))->sort([1, 'title'], true) as $k => $v) {
        $v['stack'] = $i;
        $i += 10;
        $list[$k] = $v;
    }
    $alert = ($alert ?? "") . "";
    $user_state = state('user');
    return _\lot\x\panel\lot(['lot' => array_replace_recursive([
        'bar' => [
            'type' => 'Bar',
            'lot' => [
                0 => [
                    'type' => 'List',
                    'lot' => [
                        'folder' => [
                            'icon' => 'M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z',
                            'caret' => false,
                            'title' => false,
                            'url' => $url,
                            'lot' => $list,
                            'tags' => ['is:main'],
                            'stack' => 10
                        ],
                        'search' => [
                            'type' => 'Form.Get',
                            'url' => (is_file($_['f']) ? dirname($url->clean) : $url->clean) . $url->query . $url->hash,
                            'name' => 'search',
                            'lot' => [
                                'fields' => [
                                    'type' => 'Fields',
                                    'lot' => [
                                        'q' => [
                                            '2' => ['title' => $language->doSearch . ': ' . explode('/', $_['path'], 3)[1]],
                                            'type' => 'Text',
                                            'title' => $language->doSearch,
                                            'alter' => $language->doSearch
                                        ]
                                    ]
                                ]
                            ],
                            'stack' => 20
                        ]
                    ],
                    'stack' => 10
                ],
                1 => [
                    'type' => 'List',
                    'lot' => [
                        'site' => [
                            'current' => false,
                            'title' => $language->site,
                            'link' => $url,
                            'lot' => [
                                'user' => [
                                    'icon' => 'M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z',
                                    'title' => $language->user,
                                    'url' => '',
                                    'lot' => [
                                        'g' => [
                                            'icon' => 'M21.7,13.35L20.7,14.35L18.65,12.3L19.65,11.3C19.86,11.09 20.21,11.09 20.42,11.3L21.7,12.58C21.91,12.79 21.91,13.14 21.7,13.35M12,18.94L18.06,12.88L20.11,14.93L14.06,21H12V18.94M12,14C7.58,14 4,15.79 4,18V20H10V18.11L14,14.11C13.34,14.03 12.67,14 12,14M12,4A4,4 0 0,0 8,8A4,4 0 0,0 12,12A4,4 0 0,0 16,8A4,4 0 0,0 12,4Z',
                                            'title' => $language->doEdit,
                                            'url' => $url . $_['//'] . '/::g::/user/' . $user->name(true),
                                            'stack' => 10
                                        ],
                                        'exit' => [
                                            'icon' => 'M19,21V19H15V17H19V15L22,18L19,21M10,4A4,4 0 0,1 14,8A4,4 0 0,1 10,12A4,4 0 0,1 6,8A4,4 0 0,1 10,4M10,14C11.15,14 12.25,14.12 13.24,14.34C12.46,15.35 12,16.62 12,18C12,18.7 12.12,19.37 12.34,20H2V18C2,15.79 5.58,14 10,14Z',
                                            'title' => $language->doExit,
                                            'url' => $url . '/' . ($user_state['//'] ?? $user_state['/']) . '/.' . $user->name . $url->query('&', ['token' => $user['token']]) . $url->hash,
                                            'stack' => 20
                                        ]
                                    ],
                                    'stack' => 10
                                ],
                                'view' => [
                                    'current' => false,
                                    'icon' => 'M14,3V5H17.59L7.76,14.83L9.17,16.24L19,6.41V10H21V3M19,19H5V5H12V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V12H19V19Z',
                                    'title' => $language->doView,
                                    'link' => $url,
                                    'stack' => 20
                                ]
                            ],
                            'stack' => 10
                        ]
                    ],
                    'stack' => 20
                ],
                2 => [
                    'type' => 'List',
                    'lot' => [
                        'alert' => [
                            'icon' => 'M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M14,21A2,2 0 0,1 12,23A2,2 0 0,1 10,21',
                            'caret' => false,
                            'title' => false,
                            'url' => $url . $_['//'] . '/::g::/.alert/1' . $url->query . $url->hash,
                            'stack' => 10
                        ]
                    ],
                    'stack' => 30
                ]
            ],
            'stack' => 10
        ],
        'desk' => [
            'type' => 'Desk',
            'lot' => [
                'form' => [
                    'type' => 'Form.Post',
                    'url' => $url->current,
                    'name' => 'edit',
                    'lot' => [
                        0 => [
                            'type' => 'Section',
                            'lot' => [],
                            'stack' => 10
                        ],
                        'alert' => [
                            'type' => 'Section',
                            'hidden' => $alert === "",
                            'content' => $alert,
                            'stack' => 15
                        ],
                        1 => [
                            'type' => 'Section',
                            'lot' => [
                                'tabs' => [
                                    'type' => 'Tabs',
                                    'name' => 0,
                                    'lot' => []
                                ]
                            ],
                            'stack' => 20
                        ],
                        2 => [
                            'type' => 'Section',
                            'lot' => [],
                            'stack' => 30
                        ]
                    ],
                    'stack' => 10
                ]
            ],
            'stack' => 20
        ]
    ], (array) ($_['lot'] ?? []))], 0);
})([
    'asset' => 'M3,3H21V7H3V3M4,8H20V21H4V8M9.5,11A0.5,0.5 0 0,0 9,11.5V13H15V11.5A0.5,0.5 0 0,0 14.5,11H9.5Z',
    'block' => 'M4,3H5V5H3V4A1,1 0 0,1 4,3M20,3A1,1 0 0,1 21,4V5H19V3H20M15,5V3H17V5H15M11,5V3H13V5H11M7,5V3H9V5H7M21,20A1,1 0 0,1 20,21H19V19H21V20M15,21V19H17V21H15M11,21V19H13V21H11M7,21V19H9V21H7M4,21A1,1 0 0,1 3,20V19H5V21H4M3,15H5V17H3V15M21,15V17H19V15H21M3,11H5V13H3V11M21,11V13H19V11H21M3,7H5V9H3V7M21,7V9H19V7H21Z',
    'cache' => 'M13.5,8H12V13L16.28,15.54L17,14.33L13.5,12.25V8M13,3A9,9 0 0,0 4,12H1L4.96,16.03L9,12H6A7,7 0 0,1 13,5A7,7 0 0,1 20,12A7,7 0 0,1 13,19C11.07,19 9.32,18.21 8.06,16.94L6.64,18.36C8.27,20 10.5,21 13,21A9,9 0 0,0 22,12A9,9 0 0,0 13,3',
    'comment' => 'M12,3C17.5,3 22,6.58 22,11C22,15.42 17.5,19 12,19C10.76,19 9.57,18.82 8.47,18.5C5.55,21 2,21 2,21C4.33,18.67 4.7,17.1 4.75,16.5C3.05,15.07 2,13.13 2,11C2,6.58 6.5,3 12,3Z',
    'content' => 'M13,3V9H21V3M13,21H21V11H13M3,21H11V15H3M3,13H11V3H3V13Z',
    'page' => 'M19,2L14,6.5V17.5L19,13V2M6.5,5C4.55,5 2.45,5.4 1,6.5V21.16C1,21.41 1.25,21.66 1.5,21.66C1.6,21.66 1.65,21.59 1.75,21.59C3.1,20.94 5.05,20.5 6.5,20.5C8.45,20.5 10.55,20.9 12,22C13.35,21.15 15.8,20.5 17.5,20.5C19.15,20.5 20.85,20.81 22.25,21.56C22.35,21.61 22.4,21.59 22.5,21.59C22.75,21.59 23,21.34 23,21.09V6.5C22.4,6.05 21.75,5.75 21,5.5V7.5L21,13V19C19.9,18.65 18.7,18.5 17.5,18.5C15.8,18.5 13.35,19.15 12,20V13L12,8.5V6.5C10.55,5.4 8.45,5 6.5,5V5Z',
    'tag' => 'M5.5,7A1.5,1.5 0 0,1 4,5.5A1.5,1.5 0 0,1 5.5,4A1.5,1.5 0 0,1 7,5.5A1.5,1.5 0 0,1 5.5,7M21.41,11.58L12.41,2.58C12.05,2.22 11.55,2 11,2H4C2.89,2 2,2.89 2,4V11C2,11.55 2.22,12.05 2.59,12.41L11.58,21.41C11.95,21.77 12.45,22 13,22C13.55,22 14.05,21.77 14.41,21.41L21.41,14.41C21.78,14.05 22,13.55 22,13C22,12.44 21.77,11.94 21.41,11.58Z',
    'trash' => 'M21.82,15.42L19.32,19.75C18.83,20.61 17.92,21.06 17,21H15V23L12.5,18.5L15,14V16H17.82L15.6,12.15L19.93,9.65L21.73,12.77C22.25,13.54 22.32,14.57 21.82,15.42M9.21,3.06H14.21C15.19,3.06 16.04,3.63 16.45,4.45L17.45,6.19L19.18,5.19L16.54,9.6L11.39,9.69L13.12,8.69L11.71,6.24L9.5,10.09L5.16,7.59L6.96,4.47C7.37,3.64 8.22,3.06 9.21,3.06M5.05,19.76L2.55,15.43C2.06,14.58 2.13,13.56 2.64,12.79L3.64,11.06L1.91,10.06L7.05,10.14L9.7,14.56L7.97,13.56L6.56,16H11V21H7.4C6.47,21.07 5.55,20.61 5.05,19.76Z',
    'user' => 'M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z',
    'x' => 'M20.5,11H19V7C19,5.89 18.1,5 17,5H13V3.5A2.5,2.5 0 0,0 10.5,1A2.5,2.5 0 0,0 8,3.5V5H4A2,2 0 0,0 2,7V10.8H3.5C5,10.8 6.2,12 6.2,13.5C6.2,15 5,16.2 3.5,16.2H2V20A2,2 0 0,0 4,22H7.8V20.5C7.8,19 9,17.8 10.5,17.8C12,17.8 13.2,19 13.2,20.5V22H17A2,2 0 0,0 19,20V16H20.5A2.5,2.5 0 0,0 23,13.5A2.5,2.5 0 0,0 20.5,11Z'
]);