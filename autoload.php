<?php


spl_autoload_register('my_psr4_autoloader');


function my_psr4_autoloader($class)
{
    $cleanClass = str_replace('ConstructionStages\\', '', $class);

    $class_path = str_replace('\\', '/', $cleanClass);

    $file = __DIR__ . '/src/' . $class_path . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
}
