<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return view('backend.user.index');
    }

    public function create()
    {
        return view('backend.user.create');
    }
    
    public function store(StoreUserRequest $request)
    {
        $profile_img_name = null;

        if($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid(). '_'. time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $profile_img_name, file_get_contents($profile_img_file));
        } else {
            $profile_img_name = 'user_profile.png';
        }

        DB::beginTransaction();
        
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->profile_img = $profile_img_name;
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
            
            return redirect()->route('user.index')->with('created', 'User created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something Wrong'])->withInput();
        }
    }
    
    public function edit(User $user)
    {
        return view('backend.user.edit', compact('user'));
    }

    public function update($id, UpdateUserRequest $request) 
    {
        $user = User::findOrFail($id);

        $profile_img_name = $user->profile_img;

        if($request->hasFile('profile_img')) {
            if($user->profile_img !== 'user_profile.png') {
                Storage::disk('public')->delete('images/'.$user->profile_img);
            }

            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid(). '_'. time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $user->update($request->only('name', 'email', 'phone')+ ['profile_img' => $profile_img_name]); 

        if($request->filled('password')) {
            $user->update($request->only('password'));
        }

        return redirect()->route('user.index')->with('updated', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return 'success';
    }

    public function serverSide()
    {
        $user = User::query();
        return datatables($user)
        ->editColumn('created_at', function($each) {
            return Carbon::parse($each->created_at)->toFormattedDateString() . ' - ' .
                Carbon::parse($each->created_at)->format('H:i:s A');
        })
        ->editColumn('user_agent', function($each) {
            if($each->user_agent) {
                $agent = new Agent();
                $agent->setUserAgent($each->user_agent);
    
                $device = $agent->device();
                $platform = $agent->platform();
                $browser = $agent->browser();
    
                return '<table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Device</td>
                            <td class="font-weight-bold">'.$device.'</td>
                        <tr>
                        <tr>
                            <td>Platform</td>
                            <td class="font-weight-bold">'.$platform.'</td>
                        <tr>
                        <tr>
                            <td>Browser</td>
                            <td class="font-weight-bold">'.$browser.'</td>
                        <tr>
                    </tbody>
                </table>';
            }

            return ' - ';
        })
        ->addColumn('plus-icon', function($each) {
            return null;
        })
        ->addColumn('profile', function($each) {
            return '<img src="'.$each->profile_img_path().'" class="thumbnail_img"/> <p>'.$each->name.'</p>';
        })
        ->editColumn('updated_at', function($each) {
            return Carbon::parse($each->updated_at)->diffForHumans() . ' - ' .
                Carbon::parse($each->updated_at)->toFormattedDateString() . ' - ' .
                Carbon::parse($each->updated_at)->format('H:i:s A');
        })
        ->addColumn('action', function($each) {
            $edit_icon = '<a href="'.route('user.edit', $each->id).'"><i class="fas fa-edit text-warning"></i></a>';
            $delete_icon = '<a href="#" class="delete_btn" data-id="'.$each->id.'"><i class="fas fa-trash text-danger"></i></a>';
            return '<div class="action_icon">'.$edit_icon. $delete_icon .'</div>';
        })
        ->rawColumns(['action', 'profile', 'user_agent'])
        ->toJson();
    }
}
