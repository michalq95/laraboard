<?php

// use App\Models\Offer;
// use App\Models\Tag;
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('offer_tags', function (Blueprint $table) {
//             $table->id();
//             $table->foreignIdFor(Tag::class, "tag_id");
//             $table->foreignIdFor(Offer::class, "offer_id");
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('offer_tags');
//     }
// };