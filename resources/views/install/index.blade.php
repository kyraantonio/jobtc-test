@extends('layouts.login')
@section('content')

    <div class="form-box" id="login-box">
        <div class="header">Install</div>
        <div class="body bg-gray">

            {{ Helper::showMessage() }}

            {{ Form::open(['route' => 'install.store','class' => 'form-class','id' => 'install-form'])}}
            <div class="form-group">
                {{ Form::text('hostname', '', array('tabindex' => '1', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'Hostname', 'autocomplete' => 'off', 'tabindex' => '1', 'required' => true)) }}
            </div>
            <div class="form-group">
                {{ Form::text('mysql_username', '', array('tabindex' => '2', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'MYSQL Username', 'autocomplete' => 'off', 'tabindex' => '2', 'required' => true)) }}
            </div>
            <div class="form-group">
                {{ Form::password('mysql_password', array('tabindex' => '3', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'MYSQL Password', 'autocomplete' => 'off', 'tabindex' => '3', 'required' => true)) }}
            </div>
            <div class="form-group">
                {{ Form::text('mysql_database', '', array('tabindex' => '4', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'MYSQL Database', 'autocomplete' => 'off', 'tabindex' => '4', 'required' => true)) }}
            </div>
            <div class="form-group">
                {{ Form::text('username', '', array('tabindex' => '5', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'Login Username', 'autocomplete' => 'off', 'tabindex' => '5', 'required' => true)) }}
            </div>
            <div class="form-group">
                {{ Form::password('password', array('tabindex' => '6', 'class' => 'form-control form-control-solid placeholder-no-fix', 'placeholder' => 'Login Password', 'autocomplete' => 'off', 'tabindex' => '6', 'required' => true)) }}
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block" tabindex="7">Install</button>
        </div>
        {{ Form::close()}}
    </div>
    <div style="font-family: 'Kaushan Script', cursive;font-weight: 500;text-align:center;">Freelance Plus</div>
@stop