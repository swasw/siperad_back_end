<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:status {user_id} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim notifikasi push status peminjaman ke user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $identifier = $this->argument('user_id');
        $message = $this->argument('message');
        
        $user = User::find($identifier);

        if (!$user) {
            \Illuminate\Support\Facades\Log::error("WebPush Command: User $identifier tidak ditemukan.");
            return;
        }

        if ($user->pushSubscriptions()->count() === 0) {
            \Illuminate\Support\Facades\Log::warning("WebPush Command: User $identifier belum subscribe.");
            return;
        }

        $subscriptions = $user->pushSubscriptions;

        // Gunakan env() secara langsung karena ini berjalan di CLI mode, sama seperti test:push
        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT') ?: 'mailto:admin@example.com',
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);
        $payload = json_encode([
            'title' => 'Status Peminjaman Ruangan',
            'body' => $message,
            'icon' => '/frontend/assets/img/logo-unj.png',
            'data' => ['url' => '/user/notifikasi']
        ]);

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
                \Illuminate\Support\Facades\Log::info("[WebPush Status Sukses] Terkirim ke {$endpoint}");
                $success++;
            } else {
                \Illuminate\Support\Facades\Log::error("[WebPush Status Gagal] Gagal kirim ke {$endpoint}. Alasan: " . $report->getReason());
            }
        }
        
        if ($success > 0) {
            \Illuminate\Support\Facades\Log::info("WebPush Command: Berhasil mengirim $success notifikasi ke user_id $identifier");
        }
    }
}
