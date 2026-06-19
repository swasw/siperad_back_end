<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class TestPushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:test {user_id_or_username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi push test ke user berdasarkan username atau ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $identifier = $this->argument('user_id_or_username');
        $user = User::where('username', $identifier)->orWhere('id', $identifier)->first();

        if (!$user) {
            $this->error("User dengan username / ID {$identifier} tidak ditemukan.");
            return;
        }

        if ($user->pushSubscriptions()->count() === 0) {
            $this->warn("User {$identifier} belum mengizinkan notifikasi di browser/HP-nya (tidak ada push subscription).");
            return;
        }

        $notification = new class extends Notification {
            public function via($notifiable)
            {
                return [WebPushChannel::class];
            }

            public function toWebPush($notifiable, $notification)
            {
                return (new WebPushMessage)
                    ->title('Test Notifikasi SIPERAD')
                    ->icon('/frontend/assets/img/logo-unj.png')
                    ->body('Halo! Ini adalah notifikasi test untuk memastikan push notification berjalan dengan baik di HP kamu.')
                    ->action('Buka SIPERAD', 'open_app')
                    ->data(['url' => "/user/notifikasi"]);
            }
        };

        $user->notify($notification);

        $this->info("Notifikasi berhasil dikirim ke user {$identifier}!");
    }
}
