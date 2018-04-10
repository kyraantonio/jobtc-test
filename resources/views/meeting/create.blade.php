<div class="form-group">
    <label>Project:</label>
    <?php
    echo Form::select(
        'project_id',
        $project, '',
        array(
          'class' => 'project-dp form-control'
        )
    );
    ?>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Date Start:</label>
            <div class='input-group time start_date'>
                <input type='text' name="start_date" class="form-control" value="{!! date('d/m/Y h:i a', strtotime($date)) !!}" readonly/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Date End:</label>
            <div class='input-group time end_date'>
                <input type='text' name="end_date" class="form-control" value="{!! date('d/m/Y', strtotime($date)) . ' 12:59 pm' !!}" readonly/>
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
        $meeting_type, '',
        array(
          'class' => 'form-control'
        )
    );
    ?>
</div>
<div class="form-group">
    <label>Description:</label>
    <textarea name="description" class="form-control" rows="5" style="resize: none;"></textarea>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Estimated Length:</label>
            <div class="input-group">
                <input type="number" name="estimated_length" class="form-control">
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
                $meeting_priority, '',
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
    <input type="text" name="meeting_url" class="form-control" />
</div>

<script>
    $(function(e){
        var project_dp = $('.project-dp');
        var time = $('.time');
        var start_date = $('.start_date'),
            end_date = $('.end_date');
        var selectpicker = $('.selectpicker');
        var $user_per_project = <?php echo $user_per_project ? $user_per_project : '[]'; ?>;

         time.datetimepicker({
            format: 'DD/MM/YYYY hh:mm a'
        });
        selectpicker.selectpicker();

        project_dp.change(function(e){
            var thisVal = $(this).val();
            if($user_per_project[thisVal] != undefined){
                selectpicker.selectpicker('val', $user_per_project[thisVal]);
            }
        });
    });
</script>