<div class="list-group">
    @if($tests_info->tags_array)
    @foreach($tests_info->tags_array as $v)
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-2 text-center">
                <strong>{{ $v }}</strong>
            </div>
            <div class="col-md-9">
                <div class="nstSlider" id="{{ $v }}" style="width: 100%;" data-range_min="-100" data-range_max="100" data-cur_min="0">
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
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-2 text-center">
                <strong>General</strong>
            </div>
            <div class="col-md-9">
                <div class="nstSlider" id="General" style="width: 100%;" data-range_min="-100" data-range_max="100" data-cur_min="0">
                    <div class="bar"></div>
                    <div class="leftGrip"></div>
                </div>
            </div>
            <div class="col-md-1 text-center">
                <div class="badge leftLabel"></div>
            </div>
        </div>
    </div>
</div>
<div class="user_test_area"></div>

<script>
    $(function(e){
        var user_test_area = $('.user_test_area');

        $('.nstSlider').nstSlider({
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

                var userList = user_test_area.find('.user-list-slider .list-group-item');
                if(userList.length != 0){
                    userList.each(function(e){
                        var progressBar = $(this).find('.progress-bar[data-tag="' + tag + '"]');
                        var origPoints = progressBar.data('points');
                        var origMax = progressBar.data('maxpoints');
                        var newPoints = origPoints + (origPoints * (leftValue/100));
                        var newMax = origMax + (origMax * (leftValue/100));

                        newPoints = newPoints.toFixed(2);
                        newMax = newMax.toFixed(0);

                        var newPercentage = newPoints/origMax;
                        newPercentage = newPercentage.toFixed(2) * 100;

                        if(newPoints > origMax){
                            newPercentage = 100;
                            //progressBar.attr('aria-valuemax', newMax);
                        }
                        progressBar
                            .attr('aria-valuenow', newPoints)
                            .css('width', newPercentage + '%')
                            .html(newPoints);

                        var thisUserList = progressBar.closest('.list-group-item');
                        var thisProgress = $(this).find('.progress-bar');
                        var thisTotal = 0;
                        thisProgress.each(function(e){
                            thisTotal += parseFloat($(this).attr('aria-valuenow'));
                        });
                        thisUserList.data('total', thisTotal);
                    });

                    var list = user_test_area.find('.user-list-slider');
                    var listItems = list.find('.list-group-item').sort(function (a, b) {
                        return $(b).data('total') - $(a).data('total');
                    });
                    user_test_area.find('.list-group-item').remove();
                    list.append(listItems);
                }
            }
        });

        $.ajax({
            method: 'get',
            url: '{{ url('userSlider/' . $tests_info->id .'') }}',
            success: function(data) {
                user_test_area.html(data);
            }
        });
    });
</script>