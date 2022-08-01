<?php
declare(strict_types=1);
namespace App\Request;


class AdminRequest
{


public function req($request)
{
    return [
      "name"=>$request['name'],
      "email"=>$request['email'],
      "password"=>isset($request['password'])? $request['password']:null,
      "username"=>isset($request['username'])? $request['username']:null,
      "last_signin"=>isset($request['last_signin'])? $request['last_signin']:null,
      "firstname"=>isset($request['firstname'])? $request['firstname']:null,
      "middlename"=>isset($request['middlename'])? $request['middlename']:null,
      "gender"=>isset($request['gender'])? $request['gender']:null,
      "birthdate"=>isset($request['birthdate'])? $request['birthdate']:null,
      "address"=>isset($request['address'])? $request['address']:null,
      "directory"=>isset($request['directory'])? $request['directory']:null,
      "filename"=>isset($request['filename'])? $request['filename']:null,
      "original_filename"=>isset($request['original_filename'])? $request['original_filename']:null,
      "filesize"=>isset($request['filesize'])? $request['filesize']:null,
      "thumbnail_filesize"=>isset($request['thumbnail_filesize'])? $request['thumbnail_filesize']:null,
      "url"=>isset($request['url'])? $request['url']:null,
      "membership_id"=>isset($request['membership_id'])? $request['membership_id']:null,
      "membership_type"=>isset($request['membership_type'])? $request['membership_type']:null,
      "thumbnail_url"=>isset($request['thumbnail_url'])? $request['thumbnail_url']:null,
      "organisation_id"=>isset($request['organisation_id'])? $request['organisation_id']:null,
    ];
}


}
