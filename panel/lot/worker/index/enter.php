<?php

if ($__action !== 'g') {
    Shield::abort(PANEL_404);
}

if ($__user_enter) {
    Guardian::kick($__state->path . '/::g::/page');
}

Config::set([
    'is' => 'page',
    'panel' => [
        'c:f' => true
    ]
]);

if (Request::is('post')) {
    $__user_key = Request::post('user');
    $__user_pass = Request::post('pass');
    $__user_token = Request::post('token');
    if (strpos($__user_key, '@') === 0) {
        $__user_key = substr($__user_key, 1); // remove the `@`
    }
    $f = USER . DS . $__user_key;
    if (!$__user_key) {
        Message::error('void_field', $language->user, true);
    } else if (!$__user_pass) {
        Message::error('void_field', $language->pass, true);
    } else if (file_exists($f . '.page')) {
        if (!file_exists($f . DS . 'pass.data')) {
            // Reset password by deleting `pass.data` manually, then log in!
            File::write(password_hash($__user_pass . ' ' . $__user_key, PASSWORD_DEFAULT))->saveTo($f . DS . 'pass.data');
            Message::success('create', $language->pass);
            Message::info('is', [$language->pass, '<em>' . $__user_pass . '</em>']);
        }
        if (password_verify($__user_pass . ' ' . $__user_key, File::open($f . DS . 'pass.data')->get(0, ""))) {
            File::write($__user_token)->saveTo($f . DS . 'token.data');
            User::set($__user_key, $__user_token);
            Message::success('user_enter');
            Hook::fire('on.user.enter');
            Guardian::kick(Request::post('kick', ""));
        } else {
            Message::error('user_or_pass');
        }
    } else {
        Message::error('user_or_pass');
    }
    if (Message::$x) {
        Request::save('post', 'user', '@' . $__user_key);
    }
}