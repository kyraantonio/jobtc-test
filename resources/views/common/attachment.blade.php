<div class="panel panel-default">
    <div class="panel-container">
        <div class="panel-heading" data-target="#project-attachment" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion_" aria-expanded="true">
            <h3 class="panel-title">Attachments
                <a data-toggle="modal" class="pull-right" href="#add_attachment"><i class="fa fa-plus"></i></a>
            </h3>
        </div>
        <div id="project-attachment" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
            <div class="panel-body">
                <div class="panel-content">
                    <table class="table table-striped table-hover">
                        <tbody>
                        @if(count($attachments) > 0)
                            @foreach($attachments as $attachment)
                                <tr>
                                    <td>{{ $attachment->attachment_title }}</td>
                                    <td><a href="{{ url('assets/attachment_files/'.$attachment->file) }}">click here</a>
                                    </td>
                                    <td>
                                        @if(Auth::user()->is('admin') || Auth::user()->username == $comment->username)
                                            {!!  Form::open(array('route' => array('attachment.destroy',
                                            $attachment->attachment_id), 'method' => 'delete'))  !!}
                                            <button type="submit" class="btn btn-danger btn-xs"><i class="icon-trash"></i>
                                                Delete
                                            </button>
                                            {!!  Form::close()  !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No data was found.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
