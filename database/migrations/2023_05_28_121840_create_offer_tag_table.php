<?php

use App\Models\Offer;
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
        Schema::create('offer_tag', function (Blueprint $table) {
            $table->foreignIdFor(Tag::class, "tag_id")->onDelete("cascade");
            $table->foreignIdFor(Offer::class, "offer_id")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_tag');
    }
};