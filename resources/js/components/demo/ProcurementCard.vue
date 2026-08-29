<script setup lang="ts">
import { CalendarClock } from '@lucide/vue';
import type { Procurement } from '@/types/demo';

defineProps<{ procurement: Procurement }>();
</script>

<template>
    <article
        class="rounded-2xl border border-tda-line bg-white p-4 shadow-[0_1px_2px_rgba(8,24,51,.04)]"
    >
        <div class="flex items-start justify-between gap-3">
            <h3 class="text-[15px] font-bold tracking-tight text-balance">
                {{ procurement.title }}
            </h3>
            <span class="shrink-0 text-sm font-bold text-tda-navy tabular-nums">
                {{ procurement.budget }}
            </span>
        </div>

        <p class="mt-1.5 flex items-center gap-1.5 text-[13px] text-tda-muted">
            <CalendarClock class="size-4 shrink-0" />
            Tutup {{ procurement.closesOn }} · {{ procurement.category }}
        </p>

        <button
            v-if="procurement.canBid"
            type="button"
            class="mt-4 flex min-h-11 w-full items-center justify-center rounded-xl bg-tda-lime px-5 text-sm font-semibold text-tda-navy-deep transition-opacity hover:opacity-90 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue sm:inline-flex sm:w-auto"
        >
            Kirim penawaran
        </button>
        <p v-else class="mt-4 text-[13px] text-tda-muted">
            Naikkan level usaha dulu untuk bisa mengirim penawaran.
        </p>
    </article>
</template>
