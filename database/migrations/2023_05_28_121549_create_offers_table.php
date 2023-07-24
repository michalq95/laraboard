<?php

use App\Models\Company;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string("title", 255);
            $table->string("slug", 255)->index("offers_slug_index");
            $table->text("description", 2000);
            $table->string("status")->index("offers_status_index");
            $table->integer("bracket_low")->nullable();
            $table->integer("bracket_high")->nullable();
            $table->timestamp('expire_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('icon')->nullable();
            $table->foreignIdFor(Company::class, "company_id");
            // $table->foreignIdFor(Tag::class);
            // $table->text('tags')->nullable();

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
        Schema::dropIfExists('offers');
    }
};