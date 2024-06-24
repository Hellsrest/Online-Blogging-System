<?php
class BankAccount {
    private $balance; 

    public function __construct($initialBalance) {
        $this->balance = $initialBalance;
    }

    public function getBalance() {
        return $this->balance;
    }

    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
        } else {
           echo("Invalid deposit amount");
        }
    }

    public function withdraw($amount) {
        if ($amount > $this->balance) {
            echo("Insufficient funds");
        } else {
            $this->balance -= $amount;
        }
    }
}
$account = new BankAccount(1000); 

echo "Current balance: " . $account->getBalance() . "\n"; 

$account->deposit(500);
echo "Balance after deposit: " . $account->getBalance() . "\n"; 

$account->withdraw(800);
echo "Balance after withdrawal: " . $account->getBalance() . "\n"; 

//echo $account->balance; // Produces a fatal error: Cannot access private property BankAccount::$balance