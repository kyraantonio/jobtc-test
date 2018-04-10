<div class="position_container">
    @foreach($positions->chunk(2) as $chunk)
    <div class="position-row row">
        @foreach($chunk as $position)
        @include('roles.partials._newposition')
        @endforeach
    </div>
    @endforeach
</div>
<div class="mini-space"></div>
<div class="position_tab_options">
    <a href="#" id="add-position" class="btn btn-shadow btn-default add-position">
        <i class="fa fa-plus"></i> 
        <strong>New Position</strong>
    </a>
    <input class="company_id" type="hidden" value="{{$company_id}}"/>
</div>
<script>
    $('#positions').on('click', '#add-position', function (e) {
        e.stopImmediatePropagation();
        $(this).addClass('disabled');

        var url = public_path + 'addPositionForm';
        var position_container = $('.position_container');

        $.get(url, function (data) {
            position_container.append(data);
        });
    });

    $('#positions').on('click', '.save-position', function (e) {
        e.stopImmediatePropagation();
        var url = public_path + 'addPosition';
        var position_container = $('.position_container');
        var company_id = $('.position_tab_options').find('.company_id').val();

        var data = {
            'position_title': $('input[name="position-title"]').val(),
            'position_description': $('textarea[name="position-description"]').val(),
            'company_id': company_id
        };

        $.post(url, data, function (data) {
            $('#add-position-form').remove();
            $('#add-position').removeClass('disabled');
            var position_count = position_container.find('.position-row').last().children().length;

            if (position_count === 1) {
                position_container.find('.position-row').last().append(data);
            } else {
                position_container.append('<div class="position-row row">' + data + '</div>');
            }


        });
    });

    $('#positions').on('click', '.cancel-position', function (e) {
        e.stopImmediatePropagation();
        $('#add-position').removeClass('disabled');
        $('#add-position-form').remove();
    });
</script>