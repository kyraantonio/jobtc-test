<div class="panel panel-default">
    <div class="panel-container">
        <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion_" data-target="#project-notes" aria-expanded="true">
            <h3 class="panel-title">Notes {{ Auth::user()->name }}</h3>
        </div>
        <div id="project-notes" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
            <div class="panel-body">
                <div class="panel-content">
                    @if(isset($note->note_id))
                        {!!  Form::open(['method' => 'PUT','route' => ['note.update', isset($note->note_id) ? $note->note_id : ''],
                        'class' => 'note-form'])  !!}
                    @else
                        {!!  Form::open(['method' => 'POST','route' => ['note.store'],'class' => 'note-form'])  !!}
                    @endif
                    <div class="form-group">
                        {!!  Form::textarea('note_content',isset($note->note_content) ? $note->note_content : '',['class' => 'form-control textarea', 'placeholder' => 'Notes']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::hidden('belongs_to',$belongs_to) !!}
                        {!!  Form::hidden('unique_id', $unique_id) !!}
                        {!! Form::submit('Save',['class' => 'btn btn-shadow btn-edit'])  !!}
                    </div>
                    {!!  Form::close()  !!}
                </div>
            </div>
        </div>
    </div>
</div>