<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function publicIndex()
    {
        $tags = Tag::where('accepted', true)->get(["name"]);
        return response(["tags" => $tags]);
    }
}