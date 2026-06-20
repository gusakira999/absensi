<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        // Kolom khusus mahasiswa
            $table->string('nim', 20)->nullable()->unique()->after('role');
            $table->integer('angkatan')->nullable()->after('nim');
            $table->string('jurusan', 100)->nullable()->after('angkatan');
            
            // Kolom khusus dosen
            $table->string('nidn', 20)->nullable()->unique()->after('jurusan');
            $table->string('program_studi', 100)->nullable()->after('nidn');    //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'angkatan', 'jurusan', 'nidn', 'program_studi']);    //
        });
    }
};
