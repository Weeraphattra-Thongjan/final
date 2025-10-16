<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * เพิ่มคอมเมนต์ใหม่ใต้โพสต์
     */
    public function store(Request $request, $home_id)
    {
        // ต้องล็อกอินก่อนถึงคอมเมนต์ได้
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบก่อนทำการคอมเมนต์');
        }

        // ตรวจสอบข้อมูล
        $validated = $request->validate([
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // หาโพสต์ที่ต้องการคอมเมนต์
        $home = Home::findOrFail($home_id);

        // สร้างคอมเมนต์ใหม่
        $comment = new Comment();
        $comment->content = $validated['content'];
        $comment->home_id = $home->id;
        $comment->user_id = Auth::id();

        // ถ้ามีรูปแนบมา
        if ($request->hasFile('image')) {
            $comment->image = $request->file('image')->store('comment_images', 'public');
        }

        $comment->save();

        // กลับไปยังหน้าโพสต์
        return redirect()
            ->route('posts.show', ['home' => $home_id])
            ->with('success', 'คอมเมนต์ถูกเพิ่มเรียบร้อยแล้ว!');
    }

    /**
     * ลบคอมเมนต์ (เฉพาะเจ้าของเท่านั้น)
     */
    public function destroy(Home $home, Comment $comment)
    {
        // ป้องกันคนอื่นมาลบ
        abort_unless(Auth::id() === $comment->user_id, 403);

        // ตรวจสอบว่าคอมเมนต์นี้อยู่ใต้โพสต์จริง ๆ
        if ($comment->home_id !== $home->id) {
            abort(404);
        }

        $comment->delete();

        return redirect()
            ->route('posts.show', ['home' => $home->id])
            ->with('success', 'ลบคอมเมนต์เรียบร้อยแล้ว');
    }
}
