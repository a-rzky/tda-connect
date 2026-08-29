<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import BusinessCard from '@/components/demo/BusinessCard.vue';
import EmptyState from '@/components/demo/EmptyState.vue';
import DemoLayout from '@/layouts/DemoLayout.vue';
import type { Business, Member } from '@/types/demo';

defineProps<{
    member: Member;
    businesses: Business[];
}>();
</script>

<template>
    <Head title="Bisnis saya" />

    <DemoLayout
        title="Bisnis saya"
        subtitle="Level usaha menempel pada tiap unit bisnis, bukan pada akun."
    >
        <div v-if="businesses.length" class="flex flex-col gap-3">
            <BusinessCard
                v-for="business in businesses"
                :key="business.slug"
                :business="business"
            />

            <p class="mt-2 text-[13px] text-tda-muted">
                Level usaha tertinggi kamu {{ member.highestLevel }}. Angka
                inilah yang dipakai untuk menentukan pengadaan mana yang bisa
                kamu ikuti.
            </p>
        </div>

        <EmptyState
            v-else
            title="Belum ada usaha terhubung"
            body="Usaha yang terdaftar di TDA Pusat akan muncul di sini setelah akun kamu diklaim."
            action-label="Hubungkan usaha"
            action-href="/demo"
        />
    </DemoLayout>
</template>
