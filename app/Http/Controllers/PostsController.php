<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PostModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        //
        $posts = PostModel::with('category', 'user')->orderBy('created_at', 'desc')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'image' => url('images/' . $post->image),
                'category' => $post->category->name,
                'user' => $post->user->name,
                'created_at' => Carbon::parse($post->created_at)->diffForHumans()
            ];
        });
        return response()->json(
            [
                'status' => 'success',
                'data' => $posts
            ],
            200
        );
    }
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'category_id' => 'required|string|exists:categories,id'
        ];
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $valid->errors()
            ], 422);
        }

        $post = new PostModel();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->user_id = Auth::guard('api')->user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $post->image = $name;
        }
        $post->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = PostModel::with('category', 'user')->find($id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $post->image,
                'category' => $post->category->name,
                'user' => $post->user->name,
                'created_at' => $post->created_at
            ]
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $post = PostModel::find($id);
        if ($post->user_id !== Auth::guard('api')->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to update this post'
            ], 401);
        }
        $rules = [
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'category_id' => 'required|string|exists:categories,id'
        ];
        $valid = Validator::make($request->all(), $rules);
        if ($valid->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $valid->errors()
            ], 422);
        }
        $post->title = $request->title;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $post->image = $name;
        }
        $post->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = PostModel::find($id);
        if ($post->user_id !== Auth::guard('api')->user()->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are not authorized to delete this post'
            ], 401);
        }
        if ($post->image) {
            $image_path = 'images/' . $post->image;
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        $post->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully'
        ], 200);
    }

    public function myPosts(Request $request)
    {
        $posts = PostModel::with('category', 'user')->where('user_id', Auth::guard('api')->user()->id)->orderBy('created_at', 'desc')->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'image' => url('images/' . $post->image),
                'category' => $post->category->name,
                'user' => $post->user->name,
                'created_at' => Carbon::parse($post->created_at)->diffForHumans()
            ];
        });
        return response()->json(
            [
                'status' => 'success',
                'data' => $posts
            ],
            200
        );
    }
}
