<?php

namespace App\Http\Controllers;

use App\Models\Comment; 
use Illuminate\Http\Request;

class CommentController extends Controller
{
    

    public function store(Request $request)
    {
        $request->validate([
            "description" =>"required",
            "user_id" => "required",
            "post_id" => "required",
            "parent_id" => "required"
        ]);
    
        Comment::create([
            "description" => $request->input('description'),
            "user_id"     => $request->input('user_id'),
            "post_id"     => $request->input('post_id'),
            "parent_id"   => $request->parent_id == "parent" ? NULL : $request->input('parent_id')
        ]);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
       
        $request->validate([
            'description' => 'required'
        ]);
    
        Comment::where('id' , $id)
           ->update([
            'description' => $request->input('description')
           ]);

        return redirect()->back();
    }

    
    public function destroy($id)
    {
        $comment = Comment::where('id' , $id);
        $comment->delete();

        return redirect()->back()
             ->with('message' , 'deleted successfully');
    }
}
