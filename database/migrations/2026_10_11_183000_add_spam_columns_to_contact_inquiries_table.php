<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Held-back inquiries stay in the table with a reason instead of being lost.
     */
    public function up(): void
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('locale');
            $table->string('spam_reason', 40)->nullable()->index()->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('contact_inquiries', function (Blueprint $table) {
            $table->dropIndex(['spam_reason']);
            $table->dropColumn(['ip_address', 'spam_reason']);
        });
    }
};
