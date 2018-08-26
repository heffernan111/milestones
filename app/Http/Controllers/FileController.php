<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = DB::table('pages')->get();
        $banks = \App\User::with('files')->find(Auth::id());
        return view('myFiles',['banks' => $banks,'pages' => $pages]);
    }

    public function parseImport(Request $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $csv_data_file = \App\CsvData::create([
            'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
            'csv_header' => $request->has('header'),
            'csv_data' => json_encode($data)
        ]);
    $csv_data = array_slice($data, 0, 2);
    return view('import_fields', compact('csv_data', 'csv_data_file'));
    }

    public function processImport(Request $request)
    {
        
        $pages = DB::table('pages')->get();
        $data = \App\CsvData::find($request->csv_data_file_id);

        $csv_data = json_decode($data->csv_data, true);
        foreach ($csv_data as $row) {
            $file = new \App\File();
            foreach (config('app.db_fields') as $index => $field) {
                $file->$field = $row[$request->fields[$index]];
            }
            $file->user_id = Auth::user()->id;
            $file->save();
        }
        return redirect()->action('FileController@index')->with('message', 'Uploaded');
    }



}
