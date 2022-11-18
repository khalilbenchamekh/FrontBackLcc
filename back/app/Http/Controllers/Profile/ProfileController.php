<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Resource\ProfileResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePassword;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Get Login User
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = Auth::user();
        $expiresAt = Carbon::now()->addDays(30);
        $value = Cache::remember('avatar' . $user['original_filename'] . $user['email'], $expiresAt, function () use ($user) {
            return $this->fetch_image($user['original_filename']);
        });
        return $value;
    }


    /**
     * Update Profile
     *
     *
     * @param UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        // Get data of Logged user
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'firstname' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'email' => 'email',
            'name' => ['string', 'max:255'],
            'gender' => ['nullable', 'in:female,male'],
            'birthdate' =>
                'nullable', 'date:Y-m-d', 'before:' . now()->subYears(10)->format('Y-m-d'),
            'address' => ['nullable', 'string', 'max:510'],
            'username' => ['unique:users', 'string', 'max:255'],
            'avatar.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request->hasfile('avatar')) {
            $img =
                $this->store_image($request->file('avatar'), $user->original_filename);
                $user->original_filename = $img;
        } else {
            if (!empty($request->input('avatar'))) {
                $src = $request->input('avatar');
                $imageName = $this->store_image_if_is_it_base64($src, $user->original_filename);
                if ($imageName != null) {
                    $user->original_filename = $imageName;
                }
            }
        }
        $user->update($request->only('email', 'name',
            'username',
            'firstname',
            'middlename',
            'lastname',
            'birthdate',
            'address'
        ));

        // transform user data
        $data = new ProfileResource($user);

        return response()->json(compact('data'));

    }

    private function store_image_if_is_it_base64($base64, $prevFile)
    {
        try {
            $this->createPathIfNotExisted();
            $this->deleteFile($prevFile);
            $image_parts = explode(";base64,", $base64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = md5(time()) . '.' . $image_type;
            $path = public_path() . '/geoMapping/Profile/';
            File::put($path . $imageName, $image_base64);
            return $imageName;
        } catch (\Exception $e) {
            return null;
        }


    }

    private function deleteFile($file)
    {
        if ($file != null) {
            $path = public_path('/geoMapping/Profile/' . $file);
            if (File::exists($path)) {
                File::delete($path);
            }

        } else {
            return null;
        }

    }

    private function createPathIfNotExisted()
    {
        $filesArray = [
            'geoMapping',
            'geoMapping/Profile',
        ];
        foreach ($filesArray as $item) {
            $path = public_path() . '/' . $item . '/';
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
        }
    }

    private function store_image($file, $prevFile)
    {
        $this->createPathIfNotExisted();
        $this->deleteFile($prevFile);
        if ($file != null) {

            $filenameWithExt = $file->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = md5($filename . time()) . '.' . $extension;
            $path = public_path() . '/geoMapping/Profile/';
            $file->move($path, $fileNameToStore);
            return $fileNameToStore;


        } else {
            return null;
        }
    }


    private function fetch_image($image_id)
    {

        if ($image_id != null) {
            $path = public_path('/geoMapping/Profile/' . $image_id);
            if (!File::exists($path)) {
                abort(404);
            }
            $type = File::mimeType($path);
            $extension = File::extension($path);
            if ($extension != null) {
                $image_file = Image::make($path);
                $response = Response::make($image_file->encode($extension));
                $response->header('Content-Type', $type);
                return $response;
            }
        } else {
            return null;
        }
    }

    /**
     * Update Profile
     *
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        // Get Request User
        $user = $request->user();

        // Validate user Password and Request password
        if (!Hash::check($request->current_password, $user->password)) {
            // Validation failed return an error messsage
            return response()->json(['error' => 'Invalid current password'], 422);

        }

        // Update User password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));
    }
}
