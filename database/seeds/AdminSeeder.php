<?php

use App\Account;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AdminSeeder extends Seeder
{


    public function autoCreate($user_id){
        $accounts = Account::orderBy('created_at', 'desc')->first();
        if($accounts){
            $last_account_num = $accounts->account_number ;
        }else {
            $last_account_num = '1000000000';
        }

        $account_num = (int)$last_account_num + 1;

        $save = Account::create(['user_id' => $user_id, 'account_number' => $account_num]);

        $user = User::findOrFail($user_id);

//        $user->notify(new NewAccount($save));

    }


    public function run()
    {
        $user2 = User::where('email', '=', 'admin@unitedibf.com')->first();
        if($user2 === null){
            $user3 = User::create([
                'first_name' => 'United IBF',
                'last_name' => 'Admin',
                'email' => 'admin@unitedibf.com',
                'status' => 1,
                'user_role' => 1,
                'account_type' => "Savings",
                'email_verified_at' => \Carbon\Carbon::now(),
                'password' => Hash::make('hOUunO&9JBJFvcE82'),
            ]);
            $this->autoCreate($user3->id);
        }

    }




}