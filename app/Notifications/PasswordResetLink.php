<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class PasswordResetLink extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;
}
