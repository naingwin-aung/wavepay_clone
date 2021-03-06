<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('backend.admin.index');
    }

    public function create()
    {
        return view('backend.admin.create');
    }
    
    public function store(StoreAdminRequest $request)
    {
        $profile_img_name = null;

        if($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid(). '_'. time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        Admin::create($request->only('name', 'email', 'phone', 'password')+ ['profile_img' => $profile_img_name]);

        return redirect()->route('admin.index')->with('created', 'Admin User created successfully');
    }
    
    public function edit(Admin $admin)
    {
        return view('backend.admin.edit', compact('admin'));
    }

    public function update($id, UpdateAdminRequest $request) 
    {
        $admin = Admin::findOrFail($id);

        $profile_img_name = $admin->profile_img;

        if($request->hasFile('profile_img')) {
            Storage::disk('public')->delete('images/'.$admin->profile_img);

            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid(). '_'. time() . '.' . $profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('images/' . $profile_img_name, file_get_contents($profile_img_file));
        }

        $admin->update($request->only('name', 'email', 'phone')+ ['profile_img' => $profile_img_name]); 

        if($request->filled('password')) {
            $admin->update($request->only('password'));
        }

        return redirect()->route('admin.index')->with('updated', 'Admin User updated successfully');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return 'success';
    }

    public function serverSide()
    {
        $admin = Admin::query();
        return datatables($admin)
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
            $edit_icon = '<a href="'.route('admin.edit', $each->id).'"><i class="fas fa-edit text-warning"></i></a>';
            
            if($each->id !== Auth::guard('admin')->user()->id) {
                $delete_icon = '<a href="#" class="delete_btn" data-id="'.$each->id.'"><i class="fas fa-trash text-danger"></i></a>';
                return '<div class="action_icon">'.$edit_icon. $delete_icon .'</div>';
            }

            return '<div class="action_icon">'.$edit_icon.'</div>';
        })
        ->rawColumns(['action', 'profile', 'user_agent'])
        ->toJson();
    }
}
