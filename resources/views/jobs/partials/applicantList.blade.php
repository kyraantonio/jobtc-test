<div class="applicant-list-container container-fluid">
    @if(Auth::check())
    <div class="pull-right">
        @if($job->applicants->count() > 1)
        <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicants</a>
        <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicants</a>
        @elseif ($job->applicants->count() === 1)
        <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicant</a>
        <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;{{$job->applicants->count()}} Applicant</a>
        @elseif ($job->applicants->count() === 0)
        <a class="view-applicants hidden-sm hidden-xs"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
        <a class="view-applicants-mobile hidden-lg hidden-md"><i class="fa fa-user"></i>&nbsp;&nbsp;No Applicants</a>
        @endif
        <input name="job_id" class="job_id" type="hidden" value="{{$job->id}}"/>
    </div>
    @endif
    {!! csrf_field() !!}
    @unless($applicants->count())
    <div class="no-applicants-notifier">No applicants for this job yet.</div>
    @else
    <div class="applicant-list-table">
        <div class="row">
            <div class="col-xs-12">
                <a href="#" class="btn btn-default pull-right hidden-lg hidden-md close-applicant-list-mobile"><i class="fa fa-times"></i></a>
            </div>
        </div>
        @foreach($applicants as $applicant)
        {{--*/ $display_move_btn = $applicant->hired === 'Yes' ? 'display:inline;' : 'display:none;' /*--}}
        <div id="applicant-{{$applicant->id}}" class="row applicant-row">
            @if(ends_with($applicant->resume,'pdf'))
            <div class="col-xs-3">
                <!--a target="_blank" href="https://docs.google.com/viewer?url={{url($applicant->resume)}}" class="applicant-resume"><img class="applicant-photo" src="{{url($applicant->photo)}}"/></a-->
                <a target="_blank" href="{{url('/a/'.$applicant->id)}}" class="applicant-resume">
                @if(file_exists($applicant->photo))
                    <img class="applicant-photo" src="{{url($applicant->photo)}}"/>
                @else
                    <img class="applicant-photo" src="{{url('assets/user/avatar.png')}}"/>
                @endif
                </a>

            </div>
            <div class="col-xs-8 pull-right">
                <!--a target="_blank" href="https://docs.google.com/viewer?url={{url($applicant->resume)}}" class="applicant-resume">{{$applicant->first_name}}&nbsp{{$applicant->last_name}}</a-->
                <a target="_blank" href="{{url('/a/'.$applicant->id)}}" class="applicant-resume">
                    {{$applicant->name}}
                    @if(Auth::user('user')->user_id === $job->user_id)
                    @if($applicant->hired === 'No')
                    <a href="#" class='pull-right btn btn-shadow bg-light-blue-gradient hire'>Hire</a>
                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                    @elseif($applicant->hired === 'Yes')
                    <a href="#" class='pull-right btn btn-shadow bg-green hire'><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Hired</a>
                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                    @endif
                    @endif
                </a>
                <br />
                <a href="tel:{{$applicant->phone}}" class="applicant-phone">{{$applicant->phone}}</a>
                <br />
                <a href="mailto:{{$applicant->email}}" class="applicant-email">{{$applicant->email}}</a>
                <br>
                <text class="applicant-post-date">{{date_format(date_create($applicant->created_at),'M d,Y')}}</text>
                <br />
                <textarea class="status-container">
                    @if(isset($applicant->tags[0]))
                    {{$applicant->tags[0]->tags}}
                    @endif
                </textarea>
                <input class="job_id" type="hidden" value="{{$applicant->job_id}}" />
                <input class="applicant_id" type="hidden" value="{{$applicant->id}}" />
                <label>Average Score:</label> {{ $applicant->average }}%
                <a href="#move_applicant_{{ $applicant->id }}" class="pull-right move-btn btn btn-shadow btn-edit" style="{{ $display_move_btn }}" data-toggle="modal">Move</a>
            </div>
            @else
            <div class="col-xs-3">
                <!--a target="_blank" href="http://view.officeapps.live.com/op/view.aspx?src={{url($applicant->resume)}}" class="applicant-resume"><img class="applicant-photo" src="{{url($applicant->photo)}}"/></a-->
                <a target="_blank" href="{{url('/a/'.$applicant->id)}}" class="applicant-resume">
                    @if(file_exists($applicant->photo))
                        <img class="applicant-photo" src="{{url($applicant->photo)}}"/>
                    @else
                        <img class="applicant-photo" src="{{url('assets/user/avatar.png')}}"/>
                    @endif
                </a>
            </div>
            <div class="col-xs-8 pull-right">
                <!--a target="_blank" href="http://view.officeapps.live.com/op/view.aspx?src={{url($applicant->resume)}}" class="applicant-resume">{{$applicant->first_name}}&nbsp{{$applicant->last_name}}</a-->
                <a target="_blank" href="{{url('/a/'.$applicant->id)}}" class="applicant-resume">
                    {{$applicant->name}}
                    @if(Auth::user('user')->user_id === $job->user_id)
                    @if($applicant->hired === 'No')
                    <a href="#" class='pull-right btn btn-shadow bg-light-blue-gradient hire'>Hire</a>
                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                    @elseif($applicant->hired === 'Yes')
                    <a href="#" class='pull-right btn btn-shadow bg-green hire'><i class="fa fa-star" aria-hidden="true"></i>&nbsp;Hired</a>
                    <input class="applicant_id" type="hidden" value="{{$applicant->id}}"/>
                    <input class="company_id" type="hidden" value="{{$job->company_id}}"/>
                    @endif
                    @endif
                </a>
                <br />
                <a href="tel:{{$applicant->phone}}" class="applicant-phone">{{$applicant->phone}}</a>
                <br />
                <a href="mailto:{{$applicant->email}}" class="applicant-email">{{$applicant->email}}</a>
                <br>
                <text class="applicant-post-date">{{date_format(date_create($applicant->created_at),'M d,Y')}}</text>
                <br />
                <textarea class="status-container">
                    @if(isset($applicant->tags[0]))
                    {{$applicant->tags[0]->tags}}
                    @endif
                </textarea>
                <input class="job_id" type="hidden" value="{{$applicant->job_id}}" />
                <input class="applicant_id" type="hidden" value="{{$applicant->id}}" />
                <label>Average Score:</label> {{ $applicant->average }}%
                <a href="#move_applicant_{{ $applicant->id }}" class="pull-right move-btn btn btn-shadow btn-edit" style="{{ $display_move_btn }}" data-toggle="modal">Move</a>
            </div>
            @endif
        </div>
        @if($applicant->hired === 'Yes')
        {{--region Move Applicant Modal--}}
        <div class="modal fade" id="move_applicant_{{ $applicant->id }}" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title">Move to Briefcase</h4>
                    </div>
                    {!!  Form::open(['method' => 'POST','route' => ['task.store'],'class' => 'task-form'])  !!}
                    <div class="modal-body">
                        {!!  Form::hidden('belongs_to','project')  !!}
                        <div class="form-group">
                            {!!  Form::select('unique_id',$projects, '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Project Name', 'tabindex' => '7'] )  !!}
                        </div>
                        <div class="form-group">
                            {!!  Form::input('text','task_title', $applicant->name,['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
                        </div>
                        <div class="form-group">
                            {!!  Form::textarea('task_description','',['size' => '30x3', 'class' => 'form-control',
                            'placeholder' => 'Description', 'tabindex' => '2']) !!}
                        </div>
                        <div class="form-group">
                            {!!  Form::input('text','due_date','',['class' => 'form-control form-control-inline
                            input-medium date-picker', 'placeholder' => 'Due Date', 'tabindex' => '3', 'data-inputmask' => "'alias': 'dd-mm-yyyy'", 'data-mask' => 'true'])  !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            {!!  Form::submit('Add',['class' => 'btn btn-shadow btn-edit', 'tabindex' => '5'])  !!}
                        </div>
                    </div>
                    {!!  Form::close() !!}
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @endunless
</div>