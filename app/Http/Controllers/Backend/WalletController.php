<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use App\Helper\UUIDGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddAmountRequest;

class WalletController extends Controller
{
    public function index()
    {
        return view('backend.wallet.index');
    }

    public function serverSide()
    {
        $wallet = Wallet::with('user');
        return datatables($wallet)
        ->filterColumn('account_person', function($query, $keyword) {
            $query->whereHas('user', function($q1) use($keyword) {
                $q1->where('name', 'like', '%'.$keyword.'%');
            });
        })
        ->filterColumn('account_person', function($query, $keyword) {
            $query->whereHas('user', function($q1) use($keyword) {
                $q1->where('email', 'like', '%'.$keyword.'%');
            });
        })

        ->filterColumn('account_person', function($query, $keyword) {
            $query->whereHas('user', function($q1) use($keyword) {
                $q1->where('phone', 'like', '%'.$keyword.'%');
            });
        })
        ->addColumn('plus-icon', function($each) {
            return null;
        })
        ->addColumn('account_person', function($each) {
            $user = $each->user;
            if($user) {
                return '
                    <p>Name: ' . $user->name .'</p>
                    <p>Email: ' . $user->email .'</p>
                    <p>Phone: ' . $user->phone .'</p>
                ';
            }

            return ' - ';
        })
        ->editColumn('amount', function($each) {
            return number_format($each->amount, 2) . ' ကျပ်';
        })
        ->editColumn('created_at', function($each) {
            return Carbon::parse($each->created_at)->toFormattedDateString() . ' - ' .
                Carbon::parse($each->created_at)->format('H:i:s A');
        })
        ->editColumn('updated_at', function($each) {
            return Carbon::parse($each->updated_at)->diffForHumans() . ' - ' .
            Carbon::parse($each->updated_at)->toFormattedDateString() . ' - ' .
            Carbon::parse($each->updated_at)->format('H:i:s A');
        })
        ->rawColumns(['account_person'])
        ->toJson();
    }

    public function addAmountForm() {
        $users = User::orderBy('name')->get();
        return view('backend.wallet.addAmount', compact('users'));
    }

    public function addAmount(AddAmountRequest $request) {
        DB::beginTransaction();

        try {
            $user = User::with('wallet')->where('id', $request->user_id)->firstOrFail();
            $amount = $request->amount;
            $user->wallet->increment('amount', $amount);
            $user->wallet->update();

            $ref_no = UUIDGenerate::refNumber();
            $user_account_transaction = new Transaction();
            $user_account_transaction->ref_no = $ref_no;
            $user_account_transaction->trx_id = UUIDGenerate::trxId();
            $user_account_transaction->user_id = $user->id;
            $user_account_transaction->type = 'income';
            $user_account_transaction->trx_amount = $amount;
            $user_account_transaction->source_id = 0;
            $user_account_transaction->save();

            DB::commit();
            return redirect()->route('wallet.index')->with('created', 'Successfully added amount.');
         } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fail' => 'Something Wrong'])->withInput();
        }
    }
}
