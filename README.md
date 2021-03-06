# Empetri - Youtube Video to MP3, MP4

## About Empetri

Empetri is a simple backend API build with Laravel. Convert Youtube Video to MP3, MP4. 
Thanks `https://yt1s.com/api/`

## Features

- Laravel Framework 8.74.0
- Standard Coding Style & Clean Code
- Convert Youtube to MP4, MP3


## Installation

- Run `git clone https://github.com/zuhrrl/Empetri.git`
- Move Project Dir `cd Empetri`
- Run `composer install`
- Edit `.env` and set your database connection details
- Run `php artisan migrate:fresh`

## Usage

- Endpoint: `/api/request/`
- Parameters: `youtube_url={video_url}&youtube_file_type={mp3/mp4}`
- Done

## Response
```
{
    "message": "Request success",
    "data": {
        "youtube_url": "Youtube Video URL",
        "youtube_video_id": "Youtube Video ID",
        "youtube_video_name": "Youtube Video Name",
        "youtube_file_type": "mp3/mp4",
        "youtube_download_path": "Download Link",
        "updated_at": "Time Updated",
        "created_at": "Time Created",
        "id": ID
    }
}
```