<?php

use HDSSolutions\Finpar\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('families', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->string('name');
            $table->priority()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('families');
    }

}
