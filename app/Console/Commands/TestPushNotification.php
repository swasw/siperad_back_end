<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

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

        $subscriptions = $user->pushSubscriptions;

        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT') ?: 'mailto:test@example.com',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);
        $payload = json_encode([
            'title' => 'Test Notifikasi SIPERAD',
            'body' => 'Halo! Ini adalah notifikasi test ke HP kamu.',
            'icon' => '/frontend/assets/img/logo-unj.png',
            'data' => ['url' => '/user/notifikasi']
        ]);

        $this->info("Mencoba mengirim ke " . $subscriptions->count() . " device...");

        foreach ($subscriptions as $sub) {
            $webPush->queueNotification(
                Subscription::create(json_decode($sub->data, true) ?: [
                    'endpoint' => $sub->endpoint,
                    'publicKey' => $sub->public_key,
                    'authToken' => $sub->auth_token,
                ]),
                $payload
            );
        }

        $success = 0;
        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getRequest()->getUri()->__toString();

            if ($report->isSuccess()) {
                $this->info("[Sukses] Terkirim ke {$endpoint}");
                $success++;
            } else {
                $this->error("[Gagal] Gagal kirim ke {$endpoint}");
                $this->error("Alasan: " . $report->getReason());
            }
        }

        if ($success > 0) {
            $this->info("Total $success notifikasi berhasil diteruskan ke FCM/Server Push.");
        }
    }
}
