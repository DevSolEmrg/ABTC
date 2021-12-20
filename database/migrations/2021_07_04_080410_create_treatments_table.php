<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_history_id')->constrained('patient_histories')->cascadeOnDelete();
            //$table->enum('category', ['1', '2', '3']);
            //$table->boolean('is_washed')->default(true);
            //$table->date('rig_date');
            //$table->string('route');
            $table->string('designated_day');
            $table->date('date');
            $table->string('time');
            $table->foreignId('vaccine_id')->constrained('vaccines');
            //$table->text('physician_order');//todo
            //$table->text('nurce_notes');//todo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatments');
    }
}
