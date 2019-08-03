<?php

namespace {}

namespace _\lot\x {
    function panel($in, $key, $type) {
        $out = "";
        $type = \strtr($type, '.-', "\\_");
        if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\" . $type, "\\"))) {
            $out .= \call_user_func($fn, $in, $key, $type);
        } else if (isset($in['content'])) {
            if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\content\\" . $type, "\\"))) {
                $out .= \call_user_func($fn, $in['content'], $key, $type);
            } else {
                $out .= panel\content($in['content'], $key, $type);
            }
        } else if (isset($in['lot'])) {
            if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\lot\\" . $type, "\\"))) {
                $out .= \call_user_func($fn, $in['lot'], $key, $type);
            } else {
                $out .= panel\lot($in['lot'], $key, $type);
            }
        } else {
            $out .= panel\abort($in, $key, $fn);
        }
        return $out;
    }
}

namespace _\lot\x\panel {
    function a($in) {
        if (!isset($in[1])) {
            $icon = \_\lot\x\panel\h\icon($in['icon'] ?? [null, null]);
            if ($title = $in['title'] ?? "") {
                $title = '<span>' . $title . '</span>';
            }
            $in[1] = $icon[0] . $title . $icon[1];
        }
        $href = $in['link'] ?? $in['url'] ?? \_\lot\x\panel\h\url($in['path'] ?? null);
        $out = new \HTML([$in[0] ?? 'a', $in[1], [
            'class' => $href === null ? 'disabled' : null,
            'href' => $href === null ? 'javascript:;' : $href,
            'target' => isset($in['link']) ? '_blank' : ($in[2]['target'] ?? false)
        ]]);
        return $out;
    }
    function abort($in, $key, $fn) {
        if (\defined('DEBUG') && DEBUG) {
            \Guard::abort('Unable to convert data <code>' . \strtr(\json_encode($in, \JSON_PRETTY_PRINT), [' ' => '&nbsp;', "\n" => '<br>']) . '</code> because function <code>' . $fn . '</code> does not exist.');
        }
    }
    function field($in) {}
    function content($in, $key, $type) {
        return new \HTML([
            0 => 'div',
            1 => \is_array($in) ? new \HTML($in) : $in,
            2 => ['class' => 'content' . ($type !== '#' ? ' content:' . \c2f($type) : "")]
        ]);
    }
    function form($in, $key, $type) {
        if (isset($in['lot']) && \is_array($in['lot'])) {
            $out = \_\lot\x\panel\lot($in['lot'], $key, $type);
        } else if (isset($in['content'])) {
            $out = \_\lot\x\panel\content($in['content'], $key, $type);
        } else {
            $out = \_\lot\x\panel($in, $key, $type);
        }
        $href = $in['link'] ?? $in['url'] ?? \_\lot\x\panel\h\url($in['path'] ?? null);
        $out[0] = 'form';
        $out['action'] = $href;
        $out['name'] = $in['name'] ?? $key;
        return $out;
    }
    function lot($in, $key, $type) {
        $out = [
            0 => 'div',
            1 => "",
            2 => ['class' => 'lot' . ($type !== '#' ? ' lot:' . \c2f($type) : "")]
        ];
        if (!empty($in) && \is_array($in)) {
            foreach (\Anemon::from($in)->sort([1, 'stack', 10], true) as $k => $v) {
                $out[1] .= \_\lot\x\panel($v, $k, $v['type'] ?? '#');
            }
        }
        return new \HTML($out);
    }
    function tab($in, $key, $type) {
        if (isset($in['lot']) && \is_array($in['lot'])) {
            $out = new \HTML([
                0 => 'div',
                1 => "",
                2 => \_\lot\x\panel\h\c($in)
            ]);
            $nav = [];
            $section = [];
            $out['class'] = \trim($out['class'] . ' lot lot:tab');
            $active = $in['active'] ?? \array_keys($in['lot'])[0] ?? null;
            foreach (\Anemon::from($in['lot'])->sort([1, 'stack'], true) as $k => $v) {
                $content = "";
                if (\is_array($v)) {
                    if ($k === $active) {
                        $v['tags'][] = 'active';
                    }
                    if (isset($v['content'])) {
                        $content = $v['content'];
                        unset($v['content']);
                        $v['path'] = '?tab[0]=' . $k;
                    }
                }
                $nav[$k] = $v;
                $section[$k] = $content;
            }
            // TODO
            $out[1] = '<nav>' . \_\lot\x\panel(['lot' => $nav], 0, 'nav.ul') . '</nav>';
            $out[1] .= '<section>' . \implode('</section><section>', $section) . '</section>';
        } else if (isset($in['content'])) {
            $out = \_\lot\x\panel\content($in['content'], $key, $type);
        } else {
            $out = \_\lot\x\panel($in, $key, $type);
        }
        return $out;
    }
}

