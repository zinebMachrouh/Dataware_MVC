<?php

require 'config/config.php';
//Libraries

// require 'libraries/Controller.php';
// require 'libraries/Core.php';
// require 'libraries/Database.php';

spl_autoload_register(function ($className) {
    require 'libraries/' . $className . '.php';
});

