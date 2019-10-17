<?php

(function() {
    extract($GLOBALS);
    $p = $_['user']['guard']['path'] ?? $_['user']['path'];
    if ($url->path === $p && empty($_GET['kick'])) {
        $_GET['kick'] = $kick = $url . $_['/'] . '::g::' . $_['state']['path'] . '/1';
        Hook::set('content', function($content) use($kick) {
            return Is::user() ? str_replace('<p>', '<p><a class="button" href="' . $kick . '">' . i('Control Panel') . '</a> ', $content) : $content;
        });
    }
})();

Hook::set('on.comment.set', function($comment) {
    extract($GLOBALS, EXTR_SKIP);
    $id = uniqid();
    file_put_contents(LOT . DS . '.alert' . DS . $id . '.page', To::page([
        'title' => i('New %s', 'Comment'),
        'description' => i('A new %s has been added.', 'comment'),
        'type' => 'Info',
        'link' => $url . $_['/'] . '::g::' . strtr($comment->path, [
            LOT => "",
            DS => '/'
        ])
    ]));
});