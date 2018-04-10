<form id="add-link-form">
    <div class="form-body">
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::input('text','title',isset($link->title) ? $link->title : '',
                ['class' => 'form-control', 'placeholder' => 'Title', 'tabindex' => '1']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::input('text','url',isset($link->url) ? $link->url : '',
                ['class' => 'form-control', 'placeholder' => 'Url', 'tabindex' => '1']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::select('task_id', $briefcase, isset($link->task_id) ?
                $link->task_id : '', ['class' => 'form-control input-xlarge select2me briefcase', 'placeholder' => 'Select Briefcase', 'tabindex' =>'2'] )  !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                {!!  Form::select('category_id', $categories, isset($link->category_id) ?
                $link->category_id : '', ['class' => 'form-control input-xlarge select2me category', 'placeholder' => 'Select Category', 'tabindex' =>'2'] )  !!}
            </div>
            <div class="col-sm-6">
                {!!  Form::input('text','new_category','',
                ['class' => 'form-control category-name', 'placeholder' => 'Add New Category', 'tabindex' => '1']) !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!   Form::textarea('descriptions',isset($link->descriptions) ? $link->descriptions : '',['class' =>
                'form-control', 'placeholder' => 'Descriptions', 'tabindex' => '3'])!!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                {!!  Form::input('text','tags',isset($link->tags) ? $link->tags: '', ['class' => 'form-control form-control-inline ',
                'placeholder' => 'Tags', 'tabindex' => '4',
                ])  !!}
            </div>
        </div>
    </div>
</form>

<script>
//region Auto Change and Select Category Name
        var _category_name = '';
        $('.category-name')
                .bind('keyup keypress blur', function () {
                    _category_name = $(this).val();
                    var myStr = $(this).val();
                    myStr = myStr.toLowerCase();
                    myStr = myStr.replace(/\s+/g, "-");
                    $(this).val(myStr);
                })
                .focusout(function () {
                    var cat_form = $('.category-form');
                    var form_data = [];
                    var url = public_path + 'linkCategory';
                    var cat_value = $(this).val();
                    if ($(this).val()) {
                        form_data.push(
                                {name: 'slug', value: $(this).val()},
                        {name: 'name', value: _category_name},
                        {name: 'request_from_link_page', value: '1'}
                        );
                        $.post(url, form_data, function (data) {
                            var _return_data = jQuery.parseJSON(data);
                            var option_ele = '<option value>Select Category</option>';
                            $.each(_return_data, function (key, val) {
                                var is_selected = cat_value == val.name ? 'selected' : '';
                                option_ele += '<option value="' + val.id + '" ' + is_selected + '>' + val.name + '</option>';
                            });
                            $('select.category').html(option_ele);
                        });
                    }

                    $(this).val('');
                });
</script>