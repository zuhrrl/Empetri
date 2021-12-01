<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoutubeRequest extends Model
{
    use HasFactory;

    protected $fillable = ['youtube_url', 'youtube_video_id', 'youtube_video_name', 'youtube_download_filename', 'youtube_download_path', 'youtube_file_type', 'time'];
}
