<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('datastream_posts', function (Blueprint $table) {
            $table->longText('body_html')->nullable()->after('body');
            $table->jsonb('body_json')->nullable()->after('body_html');
        });

        DB::table('datastream_posts')
            ->whereNull('body_html')
            ->update([
                'body_html' => DB::raw('body'),
            ]);
    }

    public function down(): void
    {
        Schema::table('datastream_posts', function (Blueprint $table) {
            $table->dropColumn(['body_html', 'body_json']);
        });
    }
};