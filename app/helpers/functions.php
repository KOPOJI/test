<?php

/**
 * @param string|null $text
 * @return string
 */
function h($text = null) {
    return htmlspecialchars($text);
}

function dump() {
    echo '<pre>';
    var_dump(func_get_args());
    echo '</pre>';
}