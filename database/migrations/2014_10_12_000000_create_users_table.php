<?php

use App\Enums\GeneralStatusEnum;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->onDelete('cascade');;
            $table->foreignId('commune_id')->constrained()->onDelete('cascade');;
            $table->string('dni', 45);
            $table->string('name', 45);
            $table->string('last_name', 45);
            $table->string('address')->nullable();
            $table->string('email', 120)->unique();
            $table->string('password');
            $table->enum(
                'status',
                [
                    GeneralStatusEnum::Active,
                    GeneralStatusEnum::Inactive
                ]
            )->default(GeneralStatusEnum::Active);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
