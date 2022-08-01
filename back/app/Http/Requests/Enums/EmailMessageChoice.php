<?php

namespace App\Http\Requests\Enums;

use ReflectionClass;
class EmailMessageChoice
{
    const CREATE_ORGANISATION="CREATE_ORGANISATION";
    const EDITE_ORGANISATION="EDITE_ORGANISATION";
    const DELETE_ORGANISATION="DELETE_ORGANISATION";
    const ENABLE_ORGANISATION="ENABLE_ORGANISATION";
    const DISABLE_ORGANISATION="DISABLE_ORGANISATION";
    const BLOCK_ORGANISATION="BLOCK_ORGANISATION";
    const CREATE_USER="CREATE_USER";
    const EDIT_USER="EDIT_USER";
    const DELETE_USER="DELETE_USER";
    const BLOCK_USER="BLOCK_USER";
    const ENABLE_USER="ENABLE_USER";
    const DISABLE_USER="DISABLE_USER";
    const GENERATE_PASSWORD_TO_USER="GENERATE_PASSWORD_TO_USER";

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
