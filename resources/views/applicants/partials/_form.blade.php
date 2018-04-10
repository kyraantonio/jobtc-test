<div class="form-body">
    <div class="form-group">
        <div class="col-md-12">
                <input class="form-control title" name="title" type="text" placeholder="Title" value="" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea class="form-control description" name="description" placeholder="Description"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <?php
            //change code because causes error on other pages
            $clients = App\Models\Company::orderBy('name', 'asc')->lists('name', 'id');
            ?>
            {!! Form::select('company_id', $clients, isset($project->company_id) ?
            $project->client_id : '', ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select Company Name', 'tabindex' =>'2'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <input class="form-control" name="photo" type="file" value="" />
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            {!!  Form::submit((isset($buttonText) ? $buttonText : 'Add Project'),['class' => 'btn btn-edit btn-shadow', 'tabindex' =>
            '9'])  !!}
        </div>
    </div>
</div>