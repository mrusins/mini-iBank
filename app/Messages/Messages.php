<?php
namespace App\Messages;

class Messages
{
    public function success1():string{
        return 'Payment successful!';
    }

    public function error1():string{
        return 'Payment unsuccessful!';
    }

    public function error2():string{
        return 'Not enough money in account!';
    }
    public function error3():string{
        return 'Payment cancelled!';
    }
    public function error4():string{
        return 'Something wrong!';
    }
    public function error5():string{
        return 'You must to have Investment account to buy stocks!';
    }
    public function error6():string{
        return 'You don\'t have money enough!';
    }
    public function error7():string{
        return 'You don\'t have stocks enough!';
    }
}
