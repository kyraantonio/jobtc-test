{!! Form::open(array('method' => 'PATCH', 'url' => 'teamBuilder/' . $team_id . '?p=team')) !!}
<div class="form-group">
    <label>Team Name:</label>
    <input type="text" name="title" class="form-control" value="{{ $team->title }}" />
</div>
<div class="form-group pull-right">
    <button type="submit" name="submit" class="btn btn-edit btn-shadow">Edit</button>
    <button type="button" class="btn btn-delete btn-shadow" data-dismiss="modal">Close</button>
</div>
<br style="clear: both;" />
{!! Form::close() !!}