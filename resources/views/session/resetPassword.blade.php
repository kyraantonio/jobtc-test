@extends('layouts.login')
@section('content')

    <div class="login-container" id="login-box">
        <div class="col-xs-12">
            <div class="space"></div>
                {!! Form::open(['url' => 'resetPassword','class' => 'form-class', 'id' => 'resetPassword-form']) !!}
                {{ \App\Helpers\Helper::showMessage() }}
                <div class="input-group">
                    <span id="email-span" class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    {!! Form::text('email', '', array('tabindex' => '1', 'class' => 'form-control', 'placeholder' =>
                    'Email', 'required' => true)) !!}
                </div><br>
                <div class="input-group">
                    <span id="password-span" class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password', array('tabindex' => '2', 'class' => 'form-control', 'placeholder' =>
                    'New Password', 'required' => true)) !!}
                </div><br>
                <div class="input-group">
                    <span id="password_confirmation-span" class="input-group-addon"><i class="fa fa-lock"></i></span>
                    {!! Form::password('password_confirmation', array('tabindex' => '3', 'class' => 'form-control', 'placeholder' =>
                    'Verify Password', 'required' => true)) !!}
                </div>
                <div class="space"></div>
                <div class="input-group">
                    <input type="hidden" name="token" id="token" value="{{ $token }}">
                    <input type="hidden" name="usertype" id="usertype" value="{{ $usertype }}">
                    <input class="btn btn-edit btn-shadow submit" type="submit" value="Save Password" name="reset" id="reset">
                    <a href="{{ url('/') }}" class="signin space" title="Sign in">Sign In</a>
                </div>
                </form>
            <div class="space"></div>
        </div>
    </div>
@stop