<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

/**
 * Sumber data demo TDA Connect Depok.
 *
 * Semua data di sini statis dan hanya untuk presentasi — belum ada schema
 * Health Check maupun Procurement. Bentuk arraynya sengaja dibuat sama dengan
 * kontrak props di resources/js/types/demo.ts supaya nanti tinggal ditukar
 * dengan query asli tanpa mengubah komponen.
 *
 * Level dikirim sebagai kode saja. Nama L1-L7 belum diputuskan pengurus.
 */
class DemoController extends Controller
{
    /**
     * Batas eligibilitas pengadaan. Di MVP nanti ini konstanta config
     * (PROCUREMENT_MIN_LEVEL), bukan kolom per-record.
     */
    private const PROCUREMENT_MIN_LEVEL = 3;

    public function beranda(): Response
    {
        return Inertia::render('demo/Beranda', [
            'member' => $this->member(),
            'attention' => $this->attention(),
            'businesses' => array_slice($this->businesses(), 0, 2),
            'openProcurementCount' => count($this->procurements()),
        ]);
    }

    public function bisnis(): Response
    {
        return Inertia::render('demo/Bisnis', [
            'member' => $this->member(),
            'businesses' => $this->businesses(),
        ]);
    }

    public function levelUsaha(): Response
    {
        return Inertia::render('demo/LevelUsaha', [
            'member' => $this->member(),
            'business' => $this->businesses()[0],
            'ladder' => $this->ladder(),
            'checklist' => $this->checklist(),
        ]);
    }

    public function pengadaan(): Response
    {
        return Inertia::render('demo/Pengadaan', [
            'member' => $this->member(),
            'procurements' => $this->procurements(),
            'minLevel' => 'L'.self::PROCUREMENT_MIN_LEVEL,
        ]);
    }

    public function verifikasi(): Response
    {
        return Inertia::render('demo/pengurus/Verifikasi', [
            'queue' => $this->verificationQueue(),
        ]);
    }

    /** @return array<string, mixed> */
    private function member(): array
    {
        return [
            'name' => 'Nabila Rahma',
            'passport' => 'TDA-DPK-0248',
            'region' => 'Depok',
            'status' => 'Aktif',
            'email' => 'nabila.r*****@mail.com',
            'highestLevel' => 'L4',
            'businessCount' => 3,
        ];
    }

