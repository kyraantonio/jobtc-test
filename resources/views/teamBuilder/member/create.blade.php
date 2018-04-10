<div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#existing_tab" role="tab" data-toggle="tab">Existing</a></li>
        <li role="presentation"><a href="#duplicate_tab" role="tab" data-toggle="tab">Duplicate</a></li>
        <li role="presentation"><a href="#create_tab" role="tab" data-toggle="tab">Create</a></li>
    </ul>
    <br />

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="existing_tab">
            <div id="userSearch"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="duplicate_tab">
            {!! Form::select('duplicate_id', $team, '', array('class' => 'form-control duplicate_id')) !!}
        </div>
        <div role="tabpanel" class="tab-pane" id="create_tab">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role:</label>
                        {!! Form::select('role_id', $role, '', array('class' => 'form-control create-form')) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" class="form-control create-form" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control create-form" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password:</label>
                        <input type="text" name="password" max="6" class="form-control create-form" value="{!! str_random(6) !!}" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone" class="form-control create-form" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company:</label>
                        {!! Form::select('company_id', $company, '', array('class' => 'form-control create-form')) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Account:</label>
                        {!! Form::select('account_id', $account, '', array('class' => 'form-control create-form')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />

    <div class="form-group pull-right">
        <button type="button" name="submitMemberBtn" class="btn btn-submit btn-shadow submitMemberBtn">Add</button>
        <button type="button" class="btn btn-delete btn-shadow" data-dismiss="modal">Close</button>
    </div>
    <br style="clear: both;" />
</div>
<style>
    .nav li a{
        color: #000000;
        text-shadow: none!important;
    }
    .nav-tabs > li.active > a,
    .nav-tabs > li.active > a:hover,
    .nav-tabs > li.active > a:focus{
        background: #aeaeae;
        color: #000000;
    }
</style>

<script>
    $(function(e){
        var userIds = [];
        var us = $('#userSearch').magicSuggest({
            allowFreeEntries: false,
            method: 'get',
            data: '{!! URL::to('teamBuilderExistingUserJson?t=' . $team_id) !!}',
            renderer: function(data){
                return '<div style="padding: 5px; overflow:hidden;">' +
                    '<div style="float: left;">{!! HTML::image("assets/user/avatar.png") !!}</div>' +
                    '<div style="float: left; margin-left: 5px">' +
                        '<div style="font-weight: bold; color: #000; font-size: 20px; line-height: 11px">' + data.name + '</div>' +
                        '<div style="color: #000; font-size: 18px">' + data.email + '</div>' +
                    '</div>' +
                '</div><div style="clear:both;"></div>'; // make sure we have closed our dom stuff
            }
        });
        $(us).on('selectionchange', function(e,m){
            userIds = this.getValue();
        });

        var submitMemberBtn = $('.submitMemberBtn');
        submitMemberBtn.click(function(e){
            var activeTab = $('.tab-pane.active').attr('id').replace('_tab', '');
            var d = {
                team_id: '{!! $team_id !!}'
            };
            if(activeTab == "existing"){
                d.user = userIds;
            }
            else if(activeTab == "duplicate"){
                d.duplicate_id = $('.duplicate_id').val();
            }
            else if(activeTab == "create"){
                var create_form = $('.create-form');
                create_form.each(function(e){
                    d[$(this).attr('name')] = $(this).val();
                });
            }

            $('#add_member').modal('hide');
            waitingDialog.show('Please wait...');
            $.ajax({
                url: '{{ URL::to("/teamBuilder?p=member") }}&t=' + activeTab,
                method: 'POST',
                data: d,
                success: function(doc) {
                    location.reload();
                },
                error: function(a, b, c){
                    console.log(a.responseText);
                }
            });
        });
    });
</script>