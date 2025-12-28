<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Presensi;
use App\Models\SiswaProfile;
use Carbon\Carbon;

class GenerateAbsenPresensi extends Command
{
    protected $signature = 'app:generate-absen-presensi';
    protected $description = 'Generate presensi absen otomatis';

    public function handle() {
        $today = Carbon::today('Asia/Jakarta');

        /**
         * =====================
         * SKIP WEEKEND
         * =====================
         */
        // sementara comment
        // if ($today->isWeekend()) {
                    // $this->info('Weekend, presensi tidak dibuat.');
                    // return;
        // }

        /**
         * =====================
         *  PROSES SISWA AKTIF
         * =====================
         */
        $siswaList = SiswaProfile::where('is_active', 1)->get();

        foreach ($siswaList as $siswa) {

            $presensi = Presensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $today->toDateString())
                ->first();

            /**
             *  SUDAH ADA PRESENSI
             */
            if ($presensi) {

                //  JANGAN OVERRIDE IZIN / SAKIT
                if (in_array($presensi->status, ['izin', 'sakit'])) {
                    continue;
                }

                //  SUDAH HADIR
                if ($presensi->jam_masuk) {
                    continue;
                }

                //  Tidak absen sama sekali
                $presensi->update([
                    'status'      => 'absen',
                    'kelengkapan' => 'tidak_lengkap'
                ]);

                continue;
            }

            /**
             *  BELUM ADA RECORD → BUAT BARU
             */
            Presensi::create([
                'siswa_id'    => $siswa->id,
                'tanggal'     => $today->toDateString(),
                'status'      => 'absen',
                'kelengkapan' => 'tidak_lengkap',
                'is_active'   => 1
            ]);
        }

        $this->info('Generate presensi otomatis selesai.');
    }

}