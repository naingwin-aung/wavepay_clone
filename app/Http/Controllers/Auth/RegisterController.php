<?php

namespace App\Http\Controllers\Auth;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(RegisterUserRequest $request)
    {
        DB::beginTransaction();
        
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->profile_img = 'user_profile.png';
            $user->ip = $request->ip();
            $user->user_agent = $request->server('HTTP_USER_AGENT');
            $user->login_at = Carbon::now();
            $user->save();

            Wallet::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'amount' => 0,
                ]
            );

            DB::commit();
            
            $this->guard()->login($user);

            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something Wrong'])->withInput();
        }
       

    }
}
