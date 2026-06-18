<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JadwalRuangan;
use App\Models\JadwalKonfirmasi;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\RoomConfirmationNotification;

class SendRoomConfirmation extends Command
{
    protected $signature = 'app:send-room-confirmation';
    protected $description = 'Kirim notifikasi H-2 untuk jadwal ruangan berulang ke PJ Matkul';

    public function handle()
    {
        $daysToCheck = [0, 1, 2]; // H-0 (hari ini), H-1 (besok), H-2 (lusa)
        $count = 0;

        foreach ($daysToCheck as $addDay) {
            $targetDate = Carbon::now()->addDays($addDay);
            $dayMap = [
                0 => 'minggu',
                1 => 'senin',
                2 => 'selasa',
                3 => 'rabu',
                4 => 'kamis',
                5 => 'jumat',
                6 => 'sabtu',
            ];
            $targetHari = $dayMap[$targetDate->dayOfWeek];

            $jadwals = JadwalRuangan::with('ruang', 'Penanggungjawab')->where('hari', 'LIKE', $targetHari)->get();

            foreach ($jadwals as $jadwal) {
                if (!$jadwal->user_id) continue;

                $konfirmasi = JadwalKonfirmasi::firstOrCreate(
                    [
                        'jadwal_ruangan_id' => $jadwal->id,
                        'tanggal' => $targetDate->toDateString(),
                    ],
                    [
                        'status' => 'pending',
                    ]
                );

                // Jika baru dibuat dan masih pending, kirim push notification
                if ($konfirmasi->wasRecentlyCreated && $konfirmasi->status === 'pending') {
                    $user = User::find($jadwal->user_id);
                    if ($user) {
                        $user->notify(new RoomConfirmationNotification($jadwal, $targetDate->toDateString()));
                        $count++;
                    }
                }
            }
        }

        $this->info("Berhasil mengirim $count notifikasi konfirmasi ruangan untuk H-0 hingga H-2");
    }
}
