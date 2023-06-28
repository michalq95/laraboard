<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        // if (!Auth::user()->isMod()) abort(403, "Unauthorized");

        return response(Tag::all());
    }
    public function accept(Request $request)
    {
        // if (!Auth::user()->isMod()) abort(403, "Unauthorized");
        $tagIds = $request->input('tag_ids');
        Tag::whereIn('id', $tagIds)->update(['accepted' => true]);
        Cache::forget("tags");
        return response($tagIds);
    }
}
