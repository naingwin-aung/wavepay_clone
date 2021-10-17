<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Transaction;
use App\Helper\UUIDGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TopUpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TransferFormRequest;
use App\Notifications\GeneralNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Requests\ScanAndPayFormRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Notification;
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
            return back()->withErrors(['fail' => 'လျှို့၀ှက် နံပါတ် မှားယွင်းနေပါသည်။'])->withInput();
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
        if($request->filled('password')) {
            $user->password = $request->password;
        }
        $user->save();

        $title = 'လျို့၀ှက်နံပါတ် (သို့) ပုံ ပြောင်းလဲခြင်း';
        $message = 'လျို့၀ှက်နံပါတ် (သို့) ပုံအောင်မြင်စွာ ပြောင်းလဲပြီးပါပီ';
        $sourceable_id = $user->id;
        $sourceable_type = User::class;
        $web_link = url('user-info');

        Notification::send($user, new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link));

        return redirect()->route('user.info')->with('update_password', 'လျှို့ ဝှက်နံပါတ် (သို့) ပုံပြောင်းလဲပြီးပါပီ။');
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

            // From Noti
            $title = 'Money Transfered!';
            $message = 'ငွေလွှဲလိုက်သော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို လက်ခံသူ '. $to_account->name . ' ('. $to_account->phone .')' . ' သို့ပေးပို့ပြီးပါပြီ။';
            $sourceable_id = $from_account_transaction->id; 
            $sourceable_type = Transaction::class; 
            $web_link = url('/transaction/detail/' . $from_account_transaction->trx_id);
            $deep_link = [
                'target' => 'transaction_detail',
                'parameter' => [
                    'trx_id' => $from_account_transaction->trx_id,
                ]
            ];

            Notification::send([$from_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            // To Noti
            $title = 'Money Received!';
            $message = 'ငွေလက်ခံရရှိသော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို '. $from_account->name . ' ('. $from_account->phone .')' . ' ဆီမှရရှိပါသည်';
            $sourceable_id = $to_account_transaction->id; 
            $sourceable_type = Transaction::class; 
            $web_link = url('/transaction/detail/' . $to_account_transaction->trx_id);
            $deep_link = [
                'target' => 'transaction_detail',
                'parameter' => [
                    'trx_id' => $to_account_transaction->trx_id,
                ]
            ];
    
            Notification::send([$to_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            DB::commit();
            return redirect()->route('user.transactionDetail', $from_account_transaction->trx_id)->with('money_transfer', 'ငွေလွှဲလိုက်သော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို လက်ခံသူ '. $to_account->name . ' ('. $to_account->phone .')' . ' သို့ပေးပို့ပြီးပါပြီ။');
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

    public function transaction()
    {
        $user = Auth::user();
        $transactions = Transaction::with('user', 'source')->where('user_id', $user->id)->orderBy('created_at', 'DESC')->paginate('5');

        return view('frontend.transaction', compact('transactions'));
    }

    public function receiveQr()
    {
        $user = Auth::user();
        $phone = $user->phone;
        $qr_code = QrCode::size(170)->generate($user->phone);
        return view('frontend.receive-qr', compact('user', 'qr_code'));
    }

    public function topUp()
    {
        $user = Auth::user();
        $phone = $user->phone;
        $ooredoo = "/^(09|\+?959)9(5|7|6)\d{7}$/";
        $telenor = "/^(09|\+?959)7([5-9])\d{7}$/";
        $mytel = "/^(09|\+?959)6(8|9)\d{7}$/";
        $mpt = "/^(09|\+?959)(5\d{6}|4\d{7,8}|2\d{6,8}|3\d{7,8}|6\d{6}|8\d{6}|7\d{7}|9(0|1|9)\d{5,6}|2[0-4]\d{5}|5[0-6]\d{5}|8[13-7]\d{5}|3[0-369]\d{6}|34\d{7}|4[1379]\d{6}|73\d{6}|91\d{6}|25\d{7}|26[0-5]\d{6}|40[0-4]\d{6}|42\d{7}|45\d{7}|89[6789]\d{6}|)$/";
        $userPhoneName = '';

        if(preg_match($ooredoo, $phone)) {
            $userPhoneName = 'ooredoo';
        }

        if(preg_match($telenor, $phone)) {
            $userPhoneName = 'telenor';
        }

        if(preg_match($mytel, $phone)) {
            $userPhoneName = 'mytel';
        }

        if(preg_match($mpt, $phone)) {
            $userPhoneName = 'mpt';
        }

        return view('frontend.topUp', compact('user', 'userPhoneName'));        
    }

    public function topUpConfirm(TopUpRequest $request)
    {
        $user = Auth::user();
        $another_topup_amount = $request->another_topup_amount;

        $phone = $user->phone;
        $ooredoo = "/^(09|\+?959)9(5|7|6)\d{7}$/";
        $telenor = "/^(09|\+?959)7([5-9])\d{7}$/";
        $mytel = "/^(09|\+?959)6(8|9)\d{7}$/";
        $mpt = "/^(09|\+?959)(5\d{6}|4\d{7,8}|2\d{6,8}|3\d{7,8}|6\d{6}|8\d{6}|7\d{7}|9(0|1|9)\d{5,6}|2[0-4]\d{5}|5[0-6]\d{5}|8[13-7]\d{5}|3[0-369]\d{6}|34\d{7}|4[1379]\d{6}|73\d{6}|91\d{6}|25\d{7}|26[0-5]\d{6}|40[0-4]\d{6}|42\d{7}|45\d{7}|89[6789]\d{6}|)$/";
        $userPhoneName = '';

        if(preg_match($ooredoo, $phone)) {
            $userPhoneName = 'ooredoo';
        }

        if(preg_match($telenor, $phone)) {
            $userPhoneName = 'telenor';
        }

        if(preg_match($mytel, $phone)) {
            $userPhoneName = 'mytel';
        }

        if(preg_match($mpt, $phone)) {
            $userPhoneName = 'mpt';
        }

        if($userPhoneName !== $request->userPhoneName) {
            return back()->withErrors(['fails' => 'တစ်ခုခု မှားယွင်းနေပါသည်။'])->withInput();
        }

        if(!$another_topup_amount) {
            if(!$request->topup_amount) {
                return back()->withErrors(['fails' => 'ပမာဏ ထည့်ရန်လိုအပ်သည်။'])->withInput();
            }
        }

        if($another_topup_amount) {
            $fillBill = $another_topup_amount % 1000;
            if($fillBill !== 0 || $another_topup_amount > 30000) {
                return back()->withErrors(['fails' => 'ပမာဏသည် ၁၀၀၀ နှင့်စား၍ပြတ်ပြီး အများဆုံး ၃၀၀၀၀ ဖြစ်ရမည်၊'])->withInput();
            }
        }

        if($user->wallet->amount < $request->topup_amount || $user->wallet->amount < $another_topup_amount) {
            return back()->withErrors(['fails' => 'ပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        $bill_amount = $another_topup_amount ?? $request->topup_amount;

        $remainingAmount = $user->wallet->amount - $bill_amount;

        return view('frontend.topUpCompleteForm', compact('user', 'bill_amount', 'remainingAmount', 'userPhoneName'));
    }

    public function topUpComplete(Request $request)
    {
        $user = Auth::user();
        $phone = $user->phone;
        $ooredoo = "/^(09|\+?959)9(5|7|6)\d{7}$/";
        $telenor = "/^(09|\+?959)7([5-9])\d{7}$/";
        $mytel = "/^(09|\+?959)6(8|9)\d{7}$/";
        $mpt = "/^(09|\+?959)(5\d{6}|4\d{7,8}|2\d{6,8}|3\d{7,8}|6\d{6}|8\d{6}|7\d{7}|9(0|1|9)\d{5,6}|2[0-4]\d{5}|5[0-6]\d{5}|8[13-7]\d{5}|3[0-369]\d{6}|34\d{7}|4[1379]\d{6}|73\d{6}|91\d{6}|25\d{7}|26[0-5]\d{6}|40[0-4]\d{6}|42\d{7}|45\d{7}|89[6789]\d{6}|)$/";
        $userPhoneName = '';

        if(preg_match($ooredoo, $phone)) {
            $userPhoneName = 'ooredoo';
        }

        if(preg_match($telenor, $phone)) {
            $userPhoneName = 'telenor';
        }

        if(preg_match($mytel, $phone)) {
            $userPhoneName = 'mytel';
        }

        if(preg_match($mpt, $phone)) {
            $userPhoneName = 'mpt';
        }

        $bill_amount = $request->bill_amount;

        if(!$bill_amount) {
            return back()->withErrors(['fails' => 'ပမာဏ ထည့်ရန်လိုအပ်သည်။'])->withInput();
        }

        if($user->wallet->amount < $bill_amount) {
            return back()->withErrors(['fails' => 'ပမာဏ မလုံလောက်ပါ။'])->withInput();
        }

        if($bill_amount > 500) {
            $fillBill = $bill_amount % 1000;
            if($fillBill !== 0 || $bill_amount > 30000) {
                return back()->withErrors(['fails' => 'ပမာဏသည် ၁၀၀၀ နှင့်စား၍ပြတ်ပြီး အများဆုံး ၃၀၀၀၀ ဖြစ်ရမည်၊'])->withInput();
            }
        }

        DB::beginTransaction();

        try {
            $user->wallet->decrement('amount', $bill_amount);
            $user->wallet->update();

            $transaction_bill = new Transaction();
            $transaction_bill->trx_id = UUIDGenerate::trxId();
            $transaction_bill->user_id = $user->id;
            $transaction_bill->trx_amount = $bill_amount;
            $transaction_bill->type = 'expense';
            $transaction_bill->save();
            
            DB::commit();
            return redirect()->route('user.topUpDetail', $transaction_bill->trx_id)->with('fill_bill', 'ဖုန်းဘေလ် '. number_format($bill_amount) .' ကျပ် ဖြည့်ပြီးပါပြီ။');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['fails' => 'တစ်ခုခု မှားယွင်းနေပါသည်။'])->withInput();
        }
    }

    public function topUpDetail($trx_id)
    {
        $user = Auth::user();
        $transaction = Transaction::with('user')->where('user_id', $user->id)->where('trx_id', $trx_id)->first();
        return view('frontend.topUpDetail', compact('transaction'));
    }

    public function scanAndPay()
    {
        return view('frontend.scanPay');
    }

    public function scanAndPayForm(Request $request)
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

        return view('frontend.scanAndPayForm', compact('from_account', 'to_account'));
    }

    public function scanAndPayConfirmForm(ScanAndPayFormRequest $request)
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

        return view('frontend.scanAndPayConfirmForm', compact('from_account', 'to_account', 'amount', 'remainingAmount'));
    }

    public function scanAndPayComplete(ScanAndPayFormRequest $request)
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

            // From Noti
            $title = 'Money Transfered!';
            $message = 'ငွေလွှဲလိုက်သော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို လက်ခံသူ '. $to_account->name . ' ('. $to_account->phone .')' . ' သို့ပေးပို့ပြီးပါပြီ။';
            $sourceable_id = $from_account_transaction->id; 
            $sourceable_type = Transaction::class; 
            $web_link = url('/transaction/detail/' . $from_account_transaction->trx_id);
            $deep_link = [
                'target' => 'transaction_detail',
                'parameter' => [
                    'trx_id' => $from_account_transaction->trx_id,
                ]
            ];

            Notification::send([$from_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            // To Noti
            $title = 'Money Received!';
            $message = 'ငွေလက်ခံရရှိသော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို '. $from_account->name . ' ('. $from_account->phone .')' . ' ဆီမှရရှိပါသည်';
            $sourceable_id = $to_account_transaction->id; 
            $sourceable_type = Transaction::class; 
            $web_link = url('/transaction/detail/' . $to_account_transaction->trx_id);
            $deep_link = [
                'target' => 'transaction_detail',
                'parameter' => [
                    'trx_id' => $to_account_transaction->trx_id,
                ]
            ];
    
            Notification::send([$to_account], new GeneralNotification($title, $message, $sourceable_id, $sourceable_type, $web_link, $deep_link));

            DB::commit();

            return redirect()->route('user.transactionDetail', $from_account_transaction->trx_id)->with('money_transfer', 'ငွေလွှဲလိုက်သော ပမာဏ ' . number_format($amount) . ' ကျပ်ကို လက်ခံသူ '. $to_account->name . ' ('. $to_account->phone .')' . ' သို့ပေးပို့ပြီးပါပြီ။');
       } catch (\Exception $e) {
           DB::rollback();
           return back()->withErrors(['fails' => 'ပြန်လည်ကြိူးစားပါ။'])->withInput();
       }
    }
}
