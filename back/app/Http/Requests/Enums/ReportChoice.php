<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 14/06/2020
 * Time: 13:04
 */

namespace App\Http\Requests\Enums;


use ReflectionClass;

class ReportChoice
{


    const FinancialReport = 'financier';
    const TvaReport = 'tva';
    const TurnoverReport = 'ca';

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
