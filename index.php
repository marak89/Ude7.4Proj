<?php

function dump($data)
{
    echo PHP_EOL;
    echo "<div style='
        display: inline-block;
        padding: 0 10px;
        border: 1px solid gray;
        background-color: lightgray;
        '><pre>";
    print_r(['aaa','bbb','ccc']);
    echo "</pre></div>";
    echo PHP_EOL;
}

dump(['aaa','bbb','ccc']);