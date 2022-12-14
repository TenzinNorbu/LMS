<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use App\Mail\PasswordChangeNotificationMail;
use ESolution\DBEncryption\Encrypter;


class PasswordChangeNotificationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwordchangenotification:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::whereDate('password_reset_date', '=', Carbon::now()->format('Y-m-d'))->get();
       
        foreach($users as $key => $user)
        {
            $email = $user->email;
            Mail::to($email)->send(new PasswordChangeNotificationMail($user));
            User::where('email', 'LIKE', '%' . Encrypter::encrypt($email))->update([
                'password_created_date'=>'NULL',
                'password_status'=>'notChanged'
            ]);
        }
    }
}
