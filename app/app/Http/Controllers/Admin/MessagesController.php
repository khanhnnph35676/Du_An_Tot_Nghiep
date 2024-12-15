<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessOrder;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    //deleteMessage
    public function deleteMessage($id){
        $mes = MessOrder::find($id); // Corrected method name from 'finde' to 'find'
        $mes->delete();
        return redirect()->back();
    }
}
