<?php

namespace App\Http\Controllers;

use App\Models\DataType;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function index(){
        $data_types = DataType::query()->get();

        return view('data.index', [
            'title' => 'Data',
            'data_types' => $data_types,
        ]);
    }

    public function show(DataType $data_type){
        $datas = $data_type->messages()->orderBy('created_at', 'desc')->paginate(10);

        return view('data.show', [
            'title' => ucfirst($data_type->data_type),
            'datas' => $datas,
        ]);
    }
}
