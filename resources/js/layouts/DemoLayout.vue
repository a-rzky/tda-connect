<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    Briefcase,
    ClipboardCheck,
    Home,
    Handshake,
    ShieldCheck,
} from '@lucide/vue';
import type { LucideIcon } from '@lucide/vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';

interface NavItem {
    href: string;
    label: string;
    /** Label pendek untuk bottom nav mobile — ruangnya sempit di 375px. */
    shortLabel: string;
    icon: LucideIcon;
}

defineProps<{
    /** Judul layar, tampil di top bar mobile dan sebagai heading desktop. */
    title: string;
    /** Satu baris konteks di bawah judul. Opsional. */
    subtitle?: string;
}>();

const { isCurrentUrl } = useCurrentUrl();

const memberNav: NavItem[] = [
    { href: '/demo', label: 'Beranda', shortLabel: 'Beranda', icon: Home },
    {
        href: '/demo/bisnis',
        label: 'Bisnis saya',
        shortLabel: 'Bisnis',
        icon: Briefcase,
    },
    {
        href: '/demo/level-usaha',
        label: 'Level usaha',
        shortLabel: 'Level',
        icon: ClipboardCheck,
    },
    {
        href: '/demo/pengadaan',
        label: 'Pengadaan',
        shortLabel: 'Pengadaan',
        icon: Handshake,
    },
];
</script>

<template>
    <div class="min-h-dvh bg-tda-surface text-tda-ink">
        <div class="mx-auto flex w-full max-w-6xl lg:gap-8 lg:px-6">
            <!-- Sidebar desktop. Di mobile digantikan bottom nav di bawah. -->
            <aside
                class="sticky top-0 hidden h-dvh w-60 shrink-0 flex-col py-6 lg:flex"
            >
                <Link
                    href="/demo"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                >
                    <span
                        class="h-9 w-9 rounded-xl bg-tda-navy"
                        aria-hidden="true"
                    />
                    <span>
                        <span
                            class="block text-[15px] font-bold tracking-tight"
                            >TDA Connect</span
                        >
                        <span class="block text-xs text-tda-muted">Depok</span>
                    </span>
                </Link>

                <nav class="mt-8 flex flex-col gap-1" aria-label="Menu utama">
                    <Link
                        v-for="item in memberNav"
                        :key="item.href"
                        :href="item.href"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                        :class="
                            isCurrentUrl(item.href)
                                ? 'bg-tda-navy font-semibold text-white'
                                : 'text-tda-ink hover:bg-tda-surface-alt'
                        "
                        :aria-current="isCurrentUrl(item.href) ? 'page' : undefined"
                    >
                        <component :is="item.icon" class="size-[18px]" />
                        {{ item.label }}
                    </Link>
                </nav>

                <div class="mt-auto border-t border-tda-line pt-4">
                    <Link
                        href="/demo/pengurus/verifikasi"
                        class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                        :class="
                            isCurrentUrl('/demo/pengurus/verifikasi')
                                ? 'bg-tda-navy font-semibold text-white'
                                : 'text-tda-muted hover:bg-tda-surface-alt'
                        "
                    >
                        <ShieldCheck class="size-[18px]" />
                        Panel pengurus
                    </Link>
                </div>
            </aside>

            <div class="min-w-0 flex-1">
                <!-- Top bar mobile. Judul saja, tanpa aksi — aksinya ada di isi layar. -->
                <header
                    class="sticky top-0 z-10 border-b border-tda-line bg-tda-surface/90 px-4 py-3 backdrop-blur lg:static lg:border-0 lg:bg-transparent lg:px-0 lg:py-8 lg:backdrop-blur-none"
                >
                    <h1
                        class="text-lg font-bold tracking-tight lg:text-2xl"
                    >
                        {{ title }}
                    </h1>
                    <p
                        v-if="subtitle"
                        class="mt-0.5 text-[13px] text-tda-muted lg:mt-1 lg:text-sm"
                    >
                        {{ subtitle }}
                    </p>
                </header>

                <!-- pb-32 memberi ruang untuk bottom nav mengambang di mobile. -->
                <main class="px-4 pt-5 pb-32 lg:px-0 lg:pt-0 lg:pb-16">
                    <slot />
                </main>
            </div>
        </div>

        <!--
            Bottom nav mengambang.

            Radius item aktif harus konsentris dengan kontainernya: radius luar
            dikurangi padding. Kontainer setinggi 60px yang rounded-full berarti
            radius 30px, dikurangi p-1.5 (6px) jadi 24px — dan pada item setinggi
            48px, 24px persis sama dengan rounded-full. Latarnya tembus pandang dan diblur, jadi
            konten yang lewat di bawahnya tetap terasa.

            bg-white/90 adalah nilai dasar; hanya browser yang benar-benar
            mendukung backdrop-filter yang turun ke /70. Tanpa penjagaan ini,
            browser tanpa blur akan menampilkan teks nav di atas konten mentah.
        -->
        <div
            class="pointer-events-none fixed inset-x-0 bottom-0 z-20 px-4 pb-[calc(env(safe-area-inset-bottom,0px)+0.75rem)] lg:hidden"
        >
            <nav
                class="pointer-events-auto mx-auto flex max-w-sm gap-1 rounded-full border border-white/70 bg-white/90 p-1.5 shadow-[0_8px_28px_rgba(8,24,51,.16)] backdrop-blur-xl supports-[backdrop-filter]:bg-white/70"
                aria-label="Menu utama"
            >
                <Link
                    v-for="item in memberNav"
                    :key="item.href"
                    :href="item.href"
                    class="flex min-h-12 min-w-0 flex-1 flex-col items-center justify-center gap-0.5 rounded-full px-1 transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                    :class="
                        isCurrentUrl(item.href)
                            ? 'bg-tda-slate text-white'
                            : 'text-tda-muted'
                    "
                    :aria-current="isCurrentUrl(item.href) ? 'page' : undefined"
                >
                    <component
                        :is="item.icon"
                        class="size-5"
                        :stroke-width="isCurrentUrl(item.href) ? 2.4 : 1.8"
                    />
                    <span
                        class="text-[11px] leading-none tracking-tight"
                        :class="isCurrentUrl(item.href) && 'font-semibold'"
                        >{{ item.shortLabel }}</span
                    >
                </Link>
            </nav>
        </div>
    </div>
</template>
