<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use Illuminate\Http\Request;

class CameraController extends Controller
{
    # Show images and machine vision results of a camera
    public function show(Camera $camera){

        $images = $camera->images()->with('vision')->orderBy('created_at', 'desc')->paginate(10);
        $detailsHeader = ['Resolution', 'Status', 'Node'];
        $details = [$camera->resolution, $camera->status, $camera->node->name];

        return view('cameras.show', [
            'title' => $camera->name,
            'details' => $details,
            'node' => $camera->node,
            'detailsHeader' => $detailsHeader,
            'images' => $images,
        ]);
    }
}
