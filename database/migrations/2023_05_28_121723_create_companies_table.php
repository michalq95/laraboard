<?php

use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, "user_id");
            $table->string("name", 255);
            $table->string("slug", 255);
            $table->string("status", 10);
            $table->string("email")->unique();
            $table->text("description", 2000)->nullable();
            $table->string("address", 255)->nullable();
            $table->float("loc_x", 9, 6)->nullable();
            $table->float("loc_y", 9, 6)->nullable();
            $table->string("image", 255)->nullable();

            $table->timestamps();
            // $table->timestamp('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};