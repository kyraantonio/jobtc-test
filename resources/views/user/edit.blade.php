<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">Edit User "{{ $user->name }}" </h4>
</div>
<div class="modal-body">
    {!!  Form::model($user,['method' => 'PATCH','route' => ['user.update',$user->user_id] ,'class' => 'form-horizontal
    user-form'])  !!}
    @include('user/partials/_form', ['buttonText' => 'Update User'] )
    {!!  Form::close()  !!}
</div>