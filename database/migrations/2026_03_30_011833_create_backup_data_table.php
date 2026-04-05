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
    Schema::create('backup_data', function (Blueprint $table) {
        $table->id();
        $table->integer('original_id')->nullable();
        $table->string('table_name')->nullable();
        $table->longText('data_backup')->nullable();
        $table->string('deleted_by')->nullable();
        $table->timestamp('deleted_at')->useCurrent();
        $table->dateTime('restored_at')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('backup_data');
}
};
