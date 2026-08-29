<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import LevelBadge from '@/components/demo/LevelBadge.vue';
import StatusPill from '@/components/demo/StatusPill.vue';
import type { Business } from '@/types/demo';

defineProps<{ business: Business }>();
</script>

<template>
    <article
        class="rounded-2xl border border-tda-line bg-white p-4 shadow-[0_1px_2px_rgba(8,24,51,.04)]"
    >
        <div class="flex items-start justify-between gap-3">
            <div class="min-w-0">
                <h3 class="text-[15px] font-bold tracking-tight">
                    {{ business.name }}
                </h3>
                <p class="mt-0.5 text-[13px] text-tda-muted">
                    {{ business.industry }} · {{ business.note }}
                </p>
            </div>
            <LevelBadge
                :level="business.level"
                :tone="business.state === 'ready' ? 'active' : 'neutral'"
            />
        </div>

        <!--
            Satu aksi per kartu. Kata kerjanya harus sama dari tombol sampai
            toast: "Ajukan naik level" -> "Pengajuan terkirim".
        -->
        <div class="mt-4">
            <Link
                v-if="business.state === 'ready'"
                href="/demo/level-usaha"
                class="flex min-h-11 w-full items-center justify-center rounded-xl bg-tda-navy px-5 text-sm font-semibold text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue sm:inline-flex sm:w-auto"
            >
                Ajukan naik level
            </Link>

            <StatusPill v-else-if="business.state === 'review'" tone="warn">
                Menunggu verifikasi pengurus
            </StatusPill>

            <p v-else class="text-[13px] text-tda-muted">
                Belum memenuhi syarat. Bisa mengajukan lagi pada
                <span class="font-semibold text-tda-ink">{{
                    business.reapplyOn
                }}</span
                >.
            </p>
        </div>
    </article>
</template>
