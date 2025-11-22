<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
//use App\Support\DripEmailer;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Artisan::command('mail:send {user}', function (DripEmailer $dripEmailer, string $user) {
//    $dripEmailer->send(User::find($user));
//})->purpose('Sending an email to a certain user');
