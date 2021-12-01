<?php

namespace App\Http\Controllers;

use App\Models\YoutubeRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class YoutubeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $youtubeRequest = YoutubeRequest::orderBy('time', 'DESC')->get();
        $response = [
            'message' => 'List youtube request made by users',
            'data' => $youtubeRequest
        ];

        return response()->json($response, Response::HTTP_OK);
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        // get download url path
        $youtube_download_path = $this->getYoutubeDownloadPath($request->youtube_url, $request->youtube_file_type);
        $youtube_download_path = json_decode($youtube_download_path);
        $validator = Validator::make($request->all(), [
            'youtube_url' => ['required'],
            'youtube_file_type' => ['required', 'in:mp3, mp4']

        ]);


        $requestParams = [
            "youtube_url" => $request->youtube_url,
            "youtube_video_id" => $youtube_download_path->youtube_video_id,
            "youtube_video_name" => $youtube_download_path->youtube_video_name,
            "youtube_file_type" => $request->youtube_file_type,
            "youtube_download_path" => $youtube_download_path->youtube_download_path
        ];
            

        if($validator->fails()) {
            return response()->json($validator->errors(), 
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $youtubeRequest = YoutubeRequest::create($requestParams);
            $response = [
                'message' => 'Request success',
                'data' => $youtubeRequest
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed ' . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $youtubeRequest = YoutubeRequest::where('youtube_video_id',$id)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'youtube_url' => ['required'],
            'youtube_file_type' => ['required', 'in:mp3, mp4']

        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $youtubeRequest->update($request->all());
            $response = [
                'message' => 'Request Updated',
                'data' => $youtubeRequest
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed ' . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getYoutubeDownloadPath($youtube_url, $type) {
        $base_api = 'https://yt1s.com/api/';
        // search youtube video by id (return json)
        $response = Http::asForm()->post($base_api . 'ajaxSearch/index', [
            'q' => $youtube_url,
            'vt' => $type
        ]);
        $response = json_decode($response);
        $k_video = $response->links->mp3->mp3128->k;

        // convert
        $response = Http::asForm()->post($base_api . 'ajaxConvert/convert', [
            'vid' => $response->vid,
            'k' => $k_video
        ]);
        $response = json_decode($response);
        $video_name = $response->title;
        $video_id = $response->vid;
        $video_dlink = $response->dlink . '/dsfsdfsdffds';
        return json_encode([
            'youtube_video_name' => $video_name,
            'youtube_video_id' => $video_id,
            'youtube_download_path' => $video_dlink
        ]);
    }
}
