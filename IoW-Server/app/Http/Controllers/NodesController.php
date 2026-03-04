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
            'analyze_images' => 'boolean|required',
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

    public function edit(Node $node){
        return view('nodes.edit', [
            'title' => 'Edit Node',
            'node' => $node,
        ]);
    }

    public function update(Request $request, Node $node)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'location' => ['nullable', 'string', 'max:255'],
            'main_unit' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:Online,Offline,In Development,Faulty'],
            'control' => ['sometimes', 'boolean'],
            'analyze_images' => ['sometimes', 'boolean'],
        ]);

        $node->name = $validated['name'];
        if (!empty($validated['password'])) {
            $node->password = bcrypt($validated['password']);
        }
        $node->location = $validated['location'] ?? null;
        $node->main_unit = $validated['main_unit'] ?? null;
        $node->status = $validated['status'];
        $node->control = $request->has('control') ? true : false;
        $node->analyze_images = $request->has('analyze_images') ? true : false;

        $node->save();

        return redirect()->route('nodes.index')->with('success', 'Node updated successfully.');
    }
}
