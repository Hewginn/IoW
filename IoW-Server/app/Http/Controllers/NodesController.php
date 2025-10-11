<?php

namespace App\Http\Controllers;

use App\Models\Node;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $sensors = $node->sensors()->paginate(10);
        $detailsHeader = ['Location', 'Status', 'Main Unit'];
        $details = [$node->location, $node->status, $node->main_unit];

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
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:nodes',
            'password' => 'required|string|confirmed|min:8',
            'location' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'main_unit' => 'required|string|max:255',
        ]);

        $node = Node::create($validated);

        return redirect()->route('nodes.index');
    }

    public function edit(Node $node){
        //
    }

    public function update(Request $request, Node $node){
        //
    }

    public function token($token){
        if (!$token) {
            abort(404);
        }
        return view('nodes.token', [
            'title' => 'Token of Created Node',
            'token' => $token,
        ]);
    }
}
