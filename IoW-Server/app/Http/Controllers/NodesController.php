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
        $cameras = $node->cameras()->paginate(10);
        $detailsHeader = ['Location', 'Status', 'Main Unit'];

        return view('nodes.show', [
            'title' => $node->name,
            'node' => $node,
            'sensors' => $sensors,
            'cameras' => $cameras,
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
            'location' => 'string|max:255|nullable',
            'status' => 'required|string|max:255',
            'main_unit' => 'string|max:255|nullable',
            'control' => 'boolean|nullable',
        ]);

        $node = Node::create($validated);

        return redirect()->route('nodes.index');
    }

    public function destroy(Node $node){
        $node->delete();
        return redirect()->route('nodes.index');
    }

    public function changeControl(Request $request)
    {
        $node = Node::find($request->node_id);
        $node->control = $request->control;
        $node->save();

        return response()->json(['success'=>'Status change successfully.']);

    }
}
