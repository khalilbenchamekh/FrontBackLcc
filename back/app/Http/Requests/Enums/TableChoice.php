<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 20/04/2020
 * Time: 15:04
 */

namespace App\Http\Requests\Enums;


use ReflectionClass;

class TableChoice
{
    const Business = 'affaires';
    const FolderTech = 'folderteches';
    const Sites = 'sites';
    const Great = 'g_c_s';
    const All = 'all';
    const Load = 'loads';

    public function getConstants()
    {
        try {
            $reflectionClass = new ReflectionClass($this);
            return $reflectionClass->getConstants();

        } catch (\ReflectionException $e) {
            return [];
        }
    }
}
