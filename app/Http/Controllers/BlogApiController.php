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
            return response()->json($data);
        }

        $blog_data = $this->getBlogData($request);

        Blog::create($blog_data);
        $response_message = "Blog Created Successfully";
        return response()->json(['status' => 201, 'message' => $response_message], 201);
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
