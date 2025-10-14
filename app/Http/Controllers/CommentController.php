<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $home_id)
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบก่อนทำการคอมเมนต์');
        }

        // Validate the request
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the home post by ID
        $home = Home::findOrFail($home_id);

        // สร้างคอมเมนต์ใหม่
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->home_id = $home->id;
        $comment->user_id = Auth::id();  // บันทึก user ที่คอมเมนต์
        $comment->save();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('comment_images', 'public');
            $comment->image = $imagePath;
        }

        // Save the comment
        $comment->save();

        // Redirect to the post with success message
        return redirect()->route('show', ['home' => $home_id])->with('success', 'คอมเม้นต์ของคุณถูกเพิ่มเรียบร้อย');
    }
}
