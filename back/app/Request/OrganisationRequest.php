<?php

namespace App\Request;

class OrganisationRequest
{
    public static string $name;
    public static string $emailOrganisation;
    public static string $description;
    public static  $owner;
    public static  $cto ;
    public static  $link1;
    public static  $link3;
    public static  $link2;
    public static  $link4;
    public static  $activer;
    public static  $desactiver;
    public static  $blocked;


    public static function newRequest($request):array
    {
        self::$name=$request['name'];
        self::$emailOrganisation=$request['emailOrganisation'];
        self::$description=$request['description'];
//        self::$nameCto=$request['nameCto'];
//        self::$passwordCto=$request['passwordCto'];
//        self::$emailCto=$request['emailCto'];
        self::$owner=isset($request['owner'])?$request['owner']:null;
        self::$cto=isset($request['cto'])?$request['cto']:null;
        self::$link1=isset($request['link1'])?$request['link1']:null;
        self::$link2=isset($request['link2'])?$request['link2']:null;
        self::$link3=isset($request['link3'])?$request['link3']:null;
        self::$link4=isset($request['link4'])?$request['link4']:null;
        self::$activer=isset($request['activer'])?$request['activer']:null;
        self::$blocked=isset($request['blocked'])?$request['blocked']:null;
        self::$desactiver=isset($request['desactiver'])?$request['desactiver']:null;
        return [
            'name'=>self::$name,
            'emailOrganisation'=>self::$emailOrganisation,
            'description'=>self::$description,
            'owner'=>self::$owner,
            'cto'=>self::$cto,
            'link1'=>self::$link1,
            'link2'=>self::$link2,
            'link3'=>self::$link3,
            'link4'=>self::$link4,
            'activer'=>self::$activer,
            'desactiver'=>self::$desactiver,
            'blocked'=>self::$blocked,
        ];
    }
}
