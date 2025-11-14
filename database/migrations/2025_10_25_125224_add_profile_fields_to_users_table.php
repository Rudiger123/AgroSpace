<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('email');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('region')->nullable()->after('bio');
            $table->string('city')->nullable()->after('region');
            $table->string('activity')->nullable()->after('city');
            $table->string('phone')->nullable();
            $table->enum('status', ['active', 'suspended', 'banned'])->default('active');
            $table->timestamp('last_active_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['avatar', 'bio', 'location', 'activity','phone','status']);
        });
    }
};