namespace _\lot\x\panel\form {
    function post($in, $key, $type) {
        $out = \_\lot\x\panel\form($in, $key, $type);
        $out['method'] = 'post';
        return $out;
    }
}

// [content]
namespace _\lot\x\panel\content {
    function desk($in, $key, $type) {
        return \_\lot\x\panel\content($in, $key, $type);
    }
    function li($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'li';
        return $out;
    }
    function nav($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'nav';
        return $out;
    }
    function ol($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'ol';
        return $out;
    }
    function ul($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'ul';
        return $out;
    }
}

// [lot]
namespace _\lot\x\panel\lot {
    function desk($in, $key, $type) {
        return \_\lot\x\panel\lot($in, $key, $type);
    }
    function field($in, $key, $type) {}
    function li($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'li';
        return $out;
    }
    function nav($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'nav';
        return $out;
    }
    function ol($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'ol';
        return $out;
    }
    function ul($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'ul';
        return $out;
    }
}

// [content]
namespace _\lot\x\panel\content\desk {
    function body($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'main';
        return $out;
    }
    function footer($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'footer';
        return $out;
    }
    function header($in, $key, $type) {
        $out = \_\lot\x\panel\content($in, $key, $type);
        $out[0] = 'header';
        return $out;
    }
}

// [lot]
namespace _\lot\x\panel\lot\desk {
    function body($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'main';
        return $out;
    }
    function footer($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'footer';
        return $out;
    }
    function header($in, $key, $type) {
        $out = \_\lot\x\panel\lot($in, $key, $type);
        $out[0] = 'header';
        return $out;
    }
}


// [h]: Helper function(s)
namespace _\lot\x\panel\h {
    function c($in) {
        $a = \implode(' ', (array) ($in[2] ?? []));
        $b = \implode(' ', (array) ($in['tags'] ?? []));
        $c = \implode(' ', \array_unique(\array_filter(\array_merge(\explode(' ', $a), \explode(' ', $b)))));
        $in[2]['class'] = $c !== "" ? $c : null;
        return $in[2];
    }
    function icon($in) {
        $icon = \array_replace([null, null], (array) $in);
        if ($icon[0] && strpos($icon[0], '<') === false) {
            $icon[0] = '<svg viewBox="0 0 24 24"><path d="' . $icon[0] . '"></path></svg>';
        }
        if ($icon[1] && strpos($icon[1], '<') === false) {
            $icon[0] = '<svg viewBox="0 0 24 24"><path d="' . $icon[1] . '"></path></svg>';
        }
        return $icon;
    }
    function link($value) {
        return url($value, $in);
    }
    function url($value) {
        return \is_string($value) ? \URL::long($value, false) : null;
    }
}

namespace _\lot\x\panel\nav {
    function ul($in, $key, $type, int $i = 0) {
        $out = [
            0 => $in[0] ?? 'ul',
            1 => "",
            2 => \_\lot\x\panel\h\c($in)
        ];
        if (isset($in['content'])) {
            $out[1] = \is_array($in['content']) ? new \HTML($in['content']) : $in['content'];
        } else if (isset($in['lot'])&& \is_array($in['lot'])) {
            foreach ($in['lot'] as $k => $v) {
                $li = new \HTML(['li', ""]);
                if (\is_array($v)) {
                    $v['icon'] = \_\lot\x\panel\h\icon($v['icon'] ?? [null, null]);
                    if (!empty($v['lot']) && (!empty($v['caret']) || !\array_key_exists('caret', $v))) {
                        $v['icon'][1] = '<svg class="caret" viewBox="0 0 24 24"><path d="' . ($v['caret'] ?? ($i === 0 ? 'M7,10L12,15L17,10H7Z' : 'M10,17L15,12L10,7V17Z')) . '"></path></svg>';
                    }
                    $li[1] = \_\lot\x\panel\a($v);
                    $li[2] = \_\lot\x\panel\h\c($v);
                    if (!empty($v['lot']) && (!\array_key_exists(0, $v) || \is_string($v[0]))) {
                        $ul = ul($v, $k, $type, $i + 1); // Recurse
                        $ul['class'] = 'lot lot:menu';
                        if ($i === 0) {
                            $li['class'] = \trim($li['class'] . ' drop');
                        }
                        $li[1] .= $ul;
                    }
                } else {
                    $li[1] = \_\lot\x\panel\a(['title' => $v]);
                }
                $out[1] .= $li;
            }
        } else if (isset($in[1])) {
            $out[1] = $in[1];
        }
        return new \HTML($out);
    }
}