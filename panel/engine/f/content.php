<?php namespace _\lot\x\panel\content;

function Desk($in, $key) {
    \State::set('has.desk', true);
    $out = \_\lot\x\panel\content($in, $key);
    $out[0] = 'main';
    return $out;
}

function Section($in, $key) {
    $out = \_\lot\x\panel\content($in, $key);
    $out[0] = 'section';
    return $out;
}