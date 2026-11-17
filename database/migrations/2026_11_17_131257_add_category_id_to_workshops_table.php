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
    Schema::table('workshops', function (Blueprint $table) {
        // Tambahkan foreign key yang terhubung ke tabel categories
        // onDelete('cascade') artinya jika kategori dihapus, workshop terkait ikut terhapus (atau 'set null')
        $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('workshops', function (Blueprint $table) {
        $table->dropForeign(['category_id']);
        $table->dropColumn('category_id');
    });
}
};
