<?php

if (Is::void($name)) {
    Message::error(To::sentence($language->error));
}

Hook::set('guardian.kick', function($url) {
    if (!Message::$x) {
        if ($x = HTTP::get('x')) {
            return dirname($url) . '.' . $x . To::query(['tab' => ['data']]);
        }
        return $url;
    }
}, 0);