/**
 * Bentuk data demo TDA Connect Depok.
 *
 * Level dikirim sebagai kode (`L1`..`L7`) saja. Nama level belum diputuskan
 * pengurus, jadi tidak ada field nama di sini — lihat CLAUDE.md, keputusan
 * terbuka #2.
 */

export type LevelCode = 'L1' | 'L2' | 'L3' | 'L4' | 'L5' | 'L6' | 'L7';

/** Keadaan sebuah bisnis terhadap pengajuan naik level. */
export type BusinessState = 'ready' | 'review' | 'cooldown';

export interface Member {
    name: string;
    passport: string;
    region: string;
    status: string;
    email: string;
    highestLevel: LevelCode;
    businessCount: number;
}

export interface Business {
    slug: string;
    name: string;
    industry: string;
    level: LevelCode;
    state: BusinessState;
    /** Satu baris konteks, sudah dalam bahasa member. */
    note: string;
    /** Tanggal konkret, bukan hitungan mundur. Hanya untuk state `cooldown`. */
    reapplyOn: string | null;
}

export interface LadderStep {
    level: LevelCode;
    state: 'done' | 'current' | 'next' | 'locked';
    note: string;
}

export interface ChecklistItem {
    question: string;
    answered: boolean | null;
    /** Bantuan edukatif, tampil saat jawabannya "Tidak". */
    help: string | null;
}

export interface Procurement {
    slug: string;
    title: string;
    budget: string;
    closesOn: string;
    category: string;
    /** Sudah dihitung backend dari level bisnis tertinggi milik member. */
    canBid: boolean;
}

export interface AttentionItem {
    tone: 'warn' | 'ok';
    title: string;
    body: string;
    href: string | null;
}

export interface VerificationItem {
    business: string;
    member: string;
    from: LevelCode;
    to: LevelCode;
    waitingDays: number;
    status: string;
    needsManualReview: boolean;
}
