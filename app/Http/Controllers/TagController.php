<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagController extends Controller
{
    public function publicIndex()
    {
        $tags = Cache::remember('tags', 24 * 60 * 60, function () {
            return Tag::where('accepted', true)->get(["name"]);
        });
        return response(["tags" => $tags]);
    }
}