<?php

namespace App\Http\Controllers;

use App\Models\Post; 
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{

    public function __construct() {
       return $this->middleware('auth' , ['except' => ['index' , 'show']]);
    }
   
    public function index()
    {
        return view("blog.index")
            ->with('posts' , Post::orderBy('updated_at' , 'DESC')->paginate(5));
    }


    public function create()
    {
        return view('blog.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg|max:5048'
        ]);

        $newNameImage = uniqid() . '-' . $request->title .'.' . $request->image->extension();

        // Move the image to images folder in Public folder
        $request->image->move(public_path('images') , $newNameImage); 

        // we use Sluggable (library to create slug)
        $slug = SlugService::createSlug(Post::class , 'slug' , $request->title);

        Post::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'slug' => $slug , 
            'img_path' => $newNameImage,
            'user_id' => auth()->user()->id
        ]);

        return redirect('/blog')
                  ->with('message' , 'Your Post has been added');
    }


    public function show($slug)
    {
        return view('blog.show')
                 ->with('post' , Post::where('slug' , $slug)->first());
    }

    public function edit($slug)
    {
        return view('blog.edit')
                ->with('post' , Post::where('slug' , $slug)->first());
    }

    public function update(Request $request, $slug)
    {
 
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);


        Post::where('slug' , $slug)
               ->update([
                   'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'slug' => SlugService::createSlug(Post::class , 'slug' , $request->title) , 
                    'user_id' => auth()->user()->id
           ]); 

           return redirect('/blog')
                  ->with('message' , 'Your post has been updated!');
    }


    public function destroy($slug)
    {
        $post = Post::where('slug' , $slug);
        $post->delete();

        return redirect('/blog')
        ->with('message' , 'Your post has been Deleted successfully!');
    }
}



