<?php

namespace App\Helpers;

use App\Models\PaymentTransactionLog;
use App\WhitelabelPaymentTransactionLog;

class PaymentTransactionLogger {

	public static function log($subscriber_name, $subscriber_email, $gateway, $amount, $payment_status, $txn_id,
		$subscription_type = '',  $order_id = '',$whitelabel=false)
	{
    	$log = PaymentTransactionLog::firstOrNew(['txn_id' => $txn_id]);

    	$log->subscriber_name = $subscriber_name;
    	$log->subscriber_email = $subscriber_email;
    	$log->payment_status = $payment_status;
    	$log->payment_gateway = $gateway;
    	$log->txn_id = $txn_id;
    	$log->order_id = $order_id;
    	$log->amount = $amount;
        $log->subscription_type = $subscription_type;
        $log->save();
	}

	public static function transactionExists($txn_id)
	{
		return PaymentTransactionLog::where('txn_id', $txn_id)->count() ? true : false;
	}
}
