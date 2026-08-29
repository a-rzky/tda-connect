<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EmptyState from '@/components/demo/EmptyState.vue';
import LevelBadge from '@/components/demo/LevelBadge.vue';
import StatusPill from '@/components/demo/StatusPill.vue';
import DemoLayout from '@/layouts/DemoLayout.vue';
import type { VerificationItem } from '@/types/demo';

defineProps<{ queue: VerificationItem[] }>();
</script>

<template>
    <Head title="Verifikasi naik level" />

    <DemoLayout
        title="Verifikasi naik level"
        subtitle="Panel pengurus · antrian pengajuan yang menunggu keputusan"
    >
        <template v-if="queue.length">
            <!-- Mobile: kartu. Tabel 5 kolom tidak terbaca di 375px. -->
            <div class="flex flex-col gap-3 lg:hidden">
                <article
                    v-for="item in queue"
                    :key="item.business"
                    class="rounded-2xl border border-tda-line bg-white p-4"
                >
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h2 class="text-[15px] font-bold tracking-tight">
                                {{ item.business }}
                            </h2>
                            <p class="mt-0.5 text-[13px] text-tda-muted">
                                {{ item.member }} · menunggu
                                {{ item.waitingDays }} hari
                            </p>
                        </div>
                        <div class="flex shrink-0 items-center gap-1">
                            <LevelBadge :level="item.from" tone="muted" />
                            <span class="text-tda-muted" aria-hidden="true"
                                >→</span
                            >
                            <LevelBadge :level="item.to" tone="neutral" />
                        </div>
                    </div>

                    <StatusPill
                        class="mt-3"
                        :tone="item.needsManualReview ? 'warn' : 'ok'"
                    >
                        {{ item.status }}
                    </StatusPill>

                    <div class="mt-4 flex gap-2">
                        <button
                            type="button"
                            class="min-h-11 flex-1 rounded-xl bg-tda-navy text-sm font-semibold text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                        >
                            Setujui
                        </button>
                        <button
                            type="button"
                            class="min-h-11 flex-1 rounded-xl border border-tda-line bg-white text-sm font-semibold text-tda-ink transition-colors hover:bg-tda-surface focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                        >
                            Tinjau
                        </button>
                    </div>
                </article>
            </div>

            <!-- Desktop: tabel. Pengurus memakai panel ini dari desktop. -->
            <div
                class="hidden overflow-hidden rounded-2xl border border-tda-line bg-white lg:block"
            >
                <table class="w-full text-left text-sm">
                    <thead
                        class="border-b border-tda-line bg-tda-surface text-xs font-semibold text-tda-muted"
                    >
                        <tr>
                            <th scope="col" class="px-4 py-3">Bisnis</th>
                            <th scope="col" class="px-4 py-3">Member</th>
                            <th scope="col" class="px-4 py-3">Level usaha</th>
                            <th scope="col" class="px-4 py-3">Menunggu</th>
                            <th scope="col" class="px-4 py-3">Status</th>
                            <th scope="col" class="px-4 py-3 text-right">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-tda-line">
                        <tr v-for="item in queue" :key="item.business">
                            <td class="px-4 py-3 font-semibold">
                                {{ item.business }}
                            </td>
                            <td class="px-4 py-3 text-tda-muted">
                                {{ item.member }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="flex items-center gap-1">
                                    <LevelBadge
                                        :level="item.from"
                                        tone="muted"
                                    />
                                    <span
                                        class="text-tda-muted"
                                        aria-hidden="true"
                                        >→</span
                                    >
                                    <LevelBadge
                                        :level="item.to"
                                        tone="neutral"
                                    />
                                </span>
                            </td>
                            <td class="px-4 py-3 tabular-nums text-tda-muted">
                                {{ item.waitingDays }} hari
                            </td>
                            <td class="px-4 py-3">
                                <StatusPill
                                    :tone="
                                        item.needsManualReview ? 'warn' : 'ok'
                                    "
                                >
                                    {{ item.status }}
                                </StatusPill>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <button
                                    type="button"
                                    class="min-h-9 rounded-lg bg-tda-navy px-3 text-[13px] font-semibold text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                                >
                                    Tinjau
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>

        <EmptyState
            v-else
            title="Antrian kosong"
            body="Semua pengajuan naik level sudah diputuskan. Pengajuan baru akan muncul di sini."
            action-label="Kembali ke beranda"
            action-href="/demo"
        />
    </DemoLayout>
</template>
