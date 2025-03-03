<?php
// Migration to users attribute to users table
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
        // Adding role, birthdate, address, city and expired_date
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->default(2); // 1=role 1, 2 = user
            $table->date('birthdate')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('photo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('birthdate');
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('expired_date');
            $table->dropColumn('photo');
        });
    }
};
