<?php namespace _\lot\x\panel;

// Task
if (\is_file($_task = __DIR__ . \DS . 'task' . \DS . $_['task'] . '.php')) {
    require $_task;
}

function _() {
    extract($GLOBALS);
    $_state = __DIR__ . \DS . 'state' . \DS;
    if (\defined("\\DEBUG") && \DEBUG && isset($_GET['test'])) {
        $_lot = $_state . 'test' . \DS . \basename(\urlencode($_GET['test'])) . '.php';
    } else {
        $_lot = $_state . $_['content'] . ($_['i'] ? 's' : "") . '.php';
        if (!isset($_GET['content'])) {
            // Auto-detect content type
            if ($_['f']) {
                $GLOBALS['_']['content'] = $_['content'] = \is_dir($_['f']) ? 'folder' : 'file';
                $_lot = $_state . $_['content'] . ($_['i'] ? 's' : "") . '.php'; // Update data
            }
            // Manually set content type based on file path
            foreach (\array_reverse(\step(\trim($_['path'], '/'), '/')) as $_path) {
                (function($_path) use(&$_lot) {
                    if (\is_file($_path)) {
                        extract($GLOBALS, \EXTR_SKIP);
                        $_lot = $_path; // Update data
                        require $_path;
                    }
                })($_state . 'file' . ($_['i'] ? 's' : "") . \DS . $_path . '.php');
            }
            $_ = $GLOBALS['_']; // Update data
        }
    }
    foreach ($GLOBALS['X'][1] as $_index) {
        \is_file($_f = \dirname($_index) . \DS . 'panel.php') && (function($_f) {
            extract($GLOBALS, \EXTR_SKIP);
            require $_f;
        })($_f);
    }
    \State::set('[content].content:' . $_['content'], true);
    (function($_lot) {
        extract($GLOBALS, \EXTR_SKIP);
        // Define lot with no filter
        $GLOBALS['_']['lot'] = $_['lot'] = \array_replace_recursive($_['lot'] ?? [], (array) (\is_file($_lot) ? require $_lot : []));
        // Filter by status
        \is_file($_f = __DIR__ . \DS . 'user' . \DS . $user['status'] . '.php') && (function($_f) {
            extract($GLOBALS, \EXTR_SKIP);
            require $_f;
        })($_f);
        $_ = $GLOBALS['_']; // Update data
        // Filter by path
        foreach (\step(\trim($_['path']), '/') as $_v) {
            \is_file($_f = __DIR__ . \DS . 'path' . \DS . \strtr($_v, '/', \DS) . '.php') && (function($_f) {
                extract($GLOBALS, \EXTR_SKIP);
                require $_f;
            })($_f);
        }
        $_ = $GLOBALS['_']; // Update data
        $_form = \e($GLOBALS['_' . ($_SERVER['REQUEST_METHOD'] ?? 'GET')] ?? []);
        // Filter by function (TODO: Move this to a separate file)
        foreach (['data', 'file', 'page', 'state'] as $_scope) {
            if (!empty($_['form'][$_scope])) {
                foreach ($_['form'][$_scope] as $_k => $_v) {
                    if (!isset($_v)) {
                        continue;
                    }
                    $_vv = $_form[$_scope][$_k] ?? null;
                    $_form[$_scope][$_k] = \is_callable($_v) ? \call_user_func($_v, $_vv, $_form) : $_v;
                }
            }
        }
        if (isset($_form['token'])) {
            $_hooks = \map(\step($_['content']), function($_hook) use($_) {
                return 'do.' . $_hook . '.' . ([
                    'g' => 'get',
                    'l' => 'let',
                    's' => 'set'
                ][$_['task']] ?? '/');
            });
            foreach (\array_reverse($_hooks) as $_hook) {
                if ($_r = \Hook::fire($_hook, [$_, $_form])) {
                    $GLOBALS['_'] = $_ = $_r;
                }
            }
            if (!empty($_['alert'])) {
                foreach ((array) $_['alert'] as $_k => $_v) {
                    foreach ((array) $_v as $_alert) {
                        $_alert = (array) $_alert;
                        \call_user_func("\\Alert::" . $_k, ...$_alert);
                    }
                }
            }
            if (!empty($_['kick'])) {
                \Guard::kick($_['kick']);
            }
        }
    })($_lot);
}

\Hook::set('start', __NAMESPACE__ . "\\_", 20);

\Hook::set('set', function() {
    $panel = require __DIR__ . \DS . 'content' . \DS . '-panel.php';
    $icon = require __DIR__ . \DS . 'content' . \DS . '-icon.php'; // Require icon(s) later
    $GLOBALS['content'] = $icon . $panel; // But load icon(s) first
}, 1000);