<?php namespace _\lot\x\panel;

// Load task(s) before everything else!
if (\is_file($v = __DIR__ . \DS . 'task' . \DS . $_['task'] . '.php')) {
    (static function($v) {
        extract($GLOBALS, \EXTR_SKIP);
        require $v;
        if (isset($_) && \is_array($_)) {
            $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
        }
    })($v);
}

function route() {
    if (!\Is::user()) {
        \Guard::kick("");
    }
    // Load default panel definition
    $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'] ?? [], require __DIR__ . \DS . '..' . \DS . 'r.php');
    extract($GLOBALS, \EXTR_SKIP);
    $f = $_['f'];
    $route = false;
    foreach (\step($_['path'], '/') as $v) {
        if (\function_exists($fn = __NAMESPACE__ . "\\route\\" . \f2p(\strtr($v, '/', '.')))) {
            $route = $fn;
            break;
        }
    }
    $set = static function() {
        // Load panel definition from a file stored in `.\lot\x\*\index\panel.php`
        foreach ($GLOBALS['X'][1] as $v) {
            \is_file($v = \Path::F($v) . \DS . 'panel.php') && (static function($v) {
                extract($GLOBALS, \EXTR_SKIP);
                require $v;
                if (isset($_) && \is_array($_)) {
                    $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
                }
            })($v);
        }
        // Load panel definition from a file stored in `.\lot\layout\index\panel.php`
        \is_file($v = \LOT . \DS . 'layout' . \DS . 'index' . \DS . 'panel.php') && (static function($v) {
            extract($GLOBALS, \EXTR_SKIP);
            require $v;
            if (isset($_) && \is_array($_)) {
                $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
            }
        })($v);
    };
    if ('GET' === $_SERVER['REQUEST_METHOD']) {
        // Redirect if file already exists
        if ('s' === $_['task'] && $f && \is_file($f)) {
            $_['alert']['info'][] = ['File %s already exists.', ['<code>' . \_\lot\x\panel\h\path($f) . '</code>']];
            $_['kick'] = \str_replace('::s::', '::g::', $url->current);
        }
        if (
            // No route match
            !$route && (
                // Trying to get file that does not exist
                'g' === $_['task'] && !$f ||
                // Trying to set file from a folder that does not exist
                's' === $_['task'] && (!$f || !\is_dir($f))
            )
        ) {
            $GLOBALS['t'][] = \i('Error');
            \State::set([
                '[layout]' => ['type:' . $_['type'] => false],
                'is' => [
                    'error' => 404
                ]
            ]);
            // Load panel definition from other extension(s)
            $set();
            $this->layout('404/panel');
        }
    }
    // Pre-define state
    \State::set([
        'has' => [
            'parent' => \count($_['chops']) > 1,
        ],
        'is' => [
            'error' => false,
            'page' => !isset($_['i']),
            'pages' => isset($_['i'])
        ]
    ]);
    $data = null;
    if (!isset($_GET['type']) && !isset($_['type'])) {
        // Auto-detect layout type
        if ($f) {
            if (\is_dir($f)) {
                $_['type'] = 'folder';
            } else if (\is_file($f)) {
                $_['type'] = 'file';
            }
            // Put data
            $GLOBALS['_'] = $_;
        }
        // Manually set layout type based on file path
        foreach (\array_reverse(\step($_['path'], '/')) as $v) {
            (static function($v) use(&$data) {
                if (\is_file($v)) {
                    extract($GLOBALS, \EXTR_SKIP);
                    require ($data = $v);
                    if (isset($_) && \is_array($_)) {
                        $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
                    }
                }
            })(__DIR__ . \DS . 'lot' . \DS . 'page' . ($_['i'] ? 's' : "") . \DS . $v . '.php');
        }
        // Get data
        $_ = $GLOBALS['_'];
    }
    // Set layout type
    if (!$data) {
        $k = \explode('/', $_['type'] ?? \P, 2);
        $k[0] .= ($_['i'] ? 's' : "");
        $data = __DIR__ . \DS . 'type' . \DS . \implode(\DS, $k) . '.php';
    }
    // Load panel definition from other extension(s)
    $set();
    // Define lot with no filter
    (static function($data) {
        extract($GLOBALS, \EXTR_SKIP);
        $_['lot'] = \array_replace_recursive($_['lot'] ?? [], (array) (\is_file($data) ? require $data : []));
        $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
    })($data);
    // Filter by status
    \is_file($v = __DIR__ . \DS . 'lot' . \DS . 'user' . \DS . $user['status'] . '.php') && (static function($v) {
        extract($GLOBALS, \EXTR_SKIP);
        require $v;
        if (isset($_) && \is_array($_)) {
            $GLOBALS['_'] = \array_replace_recursive($GLOBALS['_'], $_);
        }
    })($v);
    // Get data
    $_ = $GLOBALS['_'];
    // Filter by route function
    $_['form'] = \e($GLOBALS['_' . ($_SERVER['REQUEST_METHOD'] ?? 'GET')] ?? []);
    $GLOBALS['_']['form'] = $_['form'];
    if ($route && $r = \fire($route, [$_], $this)) {
        $_ = $r;
    }
    // Filter by hook
    if ($r = \Hook::fire('_', [$_])) {
        $_ = $r;
    }
    // Put data
    $GLOBALS['_'] = $_;
    if (isset($_['form']['token'])) {
        if (isset($_['type'])) {
            $hooks = \map(\step($_['type'], '/'), function($hook) use($_) {
                return 'do.' . $hook . '.' . ([
                    'g' => 'get',
                    'l' => 'let',
                    's' => 'set'
                ][$_['task']] ?? '?');
            });
            foreach (\array_reverse($hooks) as $hook) {
                if ($r = \Hook::fire($hook, [$_, $_['form']])) {
                    $_ = $r;
                }
            }
        } else {
            // Form data has been processed through a blank layout
        }
    } else {
        // Missing `<input name="token">`
    }
    // Has alert data from queue
    if (!empty($_['alert'])) {
        // Make alert section visible
        $_['lot']['desk']['lot']['form']['lot']['alert']['skip'] = false;
        foreach ((array) $_['alert'] as $k => $v) {
            foreach ((array) $v as $vv) {
                $vv = (array) $vv;
                \call_user_func("\\Alert::" . $k, ...$vv);
            }
        }
    }
    if (isset($_['kick'])) {
        \Guard::kick($_['kick']);
    } else {
        if (isset($_['form']['token'])) {
            \Guard::kick($url->clean . $url->i . $url->query('&', [
                'token' => false
            ]) . $url->hash);
        }
    }
    \State::set('[layout].type:' . ($_['type'] ?? 'blank'), true);
    $n = \ltrim($_['chops'][0] ?? "", '_.-');
    // Put data
    $GLOBALS['_'] = $_;
    $GLOBALS['t'][] = \i('Panel');
    if (isset($_['title'])) {
        $GLOBALS['t'][] = \i($_['title']); // Custom panel title
    } else {
        $GLOBALS['t'][] = isset($_['path']) ? \i('x' === $n ? 'Extension' : \To::title($n)) : null;
    }
    // Has alert data from previous session
    if (count($GLOBALS['alert'] ?? [])) {
        // Make alert section visible
        $GLOBALS['_']['lot']['desk']['lot']['form']['lot']['alert']['skip'] = false;
    }
    $this->layout('200/panel');
}

\Route::set($_['/'] . '/*', 200, __NAMESPACE__ . "\\route", 20);
