<div class="list-group">
    @if($test_tags)
    @foreach($test_tags as $v)
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-3 text-center">
                <strong>{{ strtoupper($v) }}</strong>
            </div>
            <div class="col-md-8">
                <div class="nstSlider" id="{{ $v }}" style="width: 100%;" data-range_min="-100" data-range_max="100" data-cur_min="{{ array_key_exists($v, $slide_setting) ? $slide_setting->$v : 0 }}" data-cur_max="0" >
                    <div class="bar"></div>
                    <div class="leftGrip"></div>
                </div>
            </div>
            <div class="col-md-1 text-center">
                <div class="badge leftLabel"></div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
<div class="btn-area text-right">
    <button type="button" class="btn btn-submit saveBtn hidden">Save</button>
    <button type="button" class="btn btn-delete resetBtn">Reset</button>
</div>
<div class="user_test_area"></div>
<style>
    .progress .progress-bar{
        color: #222222;
    }
</style>
<script>
    $(function(e){
        var nstSlider = $('.nstSlider');
        var user_test_area = $('.user_test_area');
        var btn_area = $('.btn-area');
        var saveBtn = $('.saveBtn');
        var resetBtn = $('.resetBtn');

        nstSlider.nstSlider({
            "left_grip_selector": ".leftGrip",
            "value_bar_selector": ".bar",
            "value_changed_callback": function(cause, leftValue, rightValue) {
                var $container = $(this).closest('.row'),
                    g = 255 - 127 + leftValue,
                    r = 255 - g,
                    b = 0;
                $container.find('.leftLabel').text(leftValue + ' %');
                $(this).find('.bar').css('background', 'rgb(' + [r, g, b].join(',') + ')');

                var tag = $(this).attr('id');
                changeSlider(leftValue, tag);
            },
            "user_mouseup_callback": function(vmin, vmax, left_grip_moved) {
                saveSlider();
            }
        });
        resetBtn.click(function(e){
            nstSlider.nstSlider('set_position', 0);
            nstSlider.nstSlider('refresh');
            nstSlider.each(function(e){
                var tag = $(this).attr('id');
                changeSlider(0, tag);
            });
            saveSlider();
        });

        function changeSlider(leftValue, tag){
            var userList = user_test_area.find('.user-list-slider .list-group-item');
            if(userList.length != 0){
                userList.each(function(e){
                    var progressBar = $(this).find('.progress-bar[data-tag="' + tag + '"]');
                    var origPoints = progressBar.data('points');
                    var origMax = progressBar.data('maxpoints');
                    var newPoints = origPoints + (origPoints * (leftValue/100));
                    var newMax = parseFloat(progressBar.attr('aria-valuemax'));
                    newMax = newMax ? newMax : 0;

                    newPoints = newPoints.toFixed(2);
                    newPoints = newPoints > origMax ? origMax : newPoints;

                    newMax = newPoints > newMax ? newPoints : newMax;
                    newMax = newMax.toFixed(2);

                    var newPercentage = newPoints/origMax;
                    newPercentage = newPercentage.toFixed(2) * 100;

                    if(newPoints > origMax){
                        newPercentage = 100;
                    }
                    progressBar
                        .attr('aria-valuenow', newPoints)
                        .css('width', newPercentage + '%')
                        .html(newPoints != 0 ? newPoints + '/' + newMax : '');

                    var thisUserList = progressBar.closest('.list-group-item');
                    var thisProgress = $(this).find('.progress-bar');
                    var thisScore = 0;
                    var thisTotal = 0;
                    thisProgress.each(function(e){
                        if($(this).attr('aria-valuenow') > 0){
                            thisScore += parseFloat($(this).attr('aria-valuenow'));
                            thisTotal += parseFloat($(this).attr('aria-valuemax'));
                        }
                    });
                    var thisAverage = (thisScore/thisTotal) * 100;
                    thisAverage = isNaN(thisAverage) ? 0 : thisAverage;
                    thisAverage = thisAverage.toFixed(2);
                    thisUserList.data('total', thisAverage);
                });

                var list = user_test_area.find('.user-list-slider');
                var listItems = list.find('.list-group-item').sort(function (a, b) {
                    return $(b).data('total') - $(a).data('total');
                });
                user_test_area.find('.list-group-item').remove();
                list.append(listItems);
                var ref = 1;
                list.find('.list-group-item').sort(function (a, b) {
                    if(ref > 4){
                        $(this).addClass('hidden');
                    }
                    else{
                        $(this).removeClass('hidden');
                    }
                    ref ++;
                });
            }
        }
        function saveSlider(){
            var slider_setting = {};
            nstSlider.each(function(e){
                slider_setting[this.id] = $(this).nstSlider('get_current_min_value');
            });
            $.ajax({
                method: 'POST',
                url: '{{ url('quizSliderSave') }}',
                data: {
                    job_id: '{{ $job_id }}',
                    slider_setting: slider_setting
                },
                success: function(data) {

                }
            });
        }

        $.ajax({
            method: 'get',
            url: '{{ url('quizUserAssessment/' . $job_id .'') }}',
            success: function(data) {
                user_test_area.html(data);
            }
        });
    });
</script>