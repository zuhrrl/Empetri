<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYoutubeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('youtube_requests', function (Blueprint $table) {
            $table->id();
            $table->string('youtube_url');
            $table->string('youtube_video_id')->default('');
            $table->string('youtube_video_name')->default('');
            $table->string('youtube_download_filename')->default('');
            $table->longText('youtube_download_path')->default('');
            $table->enum('youtube_file_type', ['mp3', 'mp4']);
            $table->timestamp('time')->default(now());
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
        Schema::dropIfExists('youtube_requests');
    }
}
