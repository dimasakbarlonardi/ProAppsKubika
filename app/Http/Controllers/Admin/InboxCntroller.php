<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InboxCntroller extends Controller
{
    public function index()
    {
        return view('AdminSite.Inbox.index');
    }
}
