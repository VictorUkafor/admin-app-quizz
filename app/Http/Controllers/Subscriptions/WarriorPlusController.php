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

class WarriorPlusController extends Controller
{
    const GATEWAY = 'warriorplus';
	const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';

    public function processPayment(Request $request){

        $data = $request->all();

        $validator = Validator::make($data, [
            'WP_ITEM_NUMBER' => 'required',
            'WP_BUYER_EMAIL' => 'required|string|email|max:255',
            'WP_TXNID' => 'required',
            'WP_SALE_AMOUNT' => 'required',
        ]);

        if ($validator->fails())
        {
            exit('Bad Request');
        }

        $product_id = $data['WP_ITEM_NUMBER'];

        $parts = Helper::splitFullname($data['WP_BUYER_NAME']);

		$data['firstname'] = $parts['firstname'];
        $data['lastname']  = $parts['lastname'];

        $payment_type = $data['WP_ACTION'];
		$sub_type = $data['WP_ACTION'];
		$transaction_id = ($data['WP_TXNID'])? $data['WP_TXNID']: $data['WP_SUBSCR_PAYMENT_TXNID'];

		$success_statuses = [
            'sale',
            'subscr_created',
            'subscr_completed',
            'subscr_reactivated'
        ];
		$failed_statuses = ['subscr_ended', 'subscr_cancelled'];
        $refund_statuses = ['refund', 'subscr_refunded'];

        if ( array_search($payment_type, $success_statuses) !== false )
		{
		    $transaction_type = PaymentConfig::STATUS_COMPLETED;
		}
		elseif ( array_search($payment_type, $refund_statuses) !== false )
		{
		    $transaction_type = PaymentConfig::STATUS_REFUND;
		}

		if (empty( $transaction_type ))
		{
			Log::info('WorriorPlus IPN data: ', $data);

			exit('Error recording transaction');
        }

        if (
            PaymentTransactionLogger::transactionExists($transaction_id)
             && $transaction_type !== PaymentConfig::STATUS_REFUND
        ){
		    exit("Transaction ID already processed.");
        }

        $sub_data = [
			'firstname' => $parts['firstname'],
			'lastname'  => $parts['lastname'],
			'email'		=> $data['WP_BUYER_EMAIL'],
			'fullname'	=> $data['WP_BUYER_NAME'],
			'txn_id' => $transaction_id,
			'order_id' => $data['WP_TXNID'],
			'transaction_type' => $transaction_type,
			'amount' => $data['WP_SALE_AMOUNT'] . ' ' . PaymentConfig::CURRENCY_USD,
			'payment_gateway' => self::GATEWAY,
			'payment_status' => $transaction_type
        ];

        try{
            $query = $request->get('sub_type');
            if ($transaction_type === PaymentConfig::STATUS_COMPLETED){
                SubscriptionManager::HandleSubscriptionRequest($query, $sub_data);
            }elseif ($transaction_type === PaymentConfig::STATUS_REFUND){
                SubscriptionManager::HandleRefundRequest($query, $sub_data);
            }


            echo 'Payment Processed';

        }catch(\Exception $e){
            echo $e;
		    exit(1);
        }

    }
}
