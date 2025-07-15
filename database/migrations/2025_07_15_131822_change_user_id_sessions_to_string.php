<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        \DB::statement('ALTER TABLE sessions ALTER COLUMN user_id TYPE VARCHAR(255) USING user_id::VARCHAR');
    }

    public function down()
    {
        // \DB::statement('ALTER TABLE sessions ALTER COLUMN user_id TYPE BIGINT USING user_id::BIGINT');
    }
};
