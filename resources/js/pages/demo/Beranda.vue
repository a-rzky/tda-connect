<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ArrowRight, ShieldCheck } from '@lucide/vue';
import AttentionCard from '@/components/demo/AttentionCard.vue';
import BusinessCard from '@/components/demo/BusinessCard.vue';
import EmptyState from '@/components/demo/EmptyState.vue';
import SectionHeader from '@/components/demo/SectionHeader.vue';
import DemoLayout from '@/layouts/DemoLayout.vue';
import type { AttentionItem, Business, Member } from '@/types/demo';

const props = defineProps<{
    member: Member;
    attention: AttentionItem[];
    businesses: Business[];
    openProcurementCount: number;
}>();

const greeting = `Halo, ${props.member.name.split(' ')[0]}`;
</script>

<template>
    <Head title="Beranda" />

    <DemoLayout
        :title="greeting"
        :subtitle="`${member.passport} · ${member.region} · ${member.status}`"
    >
        <div class="flex flex-col gap-8">
            <!--
                Blok "Butuh perhatian" adalah pengganti notifikasi in-app di
                MVP. MVP hanya kirim email, jadi ini satu-satunya tempat member
                melihat apa yang sedang berjalan.
            -->
            <section v-if="attention.length">
                <SectionHeader title="Butuh perhatian" />
                <div class="flex flex-col gap-2.5">
                    <AttentionCard
                        v-for="(item, index) in attention"
                        :key="index"
                        :item="item"
                    />
                </div>
            </section>

            <section>
                <SectionHeader
                    title="Bisnis saya"
                    href="/demo/bisnis"
                    :link-label="`Semua ${member.businessCount}`"
                />
                <div v-if="businesses.length" class="flex flex-col gap-3">
                    <BusinessCard
                        v-for="business in businesses"
                        :key="business.slug"
                        :business="business"
                    />
                </div>
                <EmptyState
                    v-else
                    title="Belum ada usaha terhubung"
                    body="Usaha yang terdaftar di TDA Pusat akan muncul di sini setelah akun kamu diklaim."
                    action-label="Hubungkan usaha"
                    action-href="/demo/bisnis"
                />
            </section>

            <section>
                <Link
                    href="/demo/pengadaan"
                    class="block rounded-2xl bg-tda-navy p-5 text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
                >
                    <p class="text-xs font-semibold text-tda-lime-soft">
                        Pengadaan
                    </p>
                    <p
                        class="mt-1.5 text-lg font-bold tracking-tight text-balance"
                    >
                        {{ openProcurementCount }} pengadaan terbuka untuk TDA
                        Depok
                    </p>
                    <p class="mt-1.5 text-[13px] text-tda-on-navy-muted">
                        Level usaha tertinggi kamu {{ member.highestLevel }} —
                        sudah bisa mengirim penawaran.
                    </p>
                    <span
                        class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-tda-lime"
                    >
                        Lihat pengadaan
                        <ArrowRight class="size-4" />
                    </span>
                </Link>
            </section>

            <!--
                Pintu masuk panel pengurus di mobile. Sengaja dipisah dan tidak
                dijadikan role switcher: bentuk akun pengurus yang juga punya
                usaha masih keputusan terbuka (CLAUDE.md #4).
            -->
            <Link
                href="/demo/pengurus/verifikasi"
                class="flex min-h-11 items-center gap-2 self-start text-[13px] font-semibold text-tda-muted focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue lg:hidden"
            >
                <ShieldCheck class="size-4" />
                Panel pengurus
            </Link>
        </div>
    </DemoLayout>
</template>
