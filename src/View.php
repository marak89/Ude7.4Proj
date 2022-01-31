<?php

declare(strict_types=1);

namespace App;

class View
{
    function render(?string $page, array $params) :void
    {
        dump($params);
        include_once ("templates/layout.php");

    }
}