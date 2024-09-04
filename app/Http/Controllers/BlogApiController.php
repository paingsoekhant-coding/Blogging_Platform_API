<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogApiController extends Controller
{
    //create blog api
    public function create_blog(Request $request)
    {
        $validator = $this->validateBlogData($request);

        if ($validator->fails()) {
            $data = [
                "error message" => $validator->messages()
            ];
            return response()->json($data, 400);
        }

        $blog_data = $this->getBlogData($request);

        Blog::create($blog_data);
        $response_message = "Blog Created Successfully";
        return response()->json(['status' => 201, 'message' => $response_message], 201);
    }

    //update blog api
    public function update_blog(Request $request, $id)
    {
        $blogId = $request->id;
        $item = Blog::where('id', $blogId)->first();

        if (isset($item)) {
            $newData = $this->getBlogData($request);
            $result = Blog::where('id', $blogId)->Update($newData);
            return response()->json(['status' => true, 'message' => "Update Success", 'Update Data' => $result], 200);
        }
        return response()->json(['status' => false, 'message' => "No Category Found"], 404);
    }

    //delete blog api
    public function delete_blog($id)
    {
        $blogId = Blog::where('id', $id)->exists();
        if (!$blogId) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        Blog::where('id', $id)->delete();
        return response()->json('Blog deleted successfully', 200);
    }

    // get single blog
    public function get_blog($id)
    {
        $blog = Blog::where('id', $id)->first();
        if (empty($blog)) {
            return response()->json("No Data Found", 404);
        }
        return response()->json($blog);
    }

    //get all blog
    public function read()
    {
        $all_blogData = Blog::all();
        return response()->json($all_blogData);
    }

    //filter blog
    public function filter_blog(Request $request)
    {

        $query = Blog::query();
        if ($request->filled('tags')) {
            $query->where('tags', 'like', '%' . $request->input('tags') . '%');
        }
        $blogs = $query->get();


        return response()->json($blogs);
    }

    private function getBlogData(Request $request)
    {
        return [

            'title' => $request->title,
            'content' => $request->content,
            'category' => $request->category,
            'tags' => $request->tags
        ];
    }

    private function validateBlogData(Request $request)
    {
        $blog_data = [
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'tags' => 'required',
        ];
        $validate_blog_data = Validator::make($request->all(), $blog_data);
        return $validate_blog_data;
    }
}
