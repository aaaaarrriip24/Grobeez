<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleModel;
use Carbon\Carbon;
use DB;


class WelcomeController extends Controller
{
    public function index() {
        $data = ArticleModel::limit(3)->get();
        return view('welcome', compact('data'));
    }

    public function showImage($file) {
        $path = storage_public('app/article/'.$fileName);
        $file = File::get($path);

        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function show($id) {
        $data = DB::table('article')
        ->where('id', $id)
        ->first();
        $headerImage = asset('storage/'.$data->headerImage);
        $flyerImage = asset('storage/'.$data->flyerImage);

        return response()->json([
            "status"=>200,
            "data"=>$data,
            "headerImage"=>$headerImage,
            "flyerImage"=>$flyerImage
        ]);
    }
}
