<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('support_messages', function (Blueprint $table) {
            $table->string('status')->default('new')->after('message');
            $table->text('admin_reply')->nullable()->after('status');
            $table->text('admin_note')->nullable()->after('admin_reply');
            $table->timestamp('replied_at')->nullable()->after('admin_note');
        });
    }

    public function down(): void
    {
        Schema::table('support_messages', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_reply', 'admin_note', 'replied_at']);
        });
    }
};