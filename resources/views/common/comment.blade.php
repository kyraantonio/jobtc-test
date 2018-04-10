<div class="panel panel-default">
    <div class="panel-container">
        <div class="panel-heading" data-target="#project-comments" role="tab" id="headingFive" data-toggle="collapse" data-parent="#accordion_" aria-expanded="true">
            <h3 class="panel-title">Comments</h3>
        </div>
        <div id="project-comments" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
            <div class="panel-body">
                <div class="panel-content">
                {!!  Form::open(['method' => 'POST','route' => ['comment.store'],'class' => 'comment-form'])  !!}
                {!!  Form::hidden('belongs_to',$belongs_to)  !!}
                {!!  Form::hidden('unique_id', $unique_id)  !!}
                <div class="form-group">
                    {!!  Form::textarea('comment','',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Comment', 'tabindex' => '11']) !!}
                </div>
                <div class="form-group">
                    {!!  Form::submit('Add',['class' => 'btn btn-edit', 'tabindex' => '12'])  !!}
                </div>
                {!!  Form::close()  !!}

                @if(count($comments))
                    <br/>
                    <div class="panel panel-success">
                        <div class="panel-body chat" id="chat-box">
                            @foreach($comments as $comment)
                                <div class="item">
                                    <img src="{{ \App\Helpers\Helper::getAvatar($comment->username) }}" alt="user image" class="online"/>
                                    <p class="message">
                                        <a href="#" class="name">
                                            <small class="text-muted pull-right"><i
                                                        class="fa fa-clock-o"></i> {{ date("d M Y",strtotime($comment->created_at)) }}
                                            </small>
                                            {{ $comment->username }} writes
                                        </a>
                                        {{ $comment->comment}}

                                        @if(Auth::user()->is('admin') || Auth::user()->username == $comment->username)
                                            {!!  Form::open(array('route' => array('comment.destroy', $comment->comment_id)
                                            , 'method' => 'delete'))  !!}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="icon-trash"></i>
                                                Delete
                                            </button>
                                            {!!   Form::close() !!}
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
            </div>
        </div>
    </div>
</div>
