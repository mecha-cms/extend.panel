<?php

namespace _\lot\x\panel {
    function Bar($in, $key) {
        if (isset($in['lot'])) {
            \_\lot\x\panel\h\p($in['lot'], 'Bar');
        }
        $out = \_\lot\x\panel\lot($in, $key);
        $out[0] = 'nav';
        return $out;
    }
    function Bar_List($in, $key) {
        return \_\lot\x\panel\Menu($in, $key, -1);
    }
    function Button($in, $key) {
        $out = \_\lot\x\panel\Link($in, $key);
        $out[0] = 'button';
        $out['class'] = 'button';
        $out['disabled'] = isset($in['active']) && !$in['active'];
        $out['name'] = $in['name'] ?? $key;
        $out['value'] = $in['value'] ?? null;
        unset($out['href'], $out['target']);
        return $out;
    }
    function Button_($in, $key) {
        return \_\lot\x\panel\Button($in, $key); // Unknown `Button` type
    }
    function Button_Button($in, $key) {
        $out = \_\lot\x\panel\Button($in, $key);
        $out['type'] = 'button';
        return $out;
    }
    function Button_Link($in, $key) {
        $out = \_\lot\x\panel\Link($in, $key);
        \_\lot\x\panel\h\c($out, $in, ['button']);
        return $out;
    }
    function Button_Reset($in, $key) {
        $out = \_\lot\x\panel\Button($in, $key);
        $out['type'] = 'reset';
        return $out;
    }
    function Button_Submit($in, $key) {
        $out = \_\lot\x\panel\Button($in, $key);
        $out['type'] = 'submit';
        return $out;
    }
    function Field($in, $key) {
        $tags = ['field', 'p'];
        if (isset($in['type'])) {
            $tags[] = \strtr(\c2f($in['type'], '-', '.'), '_', ':');
        }
        $id = $in['id'] ?? \uniqid();
        $in[2]['id'] = $in[2]['id'] ?? \str_replace('f:', 'field:', $id);
        $out = [
            0 => $in[0] ?? 'div',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        if (!\array_key_exists('title', $in) || $in['title'] !== false) {
            $title = \_\lot\x\panel\h\title($in, -2, $GLOBALS['language']->{$key});
            $out[1] .= '<label' . (\strip_tags($title) === "" ? ' class="count:0"' : "") . ' for="' . $id . '">' . $title . '</label>';
        }
        $before = "";
        $after = "";
        foreach (['before', 'after'] as $v) {
            if (isset($in[$v])) {
                if (\is_string($in[$v])) {
                    ${$v} = '<span class="fix"><span>' . $in[$v] . '</span></span>';
                } else if (\is_array($in[$v])) {
                    $icon = \_\lot\x\panel\h\icon($in[$v]['icon'] ?? [null, null]);
                    ${$v} = \str_replace('<svg>', '<svg class="fix">', $icon[0]);
                }
            }
        }
        if (isset($in['content'])) {
            if (\is_array($in['content'])) {
                $style = "";
                $in['content'][2]['class'] = $in['content'][2]['class'] ?? "";
                if (isset($in['height']) && $in['height'] !== false) {
                    if ($in['height'] === true) {
                        $in['content'][2]['class'] .= ' height';
                    } else {
                        $style .= 'height:' . (\is_numeric($in['height']) ? $in['height'] . 'px' : $in['height']) . ';';
                    }
                }
                if (isset($in['width']) && $in['width'] !== false) {
                    if ($in['width'] === true) {
                        $in['content'][2]['class'] .= ' width';
                    } else {
                        $style .= 'width:' . (\is_numeric($in['width']) ? $in['width'] . 'px' : $in['width']) . ';';
                    }
                }
                $in['content'][2]['style'] = $style !== "" ? $style : null;
            }
            $out[1] .= '<div><div class="lot' . ($before || $after ? ' lot:input' . (!empty($in['width']) ? ' width' : "") : "") . '">' . $before . \_\lot\x\panel\h\content($in['content']) . $after . '</div>' . \_\lot\x\panel\h\description($in) . '</div>';
        } else if (isset($in['lot'])) {
            $out[1] .= '<div>' . \_\lot\x\panel\h\lot($in['lot']) . '</div>';
        }
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        return new \HTML($out);
    }
    function Fields($in) {
        $tags = ['lot', 'lot:field'];
        $out = [
            0 => $in[0] ?? 'div',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        $append = "";
        if (isset($in['content'])) {
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            \_\lot\x\panel\h\p($in['lot'], 'Field');
            foreach ((new \Anemon($in['lot']))->sort([1, 'stack', 10], true) as $k => &$v) {
                if ($v === null || $v === false || !empty($v['hidden'])) {
                    continue;
                }
                $type = $v['type'] ?? null;
                if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\" . $type, "\\"))) {
                    if ($type !== 'Field_Hidden') {
                        $out[1] .= \call_user_func($fn, $v, $k);
                    } else {
                        $append .= \_\lot\x\panel\Field_Hidden($v, $k);
                    }
                } else {
                    $append .= \_\lot\x\panel\Field_($v, $k); // Unknown `Field` type
                }
                unset($v);
            }
            $out[1] .= $append;
        }
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        return new \HTML($out);
    }
    function File($in, $key) {
        $tags = ['is:file'];
        if (isset($in['active']) && !$in['active']) {
            $tags[] = 'not:active';
        }
        $out = [
            0 => 'li',
            1 => "",
            2 => []
        ];
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        $out[1] .= '<h3>' . \_\lot\x\panel\Link([
            'description' => $in['description'] ?? null,
            'link' => $in['link'] ?? null,
            'title' => $in['title'] ?? null,
            'url' => $in['url'] ?? null
        ], $key) . '</h3>';
        $out[1] .= \_\lot\x\panel\Tasks\Link([
            0 => 'p',
            'lot' => $in['tasks'] ?? []
        ], 0);
        return new \HTML($out);
    }
    function Files($in, $key) {
        $out = [
            0 => 'ul',
            1 => "",
            2 => []
        ];
        $lot = [];
        if (isset($in['lot'])) {
            foreach ($in['lot'] as $k => $v) {
                if ($v === null || $v === false || !empty($v['hidden'])) {
                    continue;
                }
                $lot[$k] = $v;
            }
        }
        $chunk = $in['chunk'] ?? 0;
        $current = $in['current'] ?? 1;
        $lot = $chunk === 0 ? [$lot] : \array_chunk($lot, $chunk, false);
        $count = 0;
        foreach ($lot[$current - 1] ?? [] as $k => $v) {
            $path = $v['path'] ?? false;
            if (!empty($v['current']) || $path && (
                isset($_SESSION['_']['file'][$path]) ||
                isset($_SESSION['_']['folder'][$path])
            )) {
                $v['tags'][] = 'is:active';
                unset($_SESSION['_']['file'][$path]);
                unset($_SESSION['_']['folder'][$path]);
            }
            $out[1] .= \_\lot\x\panel($v, $k);
            ++$count;
        }
        \_\lot\x\panel\h\c($out[2], $in, ['count:' . $count, 'lot', 'lot:file']);
        return new \HTML($out);
    }
    function Folder($in, $key) {
        $name = null;
        $tasks = $in['tasks'] ?? null;
        if ($path = $in['path'] ?? null) {
            $name = \basename($path);
        }
        if (isset($in['title'])) {
            $name = $in['title'];
        }
        $tags = ['is:folder'];
        if (isset($in['active']) && !$in['active']) {
            $tags[] = 'not:active';
        }
        $out = [
            0 => 'li',
            1 => "",
            2 => []
        ];
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        $out[1] .= '<h3>' . \_\lot\x\panel\Link([
            'description' => $in['description'] ?? $GLOBALS['language']->doEnter,
            'link' => $in['link'] ?? null,
            'title' => $name,
            'url' => $in['url'] ?? null
        ], $key) . '</h3>';
        if (\is_array($tasks)) {
            $out[1] .= \_\lot\x\panel\Tasks\Link([
                0 => 'p',
                'lot' => $tasks
            ], 0);
        }
        return new \HTML($out);
    }
    function Form($in, $key) {
        $out = [
            0 => $in[0] ?? 'form',
            1 => $in[1] ?? "",
            2 => []
        ];
        if (isset($in['active']) && empty($in['active'])) {
            $out[0] = false;
        }
        if (isset($in['content'])) {
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            $out[1] .= \_\lot\x\panel\h\lot($in['lot']);
        }
        $href = $in['link'] ?? $in['url'] ?? null;
        \_\lot\x\panel\h\c($out[2], $in);
        $out[2]['action'] = $href;
        $out[2]['name'] = $in['name'] ?? $key;
        return new \HTML($out);
    }
    function Link($in, $key) {
        $out = [
            0 => $in[0] ?? 'a',
            1 => $in[1] ?? "",
            2 => []
        ];
        if ($out[1] === "") {
            $out[1] = \_\lot\x\panel\h\title($in, -1, $GLOBALS['language']->{$key});
        }
        $tags = [];
        $href = $in['link'] ?? $in['url'] ?? \P;
        $href = $href === false ? \P : (string) $href;
        if ($href === \P || (isset($in['active']) && !$in['active'])) {
            $tags[] = 'not:active';
        }
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        $out[2]['href'] = $href === \P ? null : $href;
        $out[2]['target'] = $in[2]['target'] ?? (isset($in['link']) ? '_blank' : null);
        $out[2]['title'] = $in['description'] ?? null;
        return new \HTML($out);
    }
    function Link_($in, $key) {
        return \_\lot\x\panel\Link($in, $key); // Unknown `Link` type
    }
    function Menu($in, $key, int $i = 0) {
        $out = [
            0 => $in[0] ?? 'ul',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        $tags = $i < 0 ? [] : ['lot', 'lot:menu'];
        if (!empty($in['static'])) {
            $tags[] = 'is:static';
        }
        if (isset($in['content'])) {
            $tags[] = 'count:1';
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            $count = 0;
            foreach ((new \Anemon($in['lot']))->sort([1, 'stack', 10], true) as $k => $v) {
                if ($v === null || $v === false || !empty($v['hidden'])) {
                    continue;
                }
                ++$count;
                $li = [
                    0 => 'li',
                    1 => $v[1] ?? "",
                    2 => $v[2] ?? []
                ];
                if (isset($v['type'])) {
                    $li[1] .= \_\lot\x\panel($v, $k);
                } else if (\is_array($v)) {
                    $v['icon'] = \_\lot\x\panel\h\icon($v['icon'] ?? [null, null]);
                    if (!empty($v['lot']) && (!empty($v['caret']) || !\array_key_exists('caret', $v))) {
                        $v['icon'][1] = '<svg class="caret" viewBox="0 0 24 24"><path d="' . ($v['caret'] ?? ($i < 0 ? 'M7,10L12,15L17,10H7Z' : 'M10,17L15,12L10,7V17Z')) . '"></path></svg>';
                    }
                    $ul = "";
                    $a = (array) ($v['tags'] ?? []);
                    if (isset($v['active']) && !$v['active']) {
                        $a[] = 'not:active';
                    }
                    if (!empty($v['current'])) {
                        $a[] = 'is:current';
                    }
                    if (!isset($v[1])) {
                        if (!empty($v['lot'])) {
                            $ul = \_\lot\x\panel\Menu($v, $k, $i + 1); // Recurse
                            $ul['class'] = 'lot lot:menu';
                            $li[1] = $ul;
                            if ($i < 0) {
                                $a[] = 'has:menu';
                            }
                        }
                        unset($v['tags']);
                        $li[1] = \_\lot\x\panel\Link($v, $k) . $ul;
                    }
                    \_\lot\x\panel\h\c($li[2], $v, $a);
                } else {
                    $li[1] = \_\lot\x\panel\Link(['title' => $v], $k);
                }
                $out[1] .= new \HTML($li);
            }
            $tags[] = 'count:' . $count;
        }
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        return new \HTML($out);
    }
    function Page($in, $key) {
        $tags = ['is:file'];
        if (isset($in['active']) && !$in['active']) {
            $tags[] = 'not:active';
        }
        $out = [
            0 => 'li',
            1 => "",
            2 => []
        ];
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        $title = $in['time'] ? \strtr($in['time'], '-', '/') : null;
        $out[1] .= '<div>' . (isset($in['image']) ? '<img alt="" height="72" src="' . $in['image'] . '" width="72">' : '<span class="img" style="background: #' . \substr(\md5(\strtr($in['path'] ?? $key, [
            \ROOT => "",
            \DS => '/'
        ])), 0, 6) . ';"></span>') . '</div>';
        $out[1] .= '<div><h3>' . \_\lot\x\panel\Link([
            'link' => $in['link'] ?? null,
            'title' => $in['title'] ?? $title,
            'url' => $in['url'] ?? null
        ], $key) . '</h3>' . \_\lot\x\panel\h\description($in, $title) . '</div>';
        $out[1] .= '<div>' . \_\lot\x\panel\Tasks\Link([
            0 => 'p',
            'lot' => $in['tasks'] ?? []
        ], 0) . '</div>';
        return new \HTML($out);
    }
    function Pager($in, $key) {
        $in['tags'][] = 'lot';
        $in['tags'][] = 'lot:pager';
        $pager = function($current, $count, $chunk, $peek, $fn, $first, $prev, $next, $last) {
            $begin = 1;
            $end = (int) \ceil($count / $chunk);
            $out = "";
            if ($end <= 1) {
                return $out;
            }
            if ($current <= $peek + $peek) {
                $min = $begin;
                $max = \min($begin + $peek + $peek, $end);
            } else if ($current > $end - $peek - $peek) {
                $min = $end - $peek - $peek;
                $max = $end;
            } else {
                $min = $current - $peek;
                $max = $current + $peek;
            }
            if ($prev) {
                $out = '<span>';
                if ($current === $begin) {
                    $out .= '<b title="' . $prev . '">' . $prev . '</b>';
                } else {
                    $out .= '<a href="' . \call_user_func($fn, $current - 1) . '" title="' . $prev . '" rel="prev">' . $prev . '</a>';
                }
                $out .= '</span> ';
            }
            if ($first && $last) {
                $out .= '<span>';
                if ($min > $begin) {
                    $out .= '<a href="' . \call_user_func($fn, $begin) . '" title="' . $first . '" rel="prev">' . $begin . '</a>';
                    if ($min > $begin + 1) {
                        $out .= ' <span>&#x2026;</span>';
                    }
                }
                for ($i = $min; $i <= $max; ++$i) {
                    if ($current === $i) {
                        $out .= ' <b title="' . $i . '">' . $i . '</b>';
                    } else {
                        $out .= ' <a href="' .\call_user_func($fn, $i) . '" title="' . $i . '" rel="' . ($current >= $i ? 'prev' : 'next') . '">' . $i . '</a>';
                    }
                }
                if ($max < $end) {
                    if ($max < $end - 1) {
                        $out .= ' <span>&#x2026;</span>';
                    }
                    $out .= ' <a href="' . \call_user_func($fn, $end) . '" title="' . $last . '" rel="next">' . $end . '</a>';
                }
                $out .= '</span>';
            }
            if ($next) {
                $out .= ' <span>';
                if ($current === $end) {
                    $out .= '<b title="' . $next . '">' . $next . '</b>';
                } else {
                    $out .= '<a href="' . \call_user_func($fn, $current + 1) . '" title="' . $next . '" rel="next">' . $next . '</a>';
                }
                $out .= '</span>';
            }
            return $out;
        };
        $language = $GLOBALS['language'];
        $in['content'] = $content = $pager($in['current'] ?? 1, $in['count'] ?? 0, $in['chunk'] ?? 20, $in['peek'] ?? 2, function($i) {
            extract($GLOBALS, \EXTR_SKIP);
            return $url . $_['/'] . '::g::' . $_['path'] . '/' . $i . $url->query . $url->hash;
        }, $language->first, $language->prev, $language->next, $language->last);
        $out = \_\lot\x\panel\content($in, $key);
        $out[0] = 'p';
        return $content !== "" ? $out : null;
    }
    function Pages($in, $key) {
        $out = [
            0 => 'ul',
            1 => "",
            2 => []
        ];
        $lot = [];
        if (isset($in['lot'])) {
            foreach ($in['lot'] as $k => $v) {
                if ($v === null || $v === false || !empty($v['hidden'])) {
                    continue;
                }
                $lot[$k] = $v;
            }
        }
        $chunk = $in['chunk'] ?? 0;
        $current = $in['current'] ?? 1;
        $lot = $chunk === 0 ? [$lot] : \array_chunk($lot, $chunk, false);
        $count = 0;
        foreach ($lot[$current - 1] ?? [] as $k => $v) {
            $path = $v['path'] ?? false;
            if (!empty($v['current']) || $path && isset($_SESSION['_']['file'][$path])) {
                $v['tags'][] = 'is:active';
                unset($_SESSION['_']['file'][$path]);
            }
            $out[1] .= \_\lot\x\panel($v, $k);
            ++$count;
        }
        \_\lot\x\panel\h\c($out[2], $in, ['count:' . $count, 'lot', 'lot:page']);
        return new \HTML($out);
    }
    function Tab($in, $key) {
        $out = [
            0 => $in[0] ?? 'section',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        if (isset($in['content'])) {
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            $out[1] .= \_\lot\x\panel\h\lot($in['lot']);
        }
        \_\lot\x\panel\h\c($out[2], $in);
        return new \HTML($out);
    }
    function Tabs($in, $key) {
        $out = [
            0 => $in[0] ?? 'div',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        if (isset($in['content'])) {
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            $name = $in['name'] ?? $key;
            $nav = $section = [];
            $tags = ['lot', 'lot:tab', 'p'];
            $lot = (new \Anemon($in['lot']))->sort([1, 'stack'], true)->get();
            $first = \array_keys($lot)[0] ?? null; // The first tab
            $active = $_GET['tab'][$name] ?? $in['active'] ?? $first ?? null;
            if ($active !== null && isset($lot[$active]) && \is_array($lot[$active])) {
                $lot[$active]['tags'][] = 'is:active';
            } else if ($first !== null && isset($lot[$first]) && \is_array($lot[$first])) {
                $lot[$first]['tags'][] = 'is:active';
            }
            $count = 0;
            foreach ($lot as $k => $v) {
                if ($v === null || $v === false || !empty($v['hidden'])) {
                    continue;
                }
                ++$count;
                $kk = $v['name'] ?? $k;
                if (\is_array($v)) {
                    if (empty($v['url']) && empty($v['link'])) {
                        $v['url'] = $GLOBALS['url']->query('&', [
                            'tab' => [$name => $kk]
                        ]);
                    } else {
                        $v['tags'][] = 'has:link';
                    }
                }
                $nav[$kk] = $v;
                unset($nav[$kk]['lot']); // Disable dropdown menu view
                $section[$kk] = \_\lot\x\panel\Tab($v, $kk);
            }
            $out[1] = '<nav>' . \_\lot\x\panel\Bar_List(['lot' => $nav], $name) . '</nav>';
            $out[1] .= \implode("", $section);
        }
        $tags[] = 'count:' . $count;
        \_\lot\x\panel\h\c($out[2], $in, $tags);
        return new \HTML($out);
    }
    function Tasks($in, $key) {
        $tags = ['lot', 'lot:task'];
        $out = [
            0 => $in[0] ?? 'div',
            1 => $in[1] ?? "",
            2 => $in[2] ?? []
        ];
        $count = 0;
        if (isset($in['content'])) {
            $tags[] = 'count:' . ($count = 1);
            $out[1] .= \_\lot\x\panel\h\content($in['content']);
        } else if (isset($in['lot'])) {
            $out[1] .= \_\lot\x\panel\h\lot($in['lot'], null, $count);
            $tags[] = 'count:' . $count;
        }
        if ($count > 0) {
            \_\lot\x\panel\h\c($out[2], $in, $tags);
            return new \HTML($out);
        }
        return null;
    }
    function abort($in, $key, $fn) {
        if (\defined("\\DEBUG") && \DEBUG) {
            \Guard::abort('Unable to convert data <code>' . \strtr(\htmlspecialchars(\json_encode($in, \JSON_PRETTY_PRINT)), [' ' => '&nbsp;', "\n" => '<br>']) . '</code> because function <code>' . $fn . '</code> does not exist.');
        }
    }
    function content($in, $key) {
        $type = $in['type'] ?? null;
        $title = \_\lot\x\panel\h\title($in, 2);
        $description = \_\lot\x\panel\h\description($in);
        return new \HTML([
            0 => 'div',
            1 => $title . $description . \_\lot\x\panel\h\content($in['content']),
            2 => ['class' => 'count:1 lot' . (isset($type) ? ' lot:' . \implode(' lot:', \step(\c2f($type))) : "")]
        ]);
    }
    function lot($in, $key) {
        $type = $in['type'] ?? null;
        $title = \_\lot\x\panel\h\title($in, 2);
        $description = \_\lot\x\panel\h\description($in);
        $count = 0;
        $out = [
            0 => $in[0] ?? 'div',
            1 => $in[1] ?? $title . $description,
            2 => $in[2] ?? []
        ];
        if (isset($in['lot'])) {
            $out[1] .= \_\lot\x\panel\h\lot($in['lot'], null, $count);
        }
        $out[2] = \array_replace(['class' => 'count:' . $count . ' lot' . (isset($type) ? ' lot:' . \implode(' lot:', \step(\c2f($type))) : "")], $out[2]);
        return new \HTML($out);
    }
}

namespace _\lot\x {
    function panel($in, $key) {
        if (\is_string($in)) {
            return $in;
        }
        if (!empty($in['hidden'])) {
            return "";
        }
        $out = "";
        if ($type = isset($in['type']) ? \strtr($in['type'], '.-', "\\_") : null) {
            if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\" . $type, "\\"))) {
                $out .= \call_user_func($fn, $in, $key);
            } else if (isset($in['content'])) {
                if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\content\\" . $type, "\\"))) {
                    $out .= \call_user_func($fn, $in, $key);
                } else {
                    $out .= \_\lot\x\panel\content($in, $key);
                }
            } else if (isset($in['lot'])) {
                if (\function_exists($fn = \rtrim(__NAMESPACE__ . "\\panel\\lot\\" . $type, "\\"))) {
                    $out .= \call_user_func($fn, $in, $key);
                } else {
                    $out .= \_\lot\x\panel\lot($in, $key);
                }
            } else {
                $out .= \_\lot\x\panel\abort($in, $key, $fn);
            }
        }
        return $out;
    }
}

namespace {
    require __DIR__ . DS . 'f' . DS . 'content.php';
    require __DIR__ . DS . 'f' . DS . 'field.php';
    require __DIR__ . DS . 'f' . DS . 'form.php';
    require __DIR__ . DS . 'f' . DS . 'h.php';
    require __DIR__ . DS . 'f' . DS . 'lot.php';
    require __DIR__ . DS . 'f' . DS . 'tasks.php';
}