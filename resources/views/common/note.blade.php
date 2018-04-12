<div class="panel panel-default">
    <div class="panel-container">
        <div class="card-header card-header-primary" role="tab" id="headingFour" data-parent="#accordion_" data-target="#project-notes" aria-expanded="true">
            <h4 class="card-title">Notes {{ Auth::user()->name }}</h4>
        </div>
        <div id="project-notes">
            <div class="card-body text-center">
                <form>
                    @if(isset($note->note_id))
                        {!!  Form::open(['method' => 'PUT','route' => ['note.update', isset($note->note_id) ? $note->note_id : ''],
                        'class' => 'note-form'])  !!}
                    @else
                        {!!  Form::open(['method' => 'POST','route' => ['note.store'],'class' => 'note-form'])  !!}
                    @endif
                    <div class="form-group">
                        {!!  Form::textarea('note_content',isset($note->note_content) ? $note->note_content : '',['class' => 'form-control textarea', 'placeholder' => 'Add Notes']) !!}
                    </div>
                    <div class="form-group">
                        {!!  Form::hidden('belongs_to',$belongs_to) !!}
                        {!!  Form::hidden('unique_id', $unique_id) !!}
                        {!! Form::submit('Save',['class' => 'btn btn-primary'])  !!}
                    </div>
                    {!!  Form::close()  !!}
                </form>
            </div>
        </div>
    </div>
</div>