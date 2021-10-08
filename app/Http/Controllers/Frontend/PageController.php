<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Transaction;
use App\Helper\UUIDGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TransferFormRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\TransferCompleteRequest;
use App\Http\Requests\TransferAmountFormRequest;

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

    public function userUpdateInfo()
    {
        $auth_user = Auth::user();
        return view('frontend.userUpdateInfo', compact('auth_user'));
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

    public function transferForm()
    {
        $user = Auth::user();
        return view('frontend.transfer');
    }

    public function transferAmountForm(TransferFormRequest $request)
    {
        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account) {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် wavepay account မရှိသေးပါ'])->withInput();
        }

        if($to_account->phone === $from_account->phone)
        {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် မိမိဖုန်းနံပါတ် မဟုတ်ရပါ။'])->withInput();
        }

        return view('frontend.transferAmount', compact('from_account', 'to_account'));
    }

    public function transferConfirmForm(TransferAmountFormRequest $request)
    {
        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account) {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် wavepay account မရှိသေးပါ'])->withInput();
        }

        if($to_account->phone === $from_account->phone)
        {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် မိမိဖုန်းနံပါတ် မဟုတ်ရပါ။'])->withInput();
        }

        $amount = $request->amount;

        if($from_account->wallet->amount < $amount) {
            return back()->withErrors(['transfer' => 'ငွေလွှဲလိုသော ပမာဏမလုံလောက်ပါ။'])->withInput();
        }

        $remainingAmount =($from_account->wallet ? $from_account->wallet->amount : ' - ') - $amount;

        return view('frontend.transferConfirm', compact('from_account', 'to_account', 'amount', 'remainingAmount'));
    }

    public function passwordCheck(Request $request)
    {
        $password = $request->password;
        if(!$password) {
            return response()->json([
                'status' => 'fail',
                'message' => 'လျို့၀ှက်နံပါတ် ထည့်ပါ။'
            ]);
        }

        $user = Auth::user();
        if(!Hash::check($password, $user->password)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'လျို့၀ှက် နံပါတ်မှားယွင်းနေပါသည်။',
            ]);
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function transferComplete(TransferCompleteRequest $request)
    {
        $from_account = Auth::user();
        $to_account = User::where('phone', $request->to_phone)->first();

        if(!$to_account) {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် wavepay account မရှိသေးပါ'])->withInput();
        }

        if($to_account->phone === $from_account->phone)
        {
            return back()->withErrors(['transfer' => 'ငွေလက်ခံသော ဖုန်းနံပါတ်သည် မိမိဖုန်းနံပါတ် မဟုတ်ရပါ။'])->withInput();
        }

        $amount = $request->amount;

        if($from_account->wallet->amount < $amount) {
            return back()->withErrors(['transfer' => 'ငွေလွှဲလိုသော ပမာဏမလုံလောက်ပါ။'])->withInput();
        }

        DB::beginTransaction();

       try {
            $from_account->wallet->decrement('amount', $amount);
            $from_account->wallet->update();
            
            $to_account->wallet->increment('amount', $amount);
            $to_account->wallet->update();
            
           $ref_no = UUIDGenerate::refNumber();

            //From Account Transaction
            $from_account_transaction = new Transaction();
            $from_account_transaction->ref_no = $ref_no;
            $from_account_transaction->trx_id = UUIDGenerate::trxId();
            $from_account_transaction->user_id = $from_account->id;
            $from_account_transaction->source_id = $to_account->id;
            $from_account_transaction->trx_amount = $amount;
            $from_account_transaction->type = 'expense';
            $from_account_transaction->save();
            
            //To Account Transaction
            $to_account_transaction = new Transaction();
            $to_account_transaction->ref_no = $ref_no;
            $to_account_transaction->trx_id = UUIDGenerate::trxId();
            $to_account_transaction->user_id = $to_account->id;
            $to_account_transaction->source_id = $from_account->id;
            $to_account_transaction->trx_amount = $amount;
            $to_account_transaction->type = 'income';
            $to_account_transaction->save();

            DB::commit();

            return redirect()->route('user.transactionDetail', $from_account_transaction->trx_id)->with('success', 'အောင်မြင်ပါသည်။');
       } catch (\Exception $e) {
           DB::rollback();
           return back()->withErrors(['fails' => 'ပြန်လည်ကြိူးစားပါ။'])->withInput();
       }
    }

    public function transactionDetail($trx_id)
    {
        $user = Auth::user();
        $transaction = Transaction::with('user', 'source')->where('user_id', $user->id)->where('trx_id', $trx_id)->first();
        return view('frontend.transactionDetail', compact('transaction'));
    }
}
