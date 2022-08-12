<?php

declare(strict_types=1);

function myArrowFunc(int $times): string
{
    $toLeft = str_repeat('<', $times);
    $toRight = str_repeat('>', $times);

    return $toLeft . $toRight;
}

echo myArrowFunc(9);