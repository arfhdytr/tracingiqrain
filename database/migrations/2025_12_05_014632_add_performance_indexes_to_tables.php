<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan indexes untuk meningkatkan performa query database.
     */
    public function up(): void
    {
        // 1. hasil_games - Tabel paling sering di-query
        Schema::table('hasil_games', function (Blueprint $table) {
            // Index untuk filter tanggal (digunakan di laporan harian/mingguan)
            $table->index('dimainkan_at', 'idx_hasil_games_dimainkan_at');

            // Composite index untuk query per murid dengan filter tanggal
            $table->index(['murid_id', 'dimainkan_at'], 'idx_hasil_games_murid_tanggal');

            // Composite index untuk statistik game per jenis
            $table->index(['jenis_game_id', 'murid_id'], 'idx_hasil_games_jenis_murid');

            // Index untuk aggregasi poin (SUM, ORDER BY)
            $table->index('total_poin', 'idx_hasil_games_total_poin');
        });

        // 2. progress_moduls - Tracking progress siswa
        Schema::table('progress_moduls', function (Blueprint $table) {
            // Index untuk filter status
            $table->index('status', 'idx_progress_moduls_status');

            // Composite index untuk hitung modul selesai per murid (paling sering digunakan)
            $table->index(['murid_id', 'status'], 'idx_progress_moduls_murid_status');

            // Index untuk tanggal selesai (laporan temporal)
            $table->index('tanggal_selesai', 'idx_progress_moduls_tanggal_selesai');
        });

        // 3. murids - Tabel sentral relasi murid
        Schema::table('murids', function (Blueprint $table) {
            // Index untuk filter preferensi
            $table->index('preferensi_terisi', 'idx_murids_preferensi_terisi');

            // Index untuk ordering by creation date
            $table->index('created_at', 'idx_murids_created_at');

            // Composite index untuk query murid per mentor dengan ordering
            $table->index(['mentor_id', 'created_at'], 'idx_murids_mentor_created');
        });

        // 4. leaderboards - Performance critical untuk ranking
        Schema::table('leaderboards', function (Blueprint $table) {
            // Index untuk ordering global ranking
            $table->index('ranking_global', 'idx_leaderboards_ranking_global');

            // Index untuk ordering by total poin (refresh rankings)
            $table->index('total_poin_semua_game', 'idx_leaderboards_total_poin');

            // Composite index untuk leaderboard per mentor
            $table->index(['mentor_id', 'total_poin_semua_game'], 'idx_leaderboards_mentor_poin');
        });

        // 5. permintaan_bimbingans - Workflow approval
        Schema::table('permintaan_bimbingans', function (Blueprint $table) {
            // Index untuk filter status
            $table->index('status', 'idx_permintaan_bimbingans_status');

            // Composite index untuk pending requests per mentor
            $table->index(['mentor_id', 'status'], 'idx_permintaan_bimbingans_mentor_status');

            // Index untuk ordering by tanggal permintaan
            $table->index('tanggal_permintaan', 'idx_permintaan_bimbingans_tanggal');

            // Composite index untuk workflow queries
            $table->index(['status', 'tanggal_permintaan'], 'idx_permintaan_bimbingans_status_tanggal');
        });

        // 6. mentors - Approval workflow
        Schema::table('mentors', function (Blueprint $table) {
            // Index untuk filter status approval
            $table->index('status_approval', 'idx_mentors_status_approval');

            // Index untuk ordering by creation
            $table->index('created_at', 'idx_mentors_created_at');

            // Composite index untuk approval workflow
            $table->index(['status_approval', 'created_at'], 'idx_mentors_status_created');
        });

        // 7. moduls - Content ordering
        Schema::table('moduls', function (Blueprint $table) {
            // Composite index untuk display modul berurutan per materi
            $table->index(['materi_id', 'urutan'], 'idx_moduls_materi_urutan');
        });

        // 8. materi_pembelajarans - Content ordering
        Schema::table('materi_pembelajarans', function (Blueprint $table) {
            // Composite index untuk display materi berurutan per tingkatan
            $table->index(['tingkatan_id', 'urutan'], 'idx_materi_tingkatan_urutan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Menghapus semua indexes yang ditambahkan
     */
    public function down(): void
    {
        // Drop indexes in reverse order

        Schema::table('materi_pembelajarans', function (Blueprint $table) {
            $table->dropIndex('idx_materi_tingkatan_urutan');
        });

        Schema::table('moduls', function (Blueprint $table) {
            $table->dropIndex('idx_moduls_materi_urutan');
        });

        Schema::table('mentors', function (Blueprint $table) {
            $table->dropIndex('idx_mentors_status_created');
            $table->dropIndex('idx_mentors_created_at');
            $table->dropIndex('idx_mentors_status_approval');
        });

        Schema::table('permintaan_bimbingans', function (Blueprint $table) {
            $table->dropIndex('idx_permintaan_bimbingans_status_tanggal');
            $table->dropIndex('idx_permintaan_bimbingans_tanggal');
            $table->dropIndex('idx_permintaan_bimbingans_mentor_status');
            $table->dropIndex('idx_permintaan_bimbingans_status');
        });

        Schema::table('leaderboards', function (Blueprint $table) {
            $table->dropIndex('idx_leaderboards_mentor_poin');
            $table->dropIndex('idx_leaderboards_total_poin');
            $table->dropIndex('idx_leaderboards_ranking_global');
        });

        Schema::table('murids', function (Blueprint $table) {
            $table->dropIndex('idx_murids_mentor_created');
            $table->dropIndex('idx_murids_created_at');
            $table->dropIndex('idx_murids_preferensi_terisi');
        });

        Schema::table('progress_moduls', function (Blueprint $table) {
            $table->dropIndex('idx_progress_moduls_tanggal_selesai');
            $table->dropIndex('idx_progress_moduls_murid_status');
            $table->dropIndex('idx_progress_moduls_status');
        });

        Schema::table('hasil_games', function (Blueprint $table) {
            $table->dropIndex('idx_hasil_games_total_poin');
            $table->dropIndex('idx_hasil_games_jenis_murid');
            $table->dropIndex('idx_hasil_games_murid_tanggal');
            $table->dropIndex('idx_hasil_games_dimainkan_at');
        });
    }
};
