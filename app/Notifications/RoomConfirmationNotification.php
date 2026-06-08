<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class RoomConfirmationNotification extends Notification
{
    use Queueable;

    public $jadwal;
    public $tanggal;

    public function __construct($jadwal, $tanggal)
    {
        $this->jadwal = $jadwal;
        $this->tanggal = $tanggal;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Konfirmasi Penggunaan Ruangan')
            ->icon('/frontend/assets/img/logo-unj.png')
            ->body("Apakah Matkul {$this->jadwal->mata_kuliah} akan menggunakan ruang {$this->jadwal->ruang->nama_ruang} pada {$this->tanggal}?")
            ->action('Konfirmasi Sekarang', 'konfirmasi')
            ->data(['url' => "/user/notifikasi"]); // Mengarahkan ke halaman inbox notifikasi
    }
}
