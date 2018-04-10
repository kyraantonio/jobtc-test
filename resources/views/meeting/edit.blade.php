<div class="form-group">
    <label>Project:</label>
    <?php
    echo Form::select(
        'project_id',
        $project, $event->project_id,
        array(
          'class' => 'form-control'
        )
    );
    ?>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Date Start:</label>
            <div class='input-group time'>
                <input type='text' name="start_date" class="form-control" value="{!! date('d/m/Y h:i a', strtotime($event->start_date)) !!}" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Date End:</label>
            <div class='input-group time'>
                <input type='text' name="end_date" class="form-control" value="{!! date('d/m/Y h:i a', strtotime($event->end_date)) !!}" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Type:</label>
    <?php
    echo Form::select(
        'type_id',
        $meeting_type, $event->type_id,
        array(
          'class' => 'form-control'
        )
    );
    ?>
</div>
<div class="form-group">
    <label>Description:</label>
    <textarea name="description" class="form-control" rows="5" style="resize: none;">{!! $event->description !!}</textarea>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Estimated Length:</label>
            <div class="input-group">
                <input type="number" name="estimated_length" class="form-control" value="{!! $event->estimated_length !!}">
                <span class="input-group-addon">minutes</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Priority:</label>
            <?php
            echo Form::select(
                'priority_id',
                $meeting_priority, $event->priority_id,
                array(
                  'class' => 'form-control'
                )
            );
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Attendees:</label>
    <?php
    echo Form::select(
        'attendees[]',
        $user, '',
        array(
          'class' => 'selectpicker form-control',
          'multiple' => 'multiple'
        )
    );
    ?>
</div>
<div class="form-group">
    <label>Meeting URL:</label>
    <input type="text" name="meeting_url" class="form-control" value="{!! $event->meeting_url !!}"/>
</div>

<script>
    $(function(e){
       var time = $('.time');
        var selectpicker = $('.selectpicker');

        time.datetimepicker({
            format: 'DD/MM/YYYY hh:mm a'
        });
        selectpicker.selectpicker();
        selectpicker.selectpicker('val', {!! $event->attendees ? $event->attendees : '[]' !!});
    });
</script>