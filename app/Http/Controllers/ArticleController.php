<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\ArticleModel;
use Carbon\Carbon;
use DataTables;
use DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = ArticleModel::all();
        return view('admin/article/index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewImage($fileName)
    {
        $path = storage_public('app/article/'.$fileName);
        $file = File::get($path);

        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('headerImage');
        $nama_file = time()."_".$file->getClientOriginalName();
        Storage::disk('local')->put('/public/'.$nama_file, File::get($file));
        // $file->move(public_path().'/assets/images/articles/', $nama_file);
        $name = $nama_file;

        $file2 = $request->file('flyerImage');
        $nama_file2 = time()."_".$file2->getClientOriginalName();
        Storage::disk('local')->put('/public/'.$nama_file2, File::get($file2));
        // $file2->move(public_path().'/assets/images/articles/', $nama_file2);
        $name2 = $nama_file2;

        ArticleModel::insert([
            'title' => $request->title,
            'paragraph' => $request->paragraph,
            'headerImage' => $name,
            'flyerImage' => $name2,
            'created_at' => Carbon::now()->format('Y-m-d h:i:s')
        ]);
        Alert::toast('Succesfully Add Article', 'success');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('article')
        ->where('id', $id)
        ->first();

        return response()->json([
            "status"=>200,
            "data"=>$data
        ]);
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
    public function update(Request $request)
    {
        if(!empty($request->headerImage)){
            $file = $request->file('headerImage');
            $nama_file = time()."_".$file->getClientOriginalName();
            $file->move(public_path().'/assets/images/articles/', $nama_file);
            $name = $nama_file;
        }

        if(!empty($request->flyerImage)){
            $file2 = $request->file('flyerImage');
            $nama_file2 = time()."_".$file2->getClientOriginalName();
            $file2->move(public_path().'/assets/images/articles/', $nama_file2);
            $name2 = $nama_file2;
        }

        ArticleModel::where('id', $request->id)
        ->update([
            'title' => $request->title,
            'paragraph' => $request->paragraph,
            'headerImage' => (!empty($request->headerImage) ? $name : $request->oldheaderImage),
            'flyerImage' => (!empty($request->flyerImage) ? $name2 : $request->oldflyerImage),
        ]);
        Alert::toast('Update Article Succesfully!', 'success');
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=ArticleModel::find($id);
        $data->delete();

        Alert::toast('Destroy Article Succesfully!', 'error');
        return redirect()->back();

    }
}
