<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

interface Business {
    name: string;
    industry: string;
    meta: string;
    level: string;
    state: 'ready' | 'review' | 'cooldown';
    action: string;
}

interface ProcurementProject {
    title: string;
    budget: string;
    deadline: string;
    category: string;
}

interface VerificationItem {
    business: string;
    member: string;
    level: string;
    waiting: string;
    status: string;
}

defineOptions({
    layout: undefined,
});

const businesses: Business[] = [
    {
        name: 'Kopi Seroja Depok',
        industry: 'F&B',
        meta: '2 cabang · 12 karyawan · pembaruan terakhir 18 Agustus 2026',
        level: 'L4',
        state: 'ready',
        action: 'Ajukan naik kelas ke L5',
    },
    {
        name: 'Seroja Catering',
        industry: 'Jasa boga',
        meta: 'Pengajuan L4 dikirim pada 24 Agustus 2026',
        level: 'L3',
        state: 'review',
        action: 'Menunggu verifikasi pengurus',
    },
    {
        name: 'Studio Kemasan Lokal',
        industry: 'Desain & percetakan',
        meta: 'Bisa mengajukan lagi pada 12 September 2026',
        level: 'L2',
        state: 'cooldown',
        action: 'Lihat riwayat',
    },
];

const projects: ProcurementProject[] = [
    {
        title: 'Paket hampers UMKM September',
        budget: 'Rp18 jt',
        deadline: 'Tutup 2 September 2026',
        category: 'F&B',
    },
    {
        title: 'Desain booth event komunitas',
        budget: 'Rp7,5 jt',
        deadline: 'Tutup 5 September 2026',
        category: 'Desain',
    },
    {
        title: 'Snack box workshop AI',
        budget: 'Rp12 jt',
        deadline: 'Tutup 7 September 2026',
        category: 'Jasa boga',
    },
];

const verificationQueue: VerificationItem[] = [
    {
        business: 'Seroja Catering',
        member: 'Nabila Rahma',
        level: 'L3 → L4',
        waiting: '5 hari',
        status: 'Menunggu verifikasi pengurus',
    },
    {
        business: 'Rana Craft',
        member: 'Dimas Pratama',
        level: 'L4 → L5',
        waiting: '3 hari',
        status: 'Perlu review manual',
    },
    {
        business: 'Depok Print Lab',
        member: 'Ratna Sari',
        level: 'L5 → L6',
        waiting: '1 hari',
        status: 'Data lengkap',
    },
];

const navItems = [
    { icon: '⌂', label: 'Beranda', count: null, active: true },
    { icon: '◱', label: 'Bisnis saya', count: '3', active: false },
    { icon: '✓', label: 'Health Check', count: '1', active: false },
    { icon: '◇', label: 'Pengadaan', count: '8', active: false },
];
</script>

