<div class="form-body">
    <div class="form-group">
        <div class="col-md-12">
            <input class="form-control title" name="title" placeholder="Title" type="text" value="" />
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            {{--*/ $companies = \App\Helpers\Helper::getCompanyLinks() /*--}}
            {{--*/ $clients = [] /*--}}
            {{--*/ $_company_id = Request::segment(2) /*--}}
            @if(count($companies) > 0)
                @foreach($companies as $company)
                    {{--*/ $clients[$company->company->id] = $company->company->name /*--}}
                @endforeach
            @endif
            {!! Form::select('company_id', $clients, isset($project->company_id) ?
            $project->client_id : $_company_id, ['class' => 'form-control input-xlarge select2me', 'placeholder' => 'Select Company', 'tabindex' =>'2'] )  !!}
        </div>
    </div>
    <div class="form-group">
        <input class="upload" name="photo" type="file" placeholder="Upload Logo" value="" />
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <textarea id="description" class="form-control description" name="description"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="pull-right">
            {!!  Form::submit((isset($buttonText) ? $buttonText : 'Add Job'),['class' => 'btn btn-edit btn-shadow', 'tabindex' =>
            '9'])  !!}
        </div>
    </div>
</div>
@section('js_footer')
@parent
<script>
$.fn.modal.Constructor.prototype.enforceFocus = function() {
    $( document )
        .off( 'focusin.bs.modal' ) // guard against infinite focus loop
        .on( 'focusin.bs.modal', $.proxy( function( e ) {
            if (
                this.$element[ 0 ] !== e.target && !this.$element.has( e.target ).length
                // CKEditor compatibility fix start.
                && !$( e.target ).closest( '.cke_dialog, .cke' ).length
                // CKEditor compatibility fix end.
            ) {
                this.$element.trigger( 'focus' );
            }
        }, this ) );
};
$('.upload').fileinput({
    overwriteInitial: true,
    uploadAsync: false,
    maxFileSize: 1000000,
    removeClass: "btn btn-sm btn-delete btn-shadow",
    browseClass: "btn btn-sm btn-edit btn-shadow",
    browseLabel: 'Upload Logo',
    uploadClass: "btn btn-sm btn-assign hide btn-shadow",
    cancelClass: "btn btn-sm btn-default btn-shadow",
    maxFilesNum: 5,
    showRemove: false,
    showCaption: false,
    dropZoneEnabled: false,
    showUpload: true,
    initialPreviewAsData: true
});

CKEDITOR.replace('description');
</script>    
@stop