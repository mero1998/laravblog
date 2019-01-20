<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Category;
use Illuminate\Http\Request;
use Session;
use App\User;
use App\Mail\BlogPublished;
use Illuminate\Support\Facades\Mail;


class BlogsController extends Controller
{
    public function __contract(){
        
        $this->middleware('author' , ['only' => ['create' , 'store' , 'edit' , 'update']]);
        $this->middleware('admin' , ['only' => ['delete' , 'trash' , 'restore' , 'permanentDelete']]);

    }
    public function index(){
        $blogs = Blog::where('status' , 1)->latest()->get();
        //$blogs = Blog::latest()->get();
        
        return view('blogs.index' , compact('blogs'));
    }
    
    public function create(){
        $categories = Category::latest()->get();
        
        return view('blogs.create' , compact('categories'));
    }
    
    public function store(Request $request){
       
        $rules = [
            
            'title' => ['required' , 'min:20', 'max:160'],
            
            'body' => ['required' , 'min:202'],
            
        ];
        
        $this->validate($request , $rules);
        
        $input = $request->all();
        // meta stuf
        $input['slug'] = str_slug($request->title);
        $input['meta_title'] = str_limit($request->title , 55);
        $input['meta_description'] = str_limit($request->body , 155);

        // upload image 
        if($file = $request->file('featured_image')){
          
        $name = uniqid() . $file->getClientOriginalName();
        $name = strtolower(str_replace(' ' , '-',$name));    
        $file->move('/images/featured_image/' , $name);
        $input['featured_image'] = $name; 
        }
       // $blog = Blog::create($input);
        $blogByUser = $request->user()->blogs()->create($input); //create blogs using relationship blog with user
        // sync with categories
        if($request->category_id){
            
           $blogByUser->category()->sync($request->category_id);
        }
       //  $blog->title = $request->title;
       //  $blog->body = $request->body;
       //    $blog->save();
        
        // mail 
        $users = User::all();
        foreach($users as $user){
            Mail::to($user->email)->queue(new BlogPublished($blogByUser , $user));
        }
        Session::flash('blog_created_message' , 'Congrateulations on Createing a great blog!');
        return redirect('/blogs');
    }
    
    public function show($slug){
        
        //$blog = Blog::findOrFail($slug);
        $blog = Blog::whereSlug($slug)->first();
        return view('blogs.show', compact('blog'));
    }
    
    public function edit($id){
        
        $blog = Blog::findOrFail($id);
         $categories = Category::latest()->get(); 
        
        
        $bc = array();
        foreach($blog->category as $c){
            $bc[] = $c->id;
        }
        
        $filtered = array_except($categories , $bc);
        
        return view('blogs.edit',['blog' => $blog , 'categories' => $categories , 'filtered' => $filtered]);
    }
    
    public function update(Request $request, $id){
       // dd($request->all());
        $input = $request->all();
        $blog = Blog::findOrFail($id);
        
        if($file = $request->file('featured_image')){
            if($blog->featured_image){
                
                unlink('/images/featured_image/'.$blog->featured_image);
            }
            
            $name = uniqid() . $file->getClientOriginalName();
        $name = strtolower(str_replace(' ' , '-'),$name);    
            $file->move('images/featured_image/' , $name);
        $input['featured_image'] = $name; 
        }
        $blog->update($input);
        
          if($request->category_id){
            
            $blog->category()->sync($request->category_id);
        }
        
        return redirect('blogs');
    
    }
    
    public function delete($id){
        
        $blog = Blog::findOrFail($id);
        $blog->delete();
        
        return redirect('blogs');
    }
    
    public function trash(){
        
        $trashedBlogs = Blog::onlyTrashed()->get();
        
        return view('blogs.trash' , compact('trashedBlogs'));
    }
    
    
    public function restore($id){
        
        $restoredBlogs = Blog::onlyTrashed()->findOrFail($id);
        
        $restoredBlogs->restore($restoredBlogs); 
        
        return redirect('blogs'); 
    }
    
    
    public function permanentDelete($id){
        
        $permanentDeleteBlog = Blog::onlyTrashed()->findOrFail($id);
        $permanentDeleteBlog->forceDelete($permanentDeleteBlog);
        
        return back();
    }
    
    public function login(){
        
        return redirect('login');
    }
    
    
    
    
    
}












