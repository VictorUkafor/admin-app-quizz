<?php
namespace App\Helpers;

class PaymentConfig
{
    const PAYPAL_GATEWAY = 'paypal';
    const PAYSTACK_GATEWAY = 'paystack';
    const JVZ_GATEWAY = 'jvz';

	const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
	const STATUS_CANCELLED = 'cancelled';
    const STATUS_FAILED = 'failed';
	const STATUS_REFUND = 'refund';

    const TRANSACTION_TYPE_RFND = 'RFND';
    const TRANSACTION_TYPE_SALE = 'SALE';

	const CURRENCY_USD = 'USD';
	const CURRENCY_NGN = 'NGN';
	const CURRENCY_GBP = 'GBP';
	const CURRENCY_EUR = 'EUR';

	const MONTHLY = 'monthly';
    const LIFETIME = 'lifetime';
    const YEARLY = 'yearly';

}
