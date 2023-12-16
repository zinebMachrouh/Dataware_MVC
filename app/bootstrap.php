<?php

require 'config/config.php';

spl_autoload_register(function ($className) {
    require 'libraries/' . $className . '.php';
});

