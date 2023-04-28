<?php

function dd(...$whatever)
{
    foreach ($whatever as $thing)
        var_dump($thing);
    die();
}
