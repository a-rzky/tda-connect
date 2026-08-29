<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import EmptyState from '@/components/demo/EmptyState.vue';
import ProcurementCard from '@/components/demo/ProcurementCard.vue';
import DemoLayout from '@/layouts/DemoLayout.vue';
import type { LevelCode, Member, Procurement } from '@/types/demo';

const props = defineProps<{
    member: Member;
    procurements: Procurement[];
    minLevel: LevelCode;
}>();

const eligible = props.procurements.some((item) => item.canBid);
</script>

<template>
    <Head title="Pengadaan" />

    <DemoLayout
        title="Pengadaan"
        :subtitle="`${procurements.length} pengadaan terbuka untuk TDA Depok`"
    >
        <div class="flex flex-col gap-5">
            <p
                class="rounded-xl p-3 text-[13px]"
                :class="
                    eligible
                        ? 'bg-tda-ok-bg text-tda-ok-ink'
                        : 'bg-tda-warn-bg text-tda-warn-ink'
                "
            >
                <template v-if="eligible">
                    Level usaha tertinggi kamu {{ member.highestLevel }} — sudah
                    memenuhi syarat minimum {{ minLevel }} untuk mengirim
                    penawaran.
                </template>
                <template v-else>
                    Butuh level usaha {{ minLevel }} untuk mengirim penawaran.
                    Level tertinggi kamu saat ini {{ member.highestLevel }}.
                </template>
            </p>

            <div v-if="procurements.length" class="flex flex-col gap-3">
                <ProcurementCard
                    v-for="procurement in procurements"
                    :key="procurement.slug"
                    :procurement="procurement"
                />
            </div>

            <EmptyState
                v-else
                title="Belum ada pengadaan terbuka"
                body="Pengadaan baru dari sesama anggota TDA Depok akan muncul di sini. Kamu juga bisa memposting kebutuhan usahamu sendiri."
                action-label="Posting pengadaan"
                action-href="/demo/pengadaan"
            />

            <p class="text-[13px] text-tda-muted">
                Jumlah penawaran yang masuk disembunyikan selama pengadaan masih
                terbuka.
            </p>
        </div>
    </DemoLayout>
</template>
