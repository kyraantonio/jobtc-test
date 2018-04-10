<div class="row">
    <div class="col-md-9">
        @foreach($team as $v)
        <div class="box box-default">
            <div class="box-container">
                <div class="box-header">
                    <h3 class="box-title" style="width: 80%;" data-target="#member-{{ $v->id }}" data-toggle="collapse">{{ $v->title }}</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-edit btn-edit-team" data-type="team" id="{{ $v->id }}">Edit</button>
                        <a href="#" class="btn btn-submit btn-add-member" id="{{ $v->id }}" data-toggle="modal" data-target="#add_member">
                            <i class="fa fa-plus"></i>
                        </a>
                        <button class="btn btn-delete" data-type="team" id="{{ $v->id }}">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body collapse" id="member-{{ $v->id }}">
                    <div class="box-content">
                        <div class="row">
                            <div class="col-sm-8">
                                <ul class="list-group member-list" id="{{ $v->id }}">
                                    @foreach($v->member as $m)
                                    <li class="list-group-item member-item" id="{{ $m->user_id }}">
                                        <div class="row">
                                            <div class="media col-md-8">
                                                <div class="media-left">
                                                    {!! HTML::image('/assets/user/avatar.png', '', array('style' => 'width: 64px;max-width: 64px!important;')) !!}
                                                </div>
                                                <div class="media-body">
                                                    <h3 class="media-heading">{{ $m->name }}</h3>
                                                    {{ $m->email }}
                                                </div>
                                            </div>
                                            <div class="drag-handle col-md-2">
                                                <img src='{{ url('/assets/img/draggable-handle-2.png') }}'/>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-delete" data-type="member" id="{{ $m->id }}">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <div class="box box-default">
                                    <div class="box-container">
                                        <div class="box-header">
                                            <h3 class="box-title" style="width: 70%;">Projects</h3>
                                            <div class="box-tools pull-right">
                                                <a href="#" class="btn btn-submit add-project-btn" id="{{ $v->id }}">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="box-content">
                                                @foreach($v->projects as $p)
                                                <div class="row">
                                                    <div class="col-sm-9">{{ $p->project_title }}</div>
                                                    <div class="col-sm-3">
                                                        <button class="btn btn-delete" data-type="project" id="{{ $p->project_id }}">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-md-3">
        <div class="box box-default">
            <div class="box-container">
                <div class="box-header">
                    <h3 class="box-title" style="width: 80%;" data-toggle="collapse" data-target="#team-library">Teams</h3>
                    <div class="box-tools pull-right">
                        <a href="#" class="btn btn-submit" data-toggle="modal" data-target="#create_team">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="box-body collapse in" id="team-library">
                    <table class="table table-hover table-striped">
                    @foreach($team as $v)
                    <tr><td>{{ $v->title }}</td></tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create_team">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Create Team</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_team">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Edit Team</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_member">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Member</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="add_project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<style>
    .member-list{
        height: 86px;
        margin-bottom: 90px;
    }
    .member-item{
        z-index: 99;
    }
</style>

@section('js_footer')
@parent
<script>
    $(function(e){
        var create_team = $('#create_team');
        create_team.on('show.bs.modal', function(e){
            $.ajax({
                url: '{{ URL::to("/teamBuilder/create?p=team") }}',
                success: function(doc) {
                    create_team.find('.modal-body').html(doc);
                }
            });
        });

        var btn_edit_team = $('.btn-edit-team');
        var edit_team = $('#edit_team');
        btn_edit_team.click(function(e){
            var thisId = this.id;
            var thisUrl = '{{ URL::to("/teamBuilder") }}/' + thisId + '/edit?p=team';
            $.ajax({
                url: thisUrl,
                success: function(doc) {
                    edit_team.modal('show');
                    edit_team.find('.modal-body').html(doc);
                }
            });
        });

        var add_member_btn = $('.btn-add-member');
        var add_member = $('#add_member');
        add_member_btn.click(function(e){
            var thisId = this.id;
            var thisUrl = '{{ URL::to("/teamBuilder/create?p=member") }}&id=' + thisId;
            $.ajax({
                url: thisUrl,
                success: function(doc) {
                    add_member.modal('show');
                    add_member.find('.modal-body').html(doc);
                }
            });
        });

        //region Drag and Drop Duplicate Team Member
        var currentUserId = '';

        initSortable($('.member-list'));
        initDraggable($('.member-item'));
        function initDraggable($element){
            $element
                .draggable({
                    connectToSortable: ".member-list",
                    revert: "invalid",
                    helper: "clone",
                    handle: ".drag-handle",
                    drag: function( event, ui ){
                        currentUserId = this.id;
                    }
                });
        }

        function initSortable($element){
            $element
                .sortable({
                    revert: "invalid",
                    connectWith: ".member-list",
                    handle: ".drag-handle",
                    stop: function (event, ui) {
                        var thisElement = $(this).find('.member-item#' + currentUserId);
                        var isExist = thisElement.length != 0;
                        if(isExist){
                            //if user already exist stop
                            $(ui.item.context).remove();
                        }
                        else{
                            initDraggable($(ui.item.context));
                            $(ui.item.context).attr('id', currentUserId);
                            var d = {
                                team_id: $(this).attr('id'),
                                user: [currentUserId]
                            };

                            waitingDialog.show('Please wait...');
                            $.ajax({
                                url: '{{ URL::to("/teamBuilder?p=member") }}&t=existing',
                                method: 'POST',
                                data: d,
                                success: function(doc) {
                                     waitingDialog.hide();
                                },
                                error: function(a, b, c){
                                    console.log(a.responseText);
                                }
                            });
                        }
                    }
                });
        }
        //endregion

        var add_project_btn = $('.add-project-btn');
        var add_project = $('#add_project');
        add_project_btn.click(function(e){
            var thisId = this.id;
            var thisUrl = '{{ URL::to("/teamBuilder/create?p=project") }}&id=' + thisId;
            $.ajax({
                url: thisUrl,
                success: function(doc) {
                    add_project.modal('show');
                    add_project.find('.modal-body').html(doc);
                }
            });
        });

        var btn_delete = $('.btn-delete');
        btn_delete.click(function(e){
            var thisElement = $(this).closest('.member-item');
            var thisId = this.id;
            var type = $(this).data('type');
            var thisUrl = '{{ URL::to('teamBuilder') }}/' + thisId + '?p=' + type;

            waitingDialog.show('Pleas wait...');
            $.ajax({
                url: thisUrl,
                method: "DELETE",
                success: function(doc) {
                    thisElement.fadeOut(function(e){

                    }, 1500);
                }
            });
        });
    });
</script>
@stop