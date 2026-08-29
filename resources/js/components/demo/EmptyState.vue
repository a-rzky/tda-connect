<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

/**
 * Empty state selalu membawa ajakan bertindak, bukan kalimat "Tidak ada data".
 */
defineProps<{
    title: string;
    body: string;
    actionLabel?: string;
    actionHref?: string;
}>();
</script>

<template>
    <div
        class="rounded-2xl border border-dashed border-tda-line bg-white px-5 py-8 text-center"
    >
        <p class="text-[15px] font-bold tracking-tight">{{ title }}</p>
        <p class="mx-auto mt-1.5 max-w-sm text-[13px] text-tda-muted">
            {{ body }}
        </p>
        <Link
            v-if="actionHref && actionLabel"
            :href="actionHref"
            class="mt-4 inline-flex min-h-11 items-center justify-center rounded-xl bg-tda-navy px-5 text-sm font-semibold text-white transition-colors hover:bg-tda-navy-deep focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
        >
            {{ actionLabel }}
        </Link>
    </div>
</template>
