<?php

use HDSSolutions\Laravel\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreatePriceListTable extends Migration {

    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('price_lists', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->foreignTo('Currency');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('is_purchase')->default(false);
            $table->boolean('is_default')->default(false);
        });

        $schema->create('price_list_versions', function(Blueprint $table) {
            $table->id();
            $table->foreignTo('Company');
            $table->foreignTo('PriceList');
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamp('valid_from');
            $table->timestamp('valid_until')->nullable();
        });
    }

    public function down() {
        Schema::dropIfExists('price_list_versions');
        Schema::dropIfExists('price_lists');
    }

}
