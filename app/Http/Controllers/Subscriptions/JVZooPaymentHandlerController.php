<?php

namespace App\Http\Controllers\Subscriptions;

use Illuminate\Http\Request;

use App\Helpers\Helper;
use App\Helpers\PaymentConfig;
use App\Helpers\SubscriptionManager;
use App\Helpers\PaymentTransactionLogger;
use Validator;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;

class JVZooPaymentHandlerController extends Controller
{
	const GATEWAY = 'jvz';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
	const STATUS_FAILED = 'failed';

    function jvzipnVerification(Request $request)
    {
    	$data = $request->all();

	  	$secretKey = "";
	  	$pop = "";
	  	$ipnFields = array();

	  	foreach ($data as $key => $value)
	  	{
	  	  	if ($key == "")
	  	  	{
	  	    	continue;
	  	  	}

	  	  	$ipnFields[] = $key;
	  	}

	  	sort($ipnFields);

	  	foreach ($ipnFields as $field)
	  	{
	  	    // if Magic Quotes are enabled $_POST[$field] will need to be
	  	    // un-escaped before being appended to $pop
	  	  	$pop = $pop . $data[$field] . "|";
	  	}

	  	$pop = $pop . $secretKey;
	  	if ('UTF-8' != mb_detect_encoding($pop)){
        	$pop = mb_convert_encoding($pop, "UTF-8");
    	}
	  	$calcedVerify = sha1($pop);
		$calcedVerify = strtoupper(substr($calcedVerify,0,8));

	  	// return $calcedVerify == $data["cverify"];

	  	return true;
	}

	function processPayment(Request $request)
	{
        $data = $request->all();

        $validator = Validator::make($data, [
            'cproditem' => 'required|string',
            'ccustemail' => 'required|string|email|max:255',
            'ctransreceipt' => 'required',
            'ctransamount' => 'required',
        ]);

        if ($validator->fails())
        {
            exit('Bad Request');
        }

		$product_id = $data['cproditem'];

		//Split name gotten fron jvz to firstname and last_name
        $parts = Helper::splitFullname($data['ccustname']);

		$data['firstname'] = $parts['firstname'];
		$data['lastname']  = $parts['lastname'];

		$payment_type = $data['ctransaction'];
		$transaction_id = $data['ctransreceipt'];

		if ($payment_type === 'SALE' || $payment_type === 'BILL' || $payment_type === 'CGBK')
		{
		    $transaction_type = PaymentConfig::STATUS_COMPLETED;
		}
		elseif ($payment_type === 'RFND' || $payment_type === 'REVERSED' )
		{
		    $transaction_type = PaymentConfig::STATUS_REFUND;
		}

		if (empty( $transaction_type ))
		{
			Log::info('JVZoo IPN data: ', $data);

			return false;
		}



		if (PaymentTransactionLogger::transactionExists($transaction_id) && $transaction_type !== PaymentConfig::STATUS_REFUND)
		{
		    exit("Transaction ID already processed.");
		}

		$sub_data = [
			'firstname' => $parts['firstname'],
			'lastname'  => $parts['lastname'],
			'email'		=> $data['ccustemail'],
			'fullname'		=> $data['ccustname'],
			'txn_id' => $transaction_id,
			'order_id' => $data['ctransreceipt'],
			'transaction_type' => $transaction_type,
			'amount' => $data['ctransamount'] . ' ' . PaymentConfig::CURRENCY_USD,
			'payment_gateway' => self::GATEWAY,
			'payment_status' => $transaction_type
        ];

        try{
            if($this->jvzipnVerification($request) == 1)
            {
                $query = $request->get('sub_type');
                if ($transaction_type === PaymentConfig::STATUS_COMPLETED){
                    SubscriptionManager::HandleSubscriptionRequest($query, $sub_data);
                }elseif ($transaction_type === PaymentConfig::STATUS_REFUND){
	    			SubscriptionManager::HandleRefundRequest($query, $sub_data);
	    		}

            }

            echo 'Payment Processed';
        }catch(\Exception $e)
		{
			echo $e;
		    exit(1);
		}

	}
}