    /** @return list<array<string, mixed>> */
    private function businesses(): array
    {
        return [
            [
                'slug' => 'kopi-seroja-depok',
                'name' => 'Kopi Seroja Depok',
                'industry' => 'F&B',
                'level' => 'L4',
                'state' => 'ready',
                'note' => '2 cabang · 12 karyawan',
                'reapplyOn' => null,
            ],
            [
                'slug' => 'seroja-catering',
                'name' => 'Seroja Catering',
                'industry' => 'Jasa boga',
                'level' => 'L3',
                'state' => 'review',
                'note' => 'Pengajuan dikirim 24 Agustus 2026',
                'reapplyOn' => null,
            ],
            [
                'slug' => 'studio-kemasan-lokal',
                'name' => 'Studio Kemasan Lokal',
                'industry' => 'Desain & percetakan',
                'level' => 'L2',
                'state' => 'cooldown',
                'note' => 'Pengajuan terakhir belum memenuhi syarat',
                'reapplyOn' => '12 September 2026',
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function attention(): array
    {
        return [
            [
                'tone' => 'warn',
                'title' => 'Seroja Catering menunggu verifikasi pengurus',
                'body' => 'Pengajuan dikirim 24 Agustus 2026.',
                'href' => '/demo/bisnis',
            ],
            [
                'tone' => 'ok',
                'title' => 'Penawaran terkirim',
                'body' => 'Snack box workshop AI · dikirim 26 Agustus 2026.',
                'href' => '/demo/pengadaan',
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function ladder(): array
    {
        return [
            ['level' => 'L1', 'state' => 'done', 'note' => 'Terlampaui.'],
            ['level' => 'L2', 'state' => 'done', 'note' => 'Terlampaui.'],
            ['level' => 'L3', 'state' => 'done', 'note' => 'Terlampaui. Mulai dari sini bisa mengirim penawaran pengadaan.'],
            ['level' => 'L4', 'state' => 'current', 'note' => 'Level usaha saat ini.'],
            ['level' => 'L5', 'state' => 'next', 'note' => 'Semua pertanyaan wajib dijawab "Ya", lalu diverifikasi pengurus.'],
            ['level' => 'L6', 'state' => 'locked', 'note' => 'Terbuka setelah L5 disetujui.'],
            ['level' => 'L7', 'state' => 'locked', 'note' => 'Terbuka setelah L6 disetujui.'],
        ];
    }

    /**
     * Pertanyaan sudah difilter backend berdasarkan industry_tags bisnis ini.
     * Tag-nya sendiri tidak pernah ikut dikirim ke frontend.
     *
     * @return list<array<string, mixed>>
     */
    private function checklist(): array
    {
        return [
            [
                'question' => 'Usaha memiliki pencatatan transaksi bulanan yang rutin.',
                'answered' => true,
                'help' => null,
            ],
            [
                'question' => 'Usaha memiliki SOP produksi atau pelayanan yang dipakai tim.',
                'answered' => true,
                'help' => null,
            ],
            [
                'question' => 'Usaha memiliki izin edar atau sertifikasi yang berlaku untuk produknya.',
                'answered' => false,
                'help' => 'Pengurus TDA Depok membuka pendampingan pengurusan izin edar setiap bulan. Jawaban ini boleh diubah setelah izin terbit.',
            ],
            [
                'question' => 'Usaha memisahkan rekening pribadi dan rekening usaha.',
                'answered' => null,
                'help' => null,
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    private function procurements(): array
    {
        $memberLevel = (int) substr($this->member()['highestLevel'], 1);
        $canBid = $memberLevel >= self::PROCUREMENT_MIN_LEVEL;

        $projects = [
            ['slug' => 'hampers-september', 'title' => 'Paket hampers UMKM September', 'budget' => 'Rp18 jt', 'closesOn' => '2 September 2026', 'category' => 'F&B'],
            ['slug' => 'booth-event-komunitas', 'title' => 'Desain booth event komunitas', 'budget' => 'Rp7,5 jt', 'closesOn' => '5 September 2026', 'category' => 'Desain'],
            ['slug' => 'snack-box-workshop-ai', 'title' => 'Snack box workshop AI', 'budget' => 'Rp12 jt', 'closesOn' => '7 September 2026', 'category' => 'Jasa boga'],
            ['slug' => 'seragam-panitia', 'title' => 'Seragam panitia TDA Depok 9.0', 'budget' => 'Rp24 jt', 'closesOn' => '9 September 2026', 'category' => 'Konveksi'],
            ['slug' => 'katering-rapat-bulanan', 'title' => 'Katering rapat bulanan pengurus', 'budget' => 'Rp6 jt', 'closesOn' => '11 September 2026', 'category' => 'Jasa boga'],
            ['slug' => 'cetak-materi-workshop', 'title' => 'Cetak materi workshop UMKM', 'budget' => 'Rp4,2 jt', 'closesOn' => '14 September 2026', 'category' => 'Percetakan'],
            ['slug' => 'dokumentasi-foto-video', 'title' => 'Dokumentasi foto & video gathering', 'budget' => 'Rp15 jt', 'closesOn' => '18 September 2026', 'category' => 'Kreatif'],
            ['slug' => 'souvenir-gathering', 'title' => 'Souvenir gathering akhir tahun', 'budget' => 'Rp32 jt', 'closesOn' => '22 September 2026', 'category' => 'Kerajinan'],
        ];

        return array_map(
            static fn (array $project): array => [...$project, 'canBid' => $canBid],
            $projects,
        );
    }

    /** @return list<array<string, mixed>> */
    private function verificationQueue(): array
    {
        return [
            ['business' => 'Seroja Catering', 'member' => 'Nabila Rahma', 'from' => 'L3', 'to' => 'L4', 'waitingDays' => 5, 'status' => 'Data lengkap', 'needsManualReview' => false],
            ['business' => 'Rana Craft', 'member' => 'Dimas Pratama', 'from' => 'L4', 'to' => 'L5', 'waitingDays' => 3, 'status' => 'Perlu review manual', 'needsManualReview' => true],
            ['business' => 'Depok Print Lab', 'member' => 'Ratna Sari', 'from' => 'L5', 'to' => 'L6', 'waitingDays' => 1, 'status' => 'Perlu review manual', 'needsManualReview' => true],
            ['business' => 'Warung Bu Tini', 'member' => 'Agus Salim', 'from' => 'L2', 'to' => 'L3', 'waitingDays' => 1, 'status' => 'Data lengkap', 'needsManualReview' => false],
        ];
    }
}
