<script setup lang="ts">
withDefaults(
    defineProps<{
        tone?: 'warn' | 'ok' | 'neutral';
    }>(),
    { tone: 'neutral' },
);

const toneClass: Record<string, string> = {
    warn: 'bg-tda-warn-bg text-tda-warn-ink',
    ok: 'bg-tda-ok-bg text-tda-ok-ink',
    neutral: 'bg-tda-surface-alt text-tda-navy',
};
</script>

<template>
    <span
        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold"
        :class="toneClass[tone]"
    >
        <slot />
    </span>
</template>
