<div class="form-body">
    <div class="form-group">
        <input class="form-control room_name" name="room_name" placeholder="Room Name" type="text" value="{{$discussion->room_name}}" />
    </div>
    <div class="form-group">
        <select class="form-control room_type" name="room_type">
            @if($discussion->room_type === "public")
            <option selected="selected" value="public">Public</option>
            @else
            <option value="public">Public</option>
            @endif
            @if($discussion->room_type === "private")
            <option selected="selected" value="private">Private</option>
            @else
            <option value="private">Private</option>
            @endif
        </select>
    </div>
</div>