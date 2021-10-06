<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatePasswordRequest;

class PageController extends Controller
{
    public function home()
    {
        $auth_user = Auth::user();
        return view('frontend.home', compact('auth_user'));
    }

    public function userInfo()
    {
        $auth_user = Auth::user();
        return view('frontend.user_info', compact('auth_user'));
    }

    public function updatePasswordForm()
    {
        $auth_user = Auth::user();
        return view('frontend.user_edit', compact('auth_user'));
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();

        if(!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['fail' => 'Your password is wrong'])->withInput();
        }

        $profile_img_name = $user->profile_img;

        if($request->hasFile('profile_img')) {
            if($user->profile_img !== 'user_profile.png') {
                Storage::disk('public')->delete('images/'.$user->profile_img);
            }

            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid(). '_'. time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $user->profile_img = $profile_img_name;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('user.info')->with('update_password', 'လျှို့ ဝှက်နံပါတ် ပြောင်းလဲပြီးပါပီ။');
    }
}
