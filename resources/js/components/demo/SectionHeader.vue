<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from '@lucide/vue';

defineProps<{
    title: string;
    /** Tautan "lihat semua". Tanpa ini, header tampil polos. */
    href?: string;
    linkLabel?: string;
}>();
</script>

<template>
    <div class="mb-3 flex items-baseline justify-between gap-4">
        <h2 class="text-[15px] font-bold tracking-tight">{{ title }}</h2>
        <Link
            v-if="href"
            :href="href"
            class="inline-flex shrink-0 items-center gap-0.5 text-[13px] font-semibold text-tda-blue focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
        >
            {{ linkLabel ?? 'Lihat semua' }}
            <ChevronRight class="size-4" />
        </Link>
    </div>
</template>
