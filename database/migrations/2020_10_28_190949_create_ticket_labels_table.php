<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ticket_labels')) {
            Schema::create('ticket_labels', function (Blueprint $table) {
                $table->foreignId('ticket_id')->constrained('tickets');
                $table->foreignId('label_id')->constrained('labels');
                $table->primary(['ticket_id', 'label_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_labels');
    }
}
