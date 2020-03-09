<?php

namespace App\Http\Controllers;

use App\Http\Requests\Video\Index;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Request;
use function GuzzleHttp\json_decode;
use PHPUnit\Framework\MockObject\Stub\Exception;
use App\Models\Video;

class VideoController extends Controller
{

        public function index(Index $request)
        {
            try{

                $params = [
                    'q'             => $request->get('term'),
                    'type'          => 'video',
                    'part'          => 'id, snippet',
                    'maxResults'    => 10
                ];

                if($request->get('pageToken')){

                    $results = Youtube::paginateResults($params, $request->get('pageToken'));

                }else{
                    $results = Youtube::searchAdvanced($params, true);

                }
                $results = json_decode(json_encode($results), true);
                foreach($results['results'] as $result){
                    Video::updateOrCreate(['id.videoId' => $result['id']['videoId']], $result);
                }

                return response()->json($results);
            }catch(Exception $e){
                Log::error($e->getMessage());
                return response()->json(['message'=> 'Intern Server Error', 500]);
            }




        }

        ##TODO
        public function store(Request $request)
        {

        }

        public function show($id)
        {
            $results = Youtube::getVideoInfo($id);
            if($results){
                return response()->json($results);
            }else{
                return response()->json(["error" => "Não foi possível encontrar o video indicado" ], 404);
            }
        }

        ##TODO
        public function update(Request $request, $id)
        {

        }


        ##TODO
        public function destroy($id)
        {
        }


}
