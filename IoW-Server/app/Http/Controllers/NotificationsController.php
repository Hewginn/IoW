<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    function index(){
        return view('notifications.index', [
            'title' => 'Notifications',
        ]);
    }
}
