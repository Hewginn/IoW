<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;

class NodesController extends Controller
{
    public function index(){
        $nodes = Node::query()->paginate(10);

        return view('nodes.index', [
            'title' => 'Nodes',
            'nodes' => $nodes,
        ]);
    }

    public function show(Node $node){

        $sensors = $node->sensors()->get();
        $detailsHeader = ['Location', 'Status', 'Main Unit', 'Key'];
        $details = [$node->location, $node->status, $node->main_unit, $node->key];

        return view('nodes.show', [
            'title' => $node->name,
            'detailsHeader' => $detailsHeader,
            'details' => $details,
            'sensors' => $sensors,
        ]);
    }

    public function create(){
        return view('nodes.create', [
           'title' => 'Create Node',
        ]);
    }

    public function store(Request $request){
        //
    }

    public function edit(Node $node){
        //
    }

    public function update(Request $request, Node $node){
        //
    }
}
