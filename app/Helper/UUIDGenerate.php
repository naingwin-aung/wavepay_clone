<?php
namespace App\Helper;

use App\Models\Transaction;

class UUIDGenerate 
{
    public static function refNumber()
    {
        $number = mt_rand(1000000000000000, 9999999999999999);

        if(Transaction::where('ref_no', $number)->exists()) {
            return self::refNumber();
        }

        return $number;
    }

    public static function trxId()
    {
       $number = mt_rand(1000000000000000, 9999999999999999);

       if(Transaction::where('trx_id', $number)->exists()) {
           return self::trxId();
       }

       return $number;
    }
}