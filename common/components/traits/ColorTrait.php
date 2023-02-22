<?php

namespace common\components\traits;

trait ColorTrait
{
    public static $colors = ['Красный', 'Зеленый', 'Желтый'];


    public static function getRandomColor(): string
    {
        return self::$colors[rand(0, sizeof(self::$colors) - 1)];
    }

}