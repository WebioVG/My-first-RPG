<?php

    include 'config/helpers.php';

    spl_autoload_register(function ($class) {
        include 'classes/'.$class.'.php';
    });

?>