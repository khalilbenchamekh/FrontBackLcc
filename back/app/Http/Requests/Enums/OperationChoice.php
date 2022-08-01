<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 24/02/2020
 * Time: 14:17
 */

namespace App\Http\Requests\Enums;


abstract  class OperationChoice
{

    const SAVE = 'store';
    const MULTIPLE = 'multiple';
    const UPDATE = 'update';
}
