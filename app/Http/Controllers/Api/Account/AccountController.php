<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\DetailsRequest;
use App\Http\Requests\Account\PasswordRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('demo');
    }

    public function update(DetailsRequest $request): JsonResponse
    {
        $request->validated();
        /** @var User $user */
        $user = Auth::user();
        $user->name = $request->get('name');
        if ($user->email !== $request->get('email')) {
            $user->email = $request->get('email');
            $user->email_verified_at = null;
        }
        if ($request->file('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatar', 'public');
        } elseif ($request->get('gravatar') === 'true') {
            $user->avatar = null;
        }
        if ($user->save()) {
            return response()->json(new UserResource($user));
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }

    public function password(PasswordRequest $request): JsonResponse
    {
        $request->validated();
        /** @var User $user */
        $user = Auth::user();
        if (!(Hash::check($request->get('current_password'), $user->password))) {
            return response()->json(['message' => __('The password entered does not match the current password')], 406);
        }
        if (strcmp($request->get('current_password'), $request->get('password')) === 0) {
            return response()->json(['message' => __('The new password can not be the same as the previous one')], 406);
        }
        $user->password = bcrypt($request->get('password'));
        if ($user->save()) {
            return response()->json(['message' => __('Password changed successfully')]);
        }
        return response()->json(['message' => __('An error occurred while saving data')], 500);
    }
}
