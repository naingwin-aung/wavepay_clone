<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('backend.admin.index');
    }

    public function userIndex()
    {
        return view('backend.user.index');
    }

    public function serverSide()
    {
        $admin = Admin::query();
        return datatables($admin)
        ->editColumn('created_at', function($each) {
            return Carbon::parse($each->created_at)->diffForHumans() . ' - ' .
                Carbon::parse($each->created_at)->toFormattedDateString() . ' - ' .
                Carbon::parse($each->created_at)->format('H:i:s A');
        })
        ->editColumn('updated_at', function($each) {
            return Carbon::parse($each->updated_at)->diffForHumans() . ' - ' .
                Carbon::parse($each->updated_at)->toFormattedDateString() . ' - ' .
                Carbon::parse($each->updated_at)->format('H:i:s A');
        })
        ->toJson();
    }
}
