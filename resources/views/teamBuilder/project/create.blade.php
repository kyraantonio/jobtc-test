{!! Form::open(array('url' => 'teamBuilder?p=project&t=' . $team_id)) !!}
<div class="form-group">
    <label>Project:</label>
    {!! Form::select('project_id', $project, '', array('class' => 'form-control')) !!}
</div>
<div class="form-group pull-right">
    <button type="submit" name="submit" class="btn btn-submit btn-shadow">Add</button>
    <button type="button" class="btn btn-delete btn-shadow" data-dismiss="modal">Close</button>
</div>
<br style="clear: both;" />
{!! Form::close() !!}