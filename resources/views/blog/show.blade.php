@extends('layouts.app')

@section('content')


    <div class="w-4/5 m-auto text-left">
       <div class="py-15" >
           <h1 class="text-6xl">
               {{ $post->title }}
           </h1>
       </div>
    </div>

    <div class="w-4/5 m-auto pt-20">
         <span class="text-gray m-auto pt-20">
             By <span class="font-bold italic text-gray-800">{{ $post->user->name }}</span>
             created on {{ date('jS M Y' , strtotime($post->updated_at)) }}
         </span>

         <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
             {{ $post->description }}
         </p>

         <hr />
         <h2 class="my-5">Comments</h2>
         @foreach ($post->comments as $comment)
             <div class="px-5 my-2 border-left">
                <h1 class="font-bold italic text-gray-600">{{ "@" . $comment->user->name }}</h1>
                <p class="pl-5 my-1 ml-2 py-3 comment-description">{{  $comment->description }}</p>

                  {{-- to add delete and edit buttons --}}
                    @if ( Auth()->user()->id == $comment->user_id )
                        {{-- remove a comment  --}}
                        <form
                            action={{ route('comments.destroy' , $comment->id) }}
                            method="POST"
                        >
                            @csrf
                            @method('delete')
                            <button class="text-red-500 pr-4">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                         {{-- edit a comment  --}}
                            <button class="text-green-500 edit-button pr-4">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <form 
                                action="{{ route('comments.update' , $comment->id) }}"
                                method="POST"
                                class="hidden"
                            >
                                    @csrf
                                    @method('PUT')

                                    <textarea 
                                                name="description" 
                                                placeholder="Description..." 
                                                class="py-5 bg-gray-0 block border-b-2 w-full h-20 text-xl outline-none">
                                                {{ $comment->description}}
                                    </textarea>
                                   
                                    <button 
                                            type="submit"
                                            class="uppercase mt-5 bg-blue-500 text-gray-100 text-lg font-extrabold py-3
                                                    px-3 rounded-3xl"
                                            >
                                        Edit comment
                                    </button>
                                   
                                </form>
                    @endif
                 <div class="w-full md:w-full mx-auto px-8 py-2">
                    <div class="shadow-md">
                       <div class="tab w-full overflow-hidden border-t">
                          <input class="absolute opacity-0" id={{ "tab-single" . $comment->id}} type="radio" name="tabs2">
                          <label class="block p-5 leading-normal cursor-pointer" for={{ "tab-single" . $comment->id}}>Replies</label>
                          <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-indigo-500 leading-normal">
                                @foreach ($comment->replies as $replay)
                                    <div class="px-7 ml-5 py-2 my-2 mr-1 comment-description">
                                          <p>{{ $replay->description }}</p>

                                          {{-- add delete and edit button --}}
                                          @if ( Auth()->user()->id == $replay->user_id )
                                             {{-- remove a comment --}}
                                                <form
                                                    action={{ route('comments.destroy' , $replay->id) }}
                                                    method="POST"
                                                >
                                                    @csrf
                                                    @method('delete')
                                                    <button class="text-red-500 pr-4">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                               {{-- edit a comment  --}}                                          
                                                    <button class="text-green-500 edit-button pr-4">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>   
                                                    
                                                
                                            <form 
                                                   action="{{ route('comments.update' , $replay->id) }}"
                                                   method="POST"
                                                   class="hidden"
                                            >
                                               @csrf
                                               @method('PUT')

                                               <textarea 
                                                         name="description" 
                                                         placeholder="Description..." 
                                                         class="py-5 bg-gray-0 block border-b-2 w-full h-20 text-xl outline-none">
                                                         {{ $replay->description}}
                                               </textarea>
                                   
                                               <button 
                                                       type="submit"
                                                       class="uppercase mt-5 bg-blue-500 text-gray-100 text-lg font-extrabold py-3
                                                           px-3 rounded-3xl"
                                                       >
                                                   Edit comment
                                               </button>
                                   
                                            </form>

                                          @endif

                                    </div>
                                @endforeach

                                  <!-- Form of replay to a comment -->
                                            @if (isset(Auth::user()->id))    
                                            <form 
                                            action={{ route('comments.store') }}
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="w-full pl-5 pr-2"
                                            >
                                                    @csrf
                                                    @method('POST')
                            
                                                    <input type="hidden" name="post_id"   value="{{ $post->id }}"/>
                                                    <input type="hidden" name="user_id"   value="{{ Auth()->user()->id }}" />
                                                    <input type="hidden" name="parent_id" value="{{  $comment->id }}" />
                            
                                                    <textarea 
                                                            name="description" 
                                                            placeholder="add a comment..." 
                                                            class="py-1 px-2 bg-gray-0 block border-b-2 w-full mr-5 h-15 outline-none">Add a replay</textarea>
                            
                                                    <button 
                                                            type="submit"
                                                            class="uppercase mt-3 bg-blue-500 text-gray-100 text-sm font-extrabold py-3
                                                                px-5 rounded-3xl"
                                                            >
                                                        replay
                                                    </button>
                            
                                            </form>
                                        @endif
                                <!-- end of reply comment -->
                          </div>
                       </div>
                    </div>
                 </div>

             </div>
         @endforeach

        @if (isset(Auth::user()->id))
                <div class="px-5 pt-2"> 
                    <form action={{ route('comments.store') }} method="POST" enctype="multipart/form-data" >
                    @csrf
                    @method('POST')
                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                <input type="hidden" name="user_id" value="{{ Auth()->user()->id }}"/>
                <input type="hidden" name="parent_id" value="parent" />
                <textarea name="description" placeholder="add a comment..." 
                        class="py-10 bg-gray-0 block border-b-2 w-full h-40 text-xl outline-none">
                        Add a comment
                </textarea>
                <button type="submit"
                        class="uppercase mt-15 bg-blue-500 text-gray-100 text-lg font-extrabold py-4
                            px-8 rounded-3xl"
                        >
                    Add comment
                </button>

            </form>
            </div>
        @endif
    </div>

@endsection