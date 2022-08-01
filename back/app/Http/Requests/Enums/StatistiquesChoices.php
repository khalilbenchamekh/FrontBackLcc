<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 13/06/2020
 * Time: 12:20
 */

namespace App\Http\Requests\Enums;


use ReflectionClass;

class StatistiquesChoices
{
    const Global = 'global';
    const Employee = 'employee';
    const Client = 'client';

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
