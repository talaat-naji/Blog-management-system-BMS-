<x-app-layout>


    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
            integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('/css/feed.css') }}" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>
            PROFILE
        </title>
    </head>


    <br>
  
         <div class="bg-gray-100 justify-content-center">
         <div class="border bg-white wid1 justify-content-center">
        
            <form method='post' class='' enctype='multipart/form-data' action="{{ url('feeds/addPosts') }}">
                @csrf
                <div class="form-group">
                        <input type="text" class="form-control" name='title' placeholder="enter a title" required/><br>
                        <textarea required placeholder="What's on your mind?" class="form-control textareaa" name='blog_text'></textarea>
                    <div class="row"><br>
                        <div class='col-sm'>
                            <input class="form-control-file " type='file' name='imgg' />
                        </div>
                        <div class='col-sm'>
                            <input class="btn btn-primary" type='submit' name='sub' value="Post" />
                        </div>
                    </div>
                   
                </div>
            </form>
          </div><br>
                @foreach ($posts as $post)

                    <div class="border bg-white wid justify-content-center">
                        <div class="row">
                        <div class='col-sm-auto prof'>
                        <img class="profile" src="https://ui-avatars.com/api/?name={{ $post->name }}"/>
                        </div>
                            <div class='col-sm'>
                                <form action="/usProfile" method="POST">
                                @csrf
                                <input type='hidden' value={{ $post->uid }} name="profId"/>
                               <div> <button ><b class='userName1'>{{ $post->name }}</b></button><br>
                               </form>
                                <h6 class='date'>{{ $post->created_at }}</h6></div>
                                
                            </div>
                            {{-- @if ($post->uid != Auth::id())
                        <div class='col-sm'>
                            <input type='hidden' value={{ $post->uid }} id='{{ $post->uid }}toBeAdded'/>

                                <button id='followbtn{{ $post->uid }}' class='' onclick=addFriend({{ $post->uid }})>Follow</button>
                        
                           </div>
                              @endif   --}}
                            <div class='col-sm'>
                                @if ($post->uid == Auth::id())
                                    <div class="dropdown">

                                        <button class="dropbtn"><i class="fa fa-bars"></i></button>

                                        <div class="dropdown-content">
                                            <form id='{{ $post->id }}del' method='post' action="{{ url('del') }}">
                                                @csrf
                                                <input type='hidden' value="{{ $post->id }}" name='pstId' />
                                                <input type='hidden' value="{{ $post->pic_path }}" name='pic' />

                                            </form>
<button onclick=confirmm({{ $post->id }}) class="btn navbar" name="del" /> delete post</button>

                                            <button class="btn navbar" name="del" onclick=edit({{ $post->id }})>edit
                                                post</button>

                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <h3>{{$post->title}}</h3>
                        <div id="editableText{{ $post->id }}">{{ $post->blog_text }}</div>

                        @if ($post->pic_path != '')

                            <image class="imgg" src="storage/app/{{ $post->pic_path }}" alt="post image goes here" width='700px'
                                height='300px' />

                        @endif
                        
                    </div>
                    <hr>
                    <br>


                @endforeach
                {{ $posts->links() }}
            </div>
            {{-- <form method='post' action="{{ url('feeds') }}">
                @csrf
                <input type='hidden' value="5" name='seeMore' />
                <button class="btn btn-link" name="comment" id='cmnt'>See More</button>
            </form> --}}

            <script src="JSS/feedScript.js"></script>

        </div>

        {{--
        </body>

        </html> --}}
</x-app-layout>
