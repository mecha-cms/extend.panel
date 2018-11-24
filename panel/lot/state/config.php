<?php

return [
    'path' => 'panel',
    '$' => 'page', // default redirect target
    'fonts' => [
        0 => 'Roboto Condensed', // body
        1 => 'Roboto Condensed', // headers
        2 => 'Roboto Condensed', // alternate
        3 => 'Roboto Mono' // code
    ],
    'file' => [
        'chunk' => 50,
        'kin' => 2,
        'size' => [ // minimum and maximum file size to upload in byte(s)
            0, // 0 MB
            4e+6 // 4 MB
        ]
    ],
    'page' => [
        'chunk' => 25,
        'kin' => 2,
        'snippet' => 120,
        'sort' => [-1, 'time'],
        'image' => [
            // <https://en.wikipedia.org/wiki/Display_resolution>
            // CGA (color): 320×200
            // CGA (monochrome): 640×200
            // EGA: 640×350
            // VGA: 640×480
            // HGC: 720×348
            // XGA: 1024×768
            'width' => 640,
            'height' => 480,
            // Upload pattern relative to `ASSET`
            'directory' => '%{extension}%',
            'name' => '%{id}%.%{extension}%'
        ]
    ]
];