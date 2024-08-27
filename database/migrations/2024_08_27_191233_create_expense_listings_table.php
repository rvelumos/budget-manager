<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
        {
            Schema::create('expense_listings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('expense_listings');
        }
};
