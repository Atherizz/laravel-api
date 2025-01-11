<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
     /**
     * index
     *
     * @return PostResource
     */
    public function index ()
    {
        $posts = Post::latest()->paginate(5);
        return new PostResource(true, 'List Data Posts', $posts);
    }

    public function store(Request $request) 
    {
        $validation =  Validator::make($request->all(),[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'content' => 'required'
        ]);

        if($validation->fails()) {
            return response()->json($validation->errors(), 422);    
        }

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        $post = Post::create([
        'image'     => $image->hashName(),
        'title'     => $request->title,
        'content'   => $request->content,
        ]);

        return new PostResource(true, 'Post Data has ben added!', $post);

     


    }
}
