<?php

// Prevent user(s) from modifying the `type`
if ('g' === $_['task'] && isset($_GET['type'])) {
    Alert::error(i('Permission denied for your current user status: %s', '<code>' . $user['status'] . '</code>') . '<br><small>' . $url->current . '</small>');
    Guard::kick($url->clean . $url->query('&', ['type' => false]) . $url->hash);
}

// Items page (has page offset in URL)
if (isset($_['i'])) {
    // Change asset menu link to jump to the user file(s)
    $_['lot']['bar']['lot'][0]['lot']['folder']['lot']['asset']['url'] = $url . $_['/'] . '/::g::/asset/' . $user->user . '/1';
    // Hide these menu(s)
    foreach (['block', 'cache', 'layout', 'route', 'trash', 'user', 'x'] as $n) {
        $_['lot']['bar']['lot'][0]['lot']['folder']['lot'][$n]['skip'] = true;
    }
}

// Hide main state link
$_['lot']['bar']['lot'][1]['lot']['site']['lot']['state']['skip'] = true;

// Hide these page(s)
foreach (['block', 'cache', 'layout', 'route', 'trash', 'x'] as $n) {
    if (0 === strpos($_['path'] . '/', '/' . $n . '/')) {
        Alert::error(i('Permission denied for your current user status: %s', '<code>' . $user['status'] . '</code>') . '<br><small>' . $url->current . '</small>');
        Guard::kick($url . $_['/'] . '/::g::/user/' . $user->name(true) . $url->query('&', [
            'tab' => false,
            'type' => false
        ]) . $url->hash);
    }
}