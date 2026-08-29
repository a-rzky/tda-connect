<script setup lang="ts">
import type { LevelCode } from '@/types/demo';

/**
 * Menampilkan kode level saja, tanpa nama.
 *
 * Nama L1-L7 belum diputuskan pengurus (CLAUDE.md, keputusan terbuka #2), jadi
 * komponen ini sengaja tidak menerima prop nama — supaya nama tebakan tidak
 * bisa masuk lewat sini.
 */
withDefaults(
    defineProps<{
        level: LevelCode;
        tone?: 'active' | 'neutral' | 'muted';
        size?: 'sm' | 'lg';
    }>(),
    { tone: 'neutral', size: 'sm' },
);

const toneClass: Record<string, string> = {
    active: 'bg-tda-lime text-tda-navy-deep',
    neutral: 'bg-tda-surface-alt text-tda-navy',
    muted: 'border border-tda-line bg-white text-tda-muted',
};
</script>

<template>
    <span
        class="inline-flex shrink-0 items-center justify-center rounded-full font-bold tabular-nums"
        :class="[
            toneClass[tone],
            size === 'lg'
                ? 'min-w-11 px-3 py-1.5 text-base'
                : 'min-w-9 px-2.5 py-1 text-xs',
        ]"
    >
        <span class="sr-only">Level usaha </span>{{ level }}
    </span>
</template>
