<?php
interface Observable {
    function attach(Observer $bserver);
    function notify($info, $event);
}

interface Observer {
    function update(Observable $observable, $info, $event);
}

class BankAccount implements Observable {
    private $observers = [];

    function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    function notify($info, $event) {
        foreach($this->observers as $observer) {
            $observer->update($this, $info, $event);

        }
    }

    function withdraw($money) {
        $this->notify($money, "MONEY_WITHDRAW");
    }

    function deposit($money){
        $this->notify($money, "MONEY_DEPOSIT");
    }
}

class SMSNotifier implements Observer{
    function update(Observable $observable, $info, $event){
        printf("%s %s \n", $info, $event);
    }
}

$bankAccount = new BankAccount();
$smsNotifier = new SMSNotifier();
$bankAccount->attach($smsNotifier);
$bankAccount->withdraw(500);
$bankAccount->deposit(5000);