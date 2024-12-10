<?php
spl_autoload_register(function ($class) {
    if(file_exists('./Application/' . $class . '.php')) {
        include './Application/'. $class . '.php';
    }
});