@extends('layouts.default')
@section('content')
    <div class="modal fade" id="add_link" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h4 class="modal-title">Add Category</h4>
                </div>
                <div class="modal-body">
                    @role('admin')
                    {!!  Form::open(['route' => 'linkCategory.store','class' => 'form-horizontal link-form'])  !!}
                    @include('linkCategory/partials/_form')
                    {!! Form::close()  !!}
                    @else
                        <div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'></button>
                            <strong>You dont have to perform this action!!</strong>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>


    <div class="col-md-12">
        <div class="box box-solid">
            <div class="box-header">
                <h3 class="box-title">Category List</h3>
                <div class="box-tools pull-right">
                    <a data-toggle="modal" href="#add_link">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Add New Category</button>
                    </a>
                    <button class="btn btn-sm btn-transparent" data-widget="collapse"><i class="fa fa-chevron-up"></i></button>
                </div>
            </div>
            <div class="box-body">

                <?php $DATA = array();
                $QA = array();
                foreach ($categories as $category) {
                    $categoryToEdit = "<a href='". route('linkCategory.edit',$category->id) ."' data-toggle1='modal'
                    data-target1='#ajax' class='show_edit_form'> <i
                    class='fa fa-edit fa-2x'></i> </a>";
                    $categoryToDelete = "<a href='". route('linkCategory.destroy', $category->id) ."'
                    class='alert_delete'> <i
                    class='fa
                    fa-trash-o fa-2x'></i> </a>";
                    $Option = " <span class='hspacer'></span> $categoryToEdit <span class='hspacer'></span> $categoryToDelete";

                    $QA[] = array($category->slug,
                            $category->name,
                            $Option);
                }

                $cacheKey = md5('linkCategory.list.' . session()->getId());
                Cache::put($cacheKey, $QA, 100);
                ?>
                <table class="table table-striped table-bordered table-hover dt-responsive datatableclass" id="link_table">
                    <thead>
                    <tr>
                        <th>
                            Slug
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
@stop