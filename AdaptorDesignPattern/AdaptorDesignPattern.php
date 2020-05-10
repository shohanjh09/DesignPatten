<?php
interface PaymentGateway {
    function sendPayment($payment);
}

class PaymentProcessor {
    private $geteway;

    function __construct (PaymentGateway $pg) {
        $this->getway = $pg;
    }

    function purchaseProduct($amount) {
        $this->getway->sendPayment($amount);
    }
}

class Paypal implements PaymentGateway {
    function sendPayment($payment){
        echo "{$payment} processed by paypal\n";
    }
}

class Stripe {
    function makePayment ($amount, $currency = null){
        echo "{$amount} processed by stripe\n";
    }
}

class StripeAdaptor implements PaymentGateway {
    private $stripe;

    function __construct(Stripe $stripe){
        $this->stripe = $stripe;
    }

    function sendPayment($payment){
        $this->stripe->makePayment($payment);
    }
}

//payment using paypal
$paypal = new Paypal();
$paymentProcessorByPaypal = new PaymentProcessor ($paypal);
$paymentProcessorByPaypal->purchaseProduct(45);


//payment using stripe
$stripe = new Stripe();
$stripeAdaptor = new StripeAdaptor($stripe);
$paymentProcessorByStripe = new PaymentProcessor ($stripeAdaptor);
$paymentProcessorByStripe->purchaseProduct(50);
