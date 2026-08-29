<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Check, Info, Lock } from '@lucide/vue';
import LevelBadge from '@/components/demo/LevelBadge.vue';
import SectionHeader from '@/components/demo/SectionHeader.vue';
import DemoLayout from '@/layouts/DemoLayout.vue';
import type { Business, ChecklistItem, LadderStep, Member } from '@/types/demo';

const props = defineProps<{
    member: Member;
    business: Business;
    ladder: LadderStep[];
    checklist: ChecklistItem[];
}>();

const answered = props.checklist.filter((item) => item.answered !== null).length;
const nextStep = props.ladder.find((step) => step.state === 'next');
</script>

<template>
    <Head title="Level usaha" />

    <DemoLayout
        title="Level usaha"
        :subtitle="business.name"
    >
        <div class="flex flex-col gap-8">
            <!-- Ringkasan: satu angka besar, bukan roda donat. Lebih terbaca di 375px. -->
            <section
                class="flex items-center gap-4 rounded-2xl border border-tda-line bg-white p-5"
            >
                <LevelBadge :level="business.level" tone="active" size="lg" />
                <div class="min-w-0">
                    <p class="text-[15px] font-bold tracking-tight">
                        Level usaha saat ini
                    </p>
                    <p class="mt-0.5 text-[13px] text-tda-muted">
                        Berikutnya {{ nextStep?.level }}
                    </p>
                </div>
            </section>

            <section>
                <SectionHeader title="Jalur naik level" />
                <ol class="flex flex-col">
                    <li
                        v-for="(step, index) in ladder"
                        :key="step.level"
                        class="flex gap-3"
                    >
                        <!-- Kolom penanda + garis penghubung antar langkah. -->
                        <div class="flex flex-col items-center">
                            <span
                                class="grid size-7 shrink-0 place-items-center rounded-full text-xs font-bold"
                                :class="{
                                    'bg-tda-ok-bg text-tda-ok-ink':
                                        step.state === 'done',
                                    'bg-tda-lime text-tda-navy-deep':
                                        step.state === 'current',
                                    'border border-tda-navy bg-white text-tda-navy':
                                        step.state === 'next',
                                    'border border-tda-line bg-white text-tda-muted':
                                        step.state === 'locked',
                                }"
                            >
                                <Check
                                    v-if="step.state === 'done'"
                                    class="size-4"
                                />
                                <Lock
                                    v-else-if="step.state === 'locked'"
                                    class="size-3.5"
                                />
                                <template v-else>{{
                                    step.level.slice(1)
                                }}</template>
                            </span>
                            <span
                                v-if="index < ladder.length - 1"
                                class="w-px flex-1 bg-tda-line"
                                aria-hidden="true"
                            />
                        </div>

                        <div class="min-w-0 flex-1 pb-5">
                            <p
                                class="text-sm font-bold tabular-nums"
                                :class="
                                    step.state === 'locked' && 'text-tda-muted'
                                "
                            >
                                {{ step.level }}
                            </p>
                            <p class="mt-0.5 text-[13px] text-tda-muted">
                                {{ step.note }}
                            </p>
                        </div>
                    </li>
                </ol>

                <!--
                    Nama tiap level belum diputuskan pengurus, jadi layar ini
                    hanya menampilkan kodenya. Catatan ini dibuka ke member
                    supaya tidak terbaca sebagai kekurangan produk.
                -->
                <p
                    class="flex gap-2 rounded-xl bg-tda-surface-alt p-3 text-[13px] text-tda-muted"
                >
                    <Info class="mt-0.5 size-4 shrink-0" />
                    Nama tiap level usaha sedang difinalkan pengurus dan akan
                    muncul di sini setelah ditetapkan.
                </p>
            </section>

            <section>
                <SectionHeader
                    :title="`Kuesioner ${nextStep?.level} — ${answered} dari ${checklist.length} terjawab`"
                />
                <div class="flex flex-col gap-2.5">
                    <div
                        v-for="(item, index) in checklist"
                        :key="index"
                        class="rounded-2xl border border-tda-line bg-white p-4"
                    >
                        <p class="text-sm leading-relaxed">
                            {{ item.question }}
                        </p>

                        <div class="mt-3 flex gap-2" role="group">
                            <button
                                type="button"
                                class="min-h-11 flex-1 rounded-xl border text-sm font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                                :class="
                                    item.answered === true
                                        ? 'border-tda-navy bg-tda-navy text-white'
                                        : 'border-tda-line bg-white text-tda-ink hover:bg-tda-surface'
                                "
                                :aria-pressed="item.answered === true"
                            >
                                Ya
                            </button>
                            <button
                                type="button"
                                class="min-h-11 flex-1 rounded-xl border text-sm font-semibold transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                                :class="
                                    item.answered === false
                                        ? 'border-tda-navy bg-tda-navy text-white'
                                        : 'border-tda-line bg-white text-tda-ink hover:bg-tda-surface'
                                "
                                :aria-pressed="item.answered === false"
                            >
                                Tidak
                            </button>
                        </div>

                        <!-- Bantuan edukatif hanya muncul saat jawabannya "Tidak". -->
                        <p
                            v-if="item.answered === false && item.help"
                            class="mt-3 flex gap-2 rounded-xl bg-tda-warn-bg p-3 text-[13px] text-tda-warn-ink"
                        >
                            <Info class="mt-0.5 size-4 shrink-0" />
                            {{ item.help }}
                        </p>
                    </div>
                </div>

                <button
                    type="button"
                    class="mt-4 min-h-11 w-full rounded-xl bg-tda-navy px-4 text-sm font-semibold text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                >
                    Kirim pengajuan
                </button>
                <p class="mt-2 text-center text-[13px] text-tda-muted">
                    Pengajuan {{ nextStep?.level }} diverifikasi pengurus
                    sebelum level usaha berubah.
                </p>
            </section>
        </div>
    </DemoLayout>
</template>
