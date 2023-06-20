<?php

use App\Models\Company;
use App\Models\Offer;
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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->text("application", 2000)->nullable();
            $table->string("resume", 255)->nullable();
            $table->tinyInteger("status")->nullable();
            $table->foreignIdFor(User::class, "user_id")->onDelete("cascade");
            $table->foreignIdFor(Offer::class, "offer_id")->onDelete("cascade");
            // $table->foreignIdFor(Company::class, "company_id")->onDelete("cascade");

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
        Schema::dropIfExists('applications');
    }
};