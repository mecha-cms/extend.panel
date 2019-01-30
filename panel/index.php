<?php

$is_enter = Is::user();
if (!HTTP::is('get', 'kick') && !$is_enter) {
    $state = Extend::state('user');
    if ($url->path === ($state['_path'] ?? $state['path'])) {
        $a = Extend::state('panel');
        // Set redirection path after log-in
        Cookie::reset(URL::session . '.previous');
        Session::reset(URL::session . '.previous');
        Set::get('kick', $a['path'] . '/::g::/' . $a['$']);
        return;
    }
}

$state = Extend::state('panel');
$p = $state['path'];

$chops = explode('/', $url->path);
$r = array_shift($chops);
$c = str_replace('::', "", array_shift($chops));
$id = array_shift($chops);
$path = implode('/', $chops);

// Trigger notification on comment set
if (Extend::exist('comment')) {
    Hook::set('on.comment.set', function($page) use($language, $p) {
        $path = $this->path;
        Page::set(extend((array) $language->o_message_info_comment_set, [
            'type' => 'info',
            'link' => $p . '/::g::/' . Path::R($path, LOT, '/')
        ]))->saveTo(LOT . DS . '.message' . DS . md5($path) . '.page');
    });
}

// Trigger notification on poll set
if (Extend::exist('poll')) {
    Hook::set('on.poll.set', function() {
        // TODO
    });
}

// Trigger notification on markdown link error
if (Plugin::exist('markdown.link')) {
    Hook::set('on.markdown.link.x', function() {
        // TODO
    });
}

if ($r === $p && (file_exists(__DIR__ . DS . 'task.php') || $is_enter)) {
    require __DIR__ . DS . '_index.php';
}