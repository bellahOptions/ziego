<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (['orders', 'invoices', 'users'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->uuid('uuid')->nullable()->after('id');
            });
        }

        // Backfill existing rows, then enforce uniqueness (kept nullable at the
        // schema level to avoid requiring doctrine/dbal for a column ->change();
        // the model layer guarantees a uuid is always generated on creation).
        foreach (['orders', 'invoices', 'users'] as $table) {
            DB::table($table)->whereNull('uuid')->orderBy('id')->pluck('id')->each(function ($id) use ($table) {
                DB::table($table)->where('id', $id)->update(['uuid' => (string) Str::uuid()]);
            });

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->unique('uuid');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['orders', 'invoices', 'users'] as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropUnique([$table === 'users' ? 'users_uuid_unique' : "{$table}_uuid_unique"]);
                $blueprint->dropColumn('uuid');
            });
        }
    }
};
