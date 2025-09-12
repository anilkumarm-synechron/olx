<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Neutralized legacy default users/password_resets/sessions migration.
// Consolidated schema defined in 2025_09_12_000000_initial_schema.php
return new class extends Migration {
    public function up(): void {}
    public function down(): void {}
};