<template>
    <Head title="TDA Connect Depok" />

    <div class="min-h-screen bg-[radial-gradient(circle_at_2%_3%,rgba(167,240,75,.45)_0_78px,transparent_240px),radial-gradient(circle_at_94%_0%,rgba(56,189,248,.22)_0_120px,transparent_320px),linear-gradient(135deg,#eef6ff_0%,#f5ffe8_100%)] text-[#081833]">
        <div class="grid min-h-screen grid-cols-1 lg:grid-cols-[250px_minmax(0,1fr)]">
            <aside class="relative hidden h-screen overflow-hidden rounded-r-[36px] bg-[radial-gradient(circle_at_8%_0%,rgba(167,240,75,.50)_0_70px,transparent_190px),radial-gradient(circle_at_96%_16%,rgba(56,189,248,.22)_0_84px,transparent_210px),linear-gradient(180deg,#07275f_0%,#041536_100%)] px-4 py-6 text-white shadow-[16px_0_42px_rgba(4,21,54,.16)] lg:sticky lg:top-0 lg:flex lg:flex-col">
                <div class="pointer-events-none absolute -bottom-8 -left-24 h-64 w-64 rounded-full bg-[radial-gradient(circle,rgba(167,240,75,.88),rgba(56,189,248,.28)_48%,transparent_72%)] opacity-70 blur-sm" />

                <div class="relative z-10 flex items-center gap-3 px-2 pb-6">
                    <div class="h-11 w-11 rounded-2xl bg-[linear-gradient(140deg,#fff_0%,#38bdf8_42%,#a7f04b_100%)] shadow-[0_0_22px_rgba(167,240,75,.38)]" />
                    <div>
                        <h1 class="text-[17px] font-black leading-none tracking-[-.04em]">TDA Connect</h1>
                        <p class="mt-1 text-[10px] font-black uppercase tracking-[.16em] text-[#dafa8b]">Depok 9.0</p>
                    </div>
                </div>

                <nav class="relative z-10 grid gap-1.5">
                    <p class="px-3 pt-3 pb-1 text-[10px] font-black uppercase tracking-[.16em] text-[#b9cdf0]">Dashboard</p>
                    <button
                        v-for="item in navItems"
                        :key="item.label"
                        type="button"
                        class="flex min-h-11 items-center gap-3 rounded-2xl px-3 text-left text-[13px] font-extrabold transition hover:bg-white/10"
                        :class="item.active ? 'bg-[#a7f04b] text-[#041536] shadow-[0_12px_24px_rgba(167,240,75,.24)]' : 'text-[#edf6ff]'"
                    >
                        <span class="w-5 text-center">{{ item.icon }}</span>
                        <span>{{ item.label }}</span>
                        <span v-if="item.count" class="ml-auto rounded-full bg-white/15 px-2 py-0.5 text-[11px]">{{ item.count }}</span>
                    </button>

                    <p class="px-3 pt-5 pb-1 text-[10px] font-black uppercase tracking-[.16em] text-[#b9cdf0]">Panel pengurus</p>
                    <button type="button" class="flex min-h-11 items-center gap-3 rounded-2xl px-3 text-left text-[13px] font-extrabold text-[#edf6ff] transition hover:bg-white/10">
                        <span class="w-5 text-center">▦</span> Verifikasi level <span class="ml-auto rounded-full bg-white/15 px-2 py-0.5 text-[11px]">4</span>
                    </button>
                    <button type="button" class="flex min-h-11 items-center gap-3 rounded-2xl px-3 text-left text-[13px] font-extrabold text-[#edf6ff] transition hover:bg-white/10">
                        <span class="w-5 text-center">⇪</span> CSV pertanyaan
                    </button>
                    <button type="button" class="flex min-h-11 items-center gap-3 rounded-2xl px-3 text-left text-[13px] font-extrabold text-[#edf6ff] transition hover:bg-white/10">
                        <span class="w-5 text-center">☷</span> Monitoring
                    </button>
                </nav>

                <div class="relative z-10 mt-auto rounded-[22px] border border-white/15 bg-white/10 p-4 backdrop-blur-xl">
                    <strong class="block text-[13px]">Let’s Go Together</strong>
                    <p class="mt-2 text-[11.5px] leading-relaxed text-[#d9e7ff]">Demo ini merangkum dua fitur MVP: naik kelas usaha dan pengadaan antar member TDA Depok.</p>
                </div>
            </aside>

            <main class="min-w-0 px-3 py-3 pb-24 md:px-7 md:py-6 lg:pb-10">
                <header class="mb-5 rounded-[26px] border border-[#dce8f6] bg-white p-5 shadow-[0_10px_28px_rgba(4,21,54,.08)] lg:rounded-b-[26px] lg:rounded-t-none">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                        <div>
                            <div class="mb-2 inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-[.12em] text-[#1265cf] before:h-2 before:w-2 before:rounded-full before:bg-[#a7f04b] before:shadow-[0_0_14px_#a7f04b]">Demo dashboard berbasis PRD</div>
                            <h2 class="max-w-4xl text-2xl font-black leading-tight tracking-[-.05em] text-balance md:text-[27px]">Beranda member untuk naik kelas dan ikut pengadaan</h2>
                            <p class="mt-2 max-w-5xl text-[13px] leading-relaxed text-[#62718c]">Data contoh mengikuti PRD root project: level menempel ke bisnis, pengajuan L5–L7 diverifikasi pengurus, dan eligibility pengadaan dihitung dari level bisnis tertinggi.</p>
                        </div>
                        <form class="hidden items-center gap-2 rounded-full border border-[#dce8f6] bg-white px-4 py-2 shadow-[0_10px_28px_rgba(4,21,54,.08)] xl:flex">
                            <input aria-label="Cari pengadaan" class="min-w-0 border-0 bg-transparent text-[13px] outline-0" placeholder="Cari pengadaan..." />
                            <button type="button" aria-label="Cari" class="grid h-9 w-9 place-items-center rounded-full bg-[#07275f] font-black text-white">⌕</button>
                        </form>
                    </div>
                </header>

                <div class="grid items-start gap-5 xl:grid-cols-[minmax(0,1.55fr)_340px]">
                    <div class="grid gap-5">
                        <section class="grid gap-5 rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)] md:grid-cols-[auto_minmax(0,1fr)_auto] md:items-center">
                            <div class="relative h-20 w-20 rounded-full bg-[linear-gradient(145deg,#fff,#38bdf8_34%,#07275f_72%,#a7f04b)] shadow-inner md:h-[104px] md:w-[104px]">
                                <div class="absolute left-[30%] top-[20%] h-[38%] w-[38%] rounded-full bg-[#f6c39d]" />
                                <div class="absolute right-[22%] bottom-[14%] left-[22%] h-[40%] rounded-[25px_25px_18px_18px] bg-[#09408b]" />
                            </div>
                            <div>
                                <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">Data dari TDA Pusat</p>
                                <h3 class="text-xl font-black tracking-[-.04em]">Nabila Rahma</h3>
                                <div class="mt-2 grid gap-1.5 text-[12.5px] text-[#62718c]">
                                    <div><b class="text-[#081833]">No Passport:</b> TDA-DPK-0248</div>
                                    <div><b class="text-[#081833]">Daerah:</b> Depok · <b class="text-[#081833]">Status:</b> Aktif</div>
                                    <div><b class="text-[#081833]">Email:</b> nabila.r*****@mail.com</div>
                                </div>
                            </div>
                            <div class="flex w-fit gap-1 rounded-full border border-[#dce8f6] bg-[#f8fbff] p-1">
                                <button type="button" class="rounded-full bg-[#a7f04b] px-3 py-2 text-[11.5px] font-black text-[#041536]">Member</button>
                                <button type="button" class="rounded-full px-3 py-2 text-[11.5px] font-black text-[#62718c]">Pengurus</button>
                            </div>
                        </section>

                        <section class="grid grid-cols-2 gap-3 xl:grid-cols-4">
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <span class="text-[11.5px] font-extrabold text-[#62718c]">Bisnis terhubung</span>
                                <strong class="mt-2 block text-2xl font-black tracking-[-.05em]">3</strong>
                                <small class="font-black text-[#1265cf]">sinkron data pusat</small>
                            </div>
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <span class="text-[11.5px] font-extrabold text-[#62718c]">Level tertinggi</span>
                                <strong class="mt-2 block text-2xl font-black tracking-[-.05em]">L4</strong>
                                <small class="font-black text-[#1265cf]">eligible penawaran</small>
                            </div>
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <span class="text-[11.5px] font-extrabold text-[#62718c]">Pengadaan terbuka</span>
                                <strong class="mt-2 block text-2xl font-black tracking-[-.05em]">8</strong>
                                <small class="font-black text-[#1265cf]">deadline terdekat</small>
                            </div>
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <span class="text-[11.5px] font-extrabold text-[#62718c]">Butuh perhatian</span>
                                <strong class="mt-2 block text-2xl font-black tracking-[-.05em]">2</strong>
                                <small class="font-black text-[#1265cf]">review & proposal</small>
                            </div>
                        </section>

                        <section class="rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)]">
                            <div class="mb-4 flex items-end justify-between gap-4">
                                <div>
                                    <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">Bisnis saya</p>
                                    <h3 class="text-[17px] font-black tracking-[-.035em]">Kelas usaha per unit bisnis</h3>
                                </div>
                                <a href="#" class="text-[12.5px] font-black text-[#1265cf]">Lihat semua bisnis</a>
                            </div>
                            <div class="grid gap-3">
                                <article v-for="business in businesses" :key="business.name" class="grid items-center gap-3 rounded-[20px] border border-[#dce8f6] bg-[linear-gradient(90deg,#e8f4ff,#f8fbff)] py-3 pr-3 pl-0 md:grid-cols-[8px_minmax(0,1fr)_auto]">
                                    <div class="hidden h-full min-h-[74px] rounded-r-full bg-[#0b4ea2] md:block" />
                                    <div class="px-4 md:px-0">
                                        <h4 class="text-[14.5px] font-black">{{ business.name }}</h4>
                                        <p class="mt-1 text-xs leading-relaxed text-[#62718c]">{{ business.industry }} · {{ business.meta }}</p>
                                    </div>
                                    <div class="flex flex-wrap gap-2 px-4 md:justify-end md:px-0">
                                        <span class="inline-flex min-h-8 items-center rounded-full bg-[#a7f04b] px-3 text-xs font-black text-[#041536] shadow-[0_9px_18px_rgba(167,240,75,.24)]">{{ business.level }}</span>
                                        <button v-if="business.state === 'ready'" type="button" class="min-h-11 rounded-2xl bg-[#a7f04b] px-4 text-[12.5px] font-black text-[#041536] shadow-[0_12px_22px_rgba(167,240,75,.26)]">{{ business.action }}</button>
                                        <span v-else-if="business.state === 'review'" class="inline-flex min-h-8 items-center rounded-full bg-[#fff4d7] px-3 text-xs font-black text-[#d97706]">{{ business.action }}</span>
                                        <button v-else type="button" class="min-h-11 rounded-2xl border border-[#dce8f6] bg-[#f8fbff] px-4 text-[12.5px] font-black text-[#1265cf]">{{ business.action }}</button>
                                    </div>
                                </article>
                            </div>
                        </section>

                        <section class="grid gap-6 rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)] md:grid-cols-[178px_minmax(0,1fr)] md:items-center">
                            <div class="mx-auto grid h-[178px] w-[178px] place-items-center rounded-full bg-[conic-gradient(#a7f04b_0_58%,#dce8f6_58%_100%)] shadow-[0_0_0_8px_rgba(167,240,75,.10)]">
                                <div class="grid h-[146px] w-[146px] place-items-center rounded-full bg-white text-center">
                                    <div>
                                        <strong class="block text-[42px] font-black tracking-[-.07em]">L4</strong>
                                        <span class="text-[10.5px] font-black uppercase tracking-[.13em] text-[#62718c]">Kelas aktif</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4 flex items-end justify-between gap-4">
                                    <div>
                                        <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">Business Health Check</p>
                                        <h3 class="text-[17px] font-black tracking-[-.035em]">Jalur naik kelas Kopi Seroja</h3>
                                    </div>
                                    <button type="button" class="text-[12.5px] font-black text-[#1265cf]">Pratinjau kuesioner</button>
                                </div>
                                <div class="grid gap-3">
                                    <div class="grid grid-cols-[32px_minmax(0,1fr)] gap-3"><div class="grid h-8 w-8 place-items-center rounded-full bg-[#16a34a] text-xs font-black text-white">✓</div><div><h4 class="text-[13px] font-black">L2 — Fondasi usaha</h4><p class="mt-1 text-xs leading-relaxed text-[#62718c]">Profil dasar, status usaha, dan data dari pusat sudah siap.</p></div></div>
                                    <div class="grid grid-cols-[32px_minmax(0,1fr)] gap-3"><div class="grid h-8 w-8 place-items-center rounded-full bg-[#16a34a] text-xs font-black text-white">✓</div><div><h4 class="text-[13px] font-black">L3 — Siap ikut pengadaan</h4><p class="mt-1 text-xs leading-relaxed text-[#62718c]">Memenuhi syarat minimum untuk mengirim penawaran pengadaan.</p></div></div>
                                    <div class="grid grid-cols-[32px_minmax(0,1fr)] gap-3"><div class="grid h-8 w-8 place-items-center rounded-full bg-[#a7f04b] text-xs font-black text-[#041536]">4</div><div><h4 class="text-[13px] font-black">L4 — Operasional bertumbuh</h4><p class="mt-1 text-xs leading-relaxed text-[#62718c]">Kelas aktif saat ini. Target berikutnya masuk verifikasi manual.</p></div></div>
                                    <div class="grid grid-cols-[32px_minmax(0,1fr)] gap-3"><div class="grid h-8 w-8 place-items-center rounded-full border border-[#dce8f6] bg-[#f8fbff] text-xs font-black">5</div><div><h4 class="text-[13px] font-black">L5 — Review pengurus</h4><p class="mt-1 text-xs leading-relaxed text-[#62718c]">Semua pertanyaan wajib harus dijawab “Ya”, lalu pengurus memverifikasi.</p></div></div>
                                </div>
                            </div>
                        </section>

                        <section class="grid gap-4 lg:grid-cols-2">
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">FE-08</p>
                                <h3 class="text-sm font-black">Contoh checklist relevan industri</h3>
                                <div class="mt-3 divide-y divide-[#dce8f6] text-[12.5px] leading-relaxed">
                                    <p class="py-2">✓ Memiliki pencatatan transaksi bulanan yang rutin.</p>
                                    <p class="py-2">✓ Memiliki SOP produksi atau pelayanan yang dipakai tim.</p>
                                    <p class="py-2">! Jika menjawab “Tidak”, bantuan edukatif muncul di bawah pertanyaan.</p>
                                </div>
                            </div>
                            <div class="rounded-[22px] border border-[#dce8f6] bg-white p-4 shadow-[0_10px_28px_rgba(4,21,54,.08)]">
                                <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">FE-17 · FE-18</p>
                                <h3 class="text-sm font-black">Panel pengurus yang ikut demo</h3>
                                <div class="mt-3 divide-y divide-[#dce8f6] text-[12.5px] leading-relaxed">
                                    <p class="py-2">⇪ Upload CSV pertanyaan dengan preview baru, diperbarui, hilang, dan gagal validasi.</p>
                                    <p class="py-2">▦ Antrian verifikasi menampilkan omset, karyawan, dan riwayat level bisnis.</p>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)]">
                            <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                                <div>
                                    <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#1265cf]">Panel pengurus</p>
                                    <h3 class="text-[17px] font-black tracking-[-.035em]">Antrian verifikasi naik kelas</h3>
                                </div>
                                <button type="button" class="min-h-11 rounded-2xl bg-[#0b4ea2] px-4 text-[12.5px] font-black text-white">Buka panel admin</button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[620px] border-separate border-spacing-y-2 text-left">
                                    <thead>
                                        <tr class="text-[11px] font-black uppercase tracking-[.12em] text-[#62718c]"><th class="px-3">Bisnis</th><th class="px-3">Member</th><th class="px-3">Level</th><th class="px-3">Menunggu</th><th class="px-3">Status</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in verificationQueue" :key="item.business" class="text-[12.5px]">
                                            <td class="rounded-l-2xl border-y border-l border-[#dce8f6] bg-[#f8fbff] px-3 py-3 font-extrabold">{{ item.business }}</td>
                                            <td class="border-y border-[#dce8f6] bg-[#f8fbff] px-3 py-3">{{ item.member }}</td>
                                            <td class="border-y border-[#dce8f6] bg-[#f8fbff] px-3 py-3">{{ item.level }}</td>
                                            <td class="border-y border-[#dce8f6] bg-[#f8fbff] px-3 py-3">{{ item.waiting }}</td>
                                            <td class="rounded-r-2xl border-y border-r border-[#dce8f6] bg-[#f8fbff] px-3 py-3"><span class="inline-flex rounded-full bg-[#fff4d7] px-3 py-1.5 text-xs font-black text-[#d97706]">{{ item.status }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="mt-4 text-[11.5px] leading-relaxed text-[#62718c]">Catatan PRD: istilah sistem seperti PENDING_REVIEW tidak ditampilkan ke member. Di dashboard demo ini dipakai copy “Menunggu verifikasi pengurus”.</p>
                        </section>
                    </div>

                    <aside class="grid gap-5">
                        <section class="rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)]">
                            <h3 class="mb-4 text-[17px] font-black tracking-[-.035em]">Butuh perhatian</h3>
                            <div class="grid gap-3">
                                <article class="flex gap-3 rounded-[18px] border border-[#f1d999] bg-[#fff4d7] p-3">
                                    <div class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white">!</div>
                                    <div><h4 class="text-[12.5px] font-black">Review L5 sedang berjalan</h4><p class="mt-1 text-[11.5px] leading-relaxed text-[#62718c]">Seroja Catering menunggu verifikasi pengurus sejak 24 Agustus 2026.</p></div>
                                </article>
                                <article class="flex gap-3 rounded-[18px] border border-[#bfe8cb] bg-[#e3f8ea] p-3">
                                    <div class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white">✓</div>
                                    <div><h4 class="text-[12.5px] font-black">Penawaran terkirim</h4><p class="mt-1 text-[11.5px] leading-relaxed text-[#62718c]">Proposal untuk “Snack box acara komunitas” berhasil dikirim.</p></div>
                                </article>
                            </div>
                        </section>

                        <section class="rounded-[30px] border border-[#dce8f6] bg-white p-5 shadow-[0_20px_55px_rgba(4,21,54,.13)]">
                            <h3 class="mb-4 text-[17px] font-black tracking-[-.035em]">Eligibilitas procurement</h3>
                            <div class="grid gap-3">
                                <article class="flex gap-3 rounded-[18px] border border-[#bfe8cb] bg-[#e3f8ea] p-3"><div class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white text-xs font-black">L4</div><div><h4 class="text-[12.5px] font-black">Bisa kirim penawaran</h4><p class="mt-1 text-[11.5px] leading-relaxed text-[#62718c]">Minimal sistem L3. Dihitung dari level tertinggi bisnis milik member.</p></div></article>
                                <article class="flex gap-3 rounded-[18px] border border-[#f1d999] bg-[#fff4d7] p-3"><div class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-white text-xs font-black">L5</div><div><h4 class="text-[12.5px] font-black">Belum bisa buat pengadaan besar</h4><p class="mt-1 text-[11.5px] leading-relaxed text-[#62718c]">Untuk membuat proyek sebagai member, contoh demo menunggu bisnis mencapai L5.</p></div></article>
                            </div>
                        </section>

                        <section class="relative overflow-hidden rounded-[30px] bg-[linear-gradient(160deg,#07275f_0%,#041536_100%)] p-5 text-white shadow-[0_20px_55px_rgba(4,21,54,.13)]">
                            <div class="pointer-events-none absolute -right-14 -top-14 h-40 w-40 rounded-full bg-[#a7f04b]/25" />
                            <div class="relative">
                                <p class="mb-2 text-[11px] font-black uppercase tracking-[.13em] text-[#dafa8b]">Procurement</p>
                                <h3 class="text-[21px] font-black leading-tight tracking-[-.04em]">8 pengadaan terbuka untuk TDA Depok</h3>
                                <p class="mt-3 text-[12.5px] leading-relaxed text-[#d8e8ff]">Calon pengaju bisa melihat proyek. Jumlah penawaran masuk disembunyikan selama proyek terbuka.</p>
                                <div class="my-4 grid gap-3">
                                    <article v-for="project in projects" :key="project.title" class="rounded-[18px] border border-white/15 bg-white/10 p-3">
                                        <div class="mb-2 flex justify-between gap-3">
                                            <h4 class="text-[13px] font-black leading-snug">{{ project.title }}</h4>
                                            <span class="shrink-0 text-xs font-black text-[#a7f04b]">{{ project.budget }}</span>
                                        </div>
                                        <small class="text-[11.5px] text-[#c4d8f7]">{{ project.deadline }} · {{ project.category }}</small>
                                    </article>
                                </div>
                                <button type="button" class="min-h-11 w-full rounded-2xl bg-[#a7f04b] px-4 text-[12.5px] font-black text-[#041536]">Lihat pengadaan terbuka</button>
                            </div>
                        </section>
                    </aside>
                </div>
            </main>
        </div>

        <nav class="fixed right-3 bottom-3 left-3 z-20 grid grid-cols-4 gap-1.5 rounded-3xl border border-[#dce8f6] bg-white/90 p-2 shadow-[0_20px_55px_rgba(4,21,54,.13)] backdrop-blur-xl lg:hidden" aria-label="Navigasi mobile">
            <a class="grid min-h-13 place-items-center rounded-2xl bg-[#a7f04b] text-[11px] font-black text-[#041536]" href="#">⌂<span>Beranda</span></a>
            <a class="grid min-h-13 place-items-center rounded-2xl text-[11px] font-black text-[#62718c]" href="#">◱<span>Bisnis</span></a>
            <a class="grid min-h-13 place-items-center rounded-2xl text-[11px] font-black text-[#62718c]" href="#">✓<span>Kelas</span></a>
            <a class="grid min-h-13 place-items-center rounded-2xl text-[11px] font-black text-[#62718c]" href="#">◇<span>Pengadaan</span></a>
        </nav>
    </div>
</template>
