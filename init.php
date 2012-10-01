<?php

namespace CWX\Crust;

define('_CWX_DP_ROOT', realpath(dirname(__FILE__)));
define('_CWX_LIB', realpath(sprintf('%s/lib', _CWX_DP_ROOT)));

spl_autoload_register(function($className) {
    require sprintf('%s.php', str_replace('\\', '/',
        str_replace(__NAMESPACE__, _CWX_LIB, $className)
    ));
});

