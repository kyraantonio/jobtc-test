<div class="form-body">
    <div class="form-group">
        {!!  Form::label('name','Category Name',['class' => 'col-md-3 control-label']) !!}
        <div class="col-md-9">
            {!!  Form::input('text','name',isset($category->name) ? $category->name : '',
           ['class' => 'form-control', 'id' => 'category-name', 'placeholder' => 'Name', 'tabindex' => '1']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!!  Form::submit((isset($buttonText) ? $buttonText : 'Add Category'),['class' => 'btn btn-submit', 'tabindex' =>
            '9'])  !!}
        </div>
    </div>
</div>
