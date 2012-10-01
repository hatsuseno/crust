<?php

namespace CWX\Crust;

define('_CWX_DP_ROOT', realpath(dirname(__FILE__)));
define('_CWX_LIB', realpath(sprintf('%s/lib', _CWX_DP_ROOT)));

// Barebones autoloader, just chop off the end that looks like the local
// namespace, replace with the computed path for the lib, and invert
// all remaining backslashes to slashes
spl_autoload_register(function($className) {
    require sprintf('%s.php', str_replace('\\', '/',
        str_replace(__NAMESPACE__, _CWX_LIB, $className)
    ));
});

