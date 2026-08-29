<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { CheckCircle2, ChevronRight, Clock } from '@lucide/vue';
import type { AttentionItem } from '@/types/demo';

defineProps<{ item: AttentionItem }>();

const toneClass: Record<AttentionItem['tone'], string> = {
    warn: 'border-tda-warn-line bg-tda-warn-bg text-tda-warn-ink',
    ok: 'border-tda-ok-line bg-tda-ok-bg text-tda-ok-ink',
};
</script>

<template>
    <component
        :is="item.href ? Link : 'div'"
        :href="item.href ?? undefined"
        class="flex items-start gap-3 rounded-2xl border p-3.5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-tda-blue"
        :class="[toneClass[item.tone], item.href && 'min-h-11']"
    >
        <component
            :is="item.tone === 'warn' ? Clock : CheckCircle2"
            class="mt-0.5 size-[18px] shrink-0"
        />
        <div class="min-w-0 flex-1">
            <p class="text-[13px] font-semibold">{{ item.title }}</p>
            <p class="mt-0.5 text-[13px] text-tda-muted">{{ item.body }}</p>
        </div>
        <ChevronRight v-if="item.href" class="mt-0.5 size-4 shrink-0" />
    </component>
</template>
