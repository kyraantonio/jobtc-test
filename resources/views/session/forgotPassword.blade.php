@extends('layouts.login')
@section('content')

    <div class="login-container" id="login-box">
        <div class="col-xs-12">
            <div class="space"></div>
                {!! Form::open(['url' => 'forgotPassword','class' => 'form-class', 'id' => 'forgotPassword-form']) !!}
                {{ \App\Helpers\Helper::showMessage() }}
                <!--<div class="input-group">
                    <span id="email-span" class="input-group-addon"><i class="fa fa-user"></i></span>
                    {!! Form::text('username', '', array('tabindex' => '1', 'class' => 'form-control', 'placeholder' =>
                    'Username', 'autocomplete' => 'off', 'required' => true)) !!}
                </div><br>-->
                <div class="input-group">
                    <span id="email-span" class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    {!! Form::text('email', '', array('tabindex' => '2', 'class' => 'form-control', 'placeholder' =>
                    'Email', 'autocomplete' => 'off', 'required' => true)) !!}
                </div>
                <div class="input-group">
                    <div class="radio">
                    {!! Form::radio('usertype', 'applicant', false, ['id' => 'usertype-applicant']) !!} <label for="usertype-applicant">Applicant</label>&nbsp;&nbsp;&nbsp;
                    {!! Form::radio('usertype', 'employee', false, ['id' => 'usertype-employee']) !!} <label for="usertype-employee">Employee</label>&nbsp;&nbsp;&nbsp;
                    </div>
                </div>
                <div class="input-group">
                    <input class="btn btn-edit btn-shadow submit" type="submit" value="Reset Password" name="reset" id="reset">
                    <a href="{{ url('/') }}" class="signin space" title="Sign in">Sign In</a>
                </div>
                </form>
            <div class="space"></div>
        </div>
    </div>
@stop