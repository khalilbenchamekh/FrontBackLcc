<?php


namespace App\Service\Profile;

use App\Services\SaveFile\ISaveFileService;
use App\Services\User\IUserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;



class ProfileService implements IProfileService
{
    public $user;
    public $iSaveFileService;
    public $iUserService;
    public function __construct(ISaveFileService $iSaveFileService,IUserService $iUserService)
    {
        $this->iUserService=$iUserService;
        $this->iSaveFileService=$iSaveFileService;
        $this->user=Auth::user();
    }

    public function me()
    {
        $user= $this->user;
        $expiresAt = Carbon::now()->addDays(30);
        return Cache::remember('avatar' . $user['original_filename'] . $user['email'], $expiresAt, function () use ($user) {
            return $this->iSaveFileService->fetchImage('profile',$user['original_filename']);;
        });
    }

    public function update($request)
    {
        $user = $this->user;
        if ($request->hasfile('avatar')) {
            $img = $this->iSaveFileService->store_image('profile',$request->file('avatar'), $user->original_filename);
                $user->original_filename = $img;
        } else {
            if (!empty($request->input('avatar'))) {
                $src = $request->input('avatar');
                $imageName = $this->iSaveFileService->store_image_if_is_it_base64('profile',$src, $user->original_filename);
                if ($imageName != null) {
                    $user->original_filename = $imageName;
                }
            }
        }
        return $this->iUserService->update($user);
    }

    public function updatePassword($request)
    {
        return $this->iUserService->update($request->user());
    }

}
