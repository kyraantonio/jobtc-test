<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit event</h4>
</div>
<div class="modal-body">
    {!! Form::model($event,['method' => 'PATCH','route' => ['event.update',$event->event_id] ,'class' =>
    'form-horizontal event-form'])  !!}
    @include('event/partials/_form', ['buttonText' => 'Update'] )
    {!!  Form::close()  !!}
</div>