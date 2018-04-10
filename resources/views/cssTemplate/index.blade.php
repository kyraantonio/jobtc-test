@extends('layouts.default')
@section('content')
<style>
pre{
     padding: 0!important;
     margin: 0!important;
}
script.code {
  display: block !important;
}
</style>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h4>Buttons</h4>
                <hr/>
                <div class="col-sm-6">
                    <label>btn btn-edit</label>
                    <input type="button" class="btn btn-edit" value="Edit"><br/><br/>
                    <label>btn btn-submit</label>
                    <input type="button" class="btn btn-submit" value="Submit"><br/><br/>
                    <label>btn btn-default</label>
                    <input type="button" class="btn btn-default" value="Default"><br/><br/>
                    <label>btn btn-assign</label>
                    <input type="button" class="btn btn-assign" value="Assign"><br/><br/>
                    <label>btn btn-finish</label>
                    <input type="button" class="btn btn-finish" value="Finish"><br/><br/>
                    <label>btn btn-delete</label>
                    <input type="button" class="btn btn-delete" value="Delete"><br/><br/>
                    <label>btn btn-priority</label>
                    <input type="button" class="btn btn-priority" value="Priority"><br/><br/>
                    <label>btn btn-timer</label>
                    <input type="button" class="btn btn-timer" value="Start Timer"><br/><br/>
                    <label>btn btn-black</label>
                    <input type="button" class="btn btn-black" value="Black"><br/><br/>
                </div>
                <div class="col-sm-6">
                    <label>btn-shadow</label>
                    <input type="button" class="btn-shadow btn btn-edit" value="Edit"><br/><br/>
                    <label>btn-transparent</label>
                    <input type="button" class="btn-transparent btn btn-edit" value="Edit"><br/><br/>
                    <label>btn-sm</label>
                    <input type="button" class="btn btn-edit btn-sm" value="Edit"><br/><br/>
                    <label>btn-lg</label>
                    <input type="button" class="btn btn-edit btn-lg" value="Edit"><br/><br/>
                </div>
            </div>
            <div class="col-sm-7">
                <h4>Box</h4>
                <hr/>
                <div class="col-sm-6">
                    <pre>
                       <script class="code" type="text/plain">
<div class="box box-default">
    <div class="box-container">
        <div class="box-header">
            <h3 class="box-title">Box Title</h3>
        </div>
        <div class="box-body">
            <div class="box-content">
                This is a box body
            </div>
        </div>
    </div>
</div>
                       </script>
                    </pre>
                </div>
                <div class="col-sm-6">
                    <label>box-default</label>
                    <div class="box box-default">
                        <div class="box-container">
                            <div class="box-header">
                                <h3 class="box-title">Box Title</h3>
                            </div>
                            <div class="box-body">
                                <div class="box-content">
                                    This is a box body
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h4>Background and Text Color</h4>
                <hr/>
                <div class="col-sm-3">
                    <label>bg-gray</label>
                    <div class="bg-gray">Gray</div>
                    <label>bg-black</label>
                    <div class="bg-black">Black</div>
                    <label>bg-red</label>
                    <div class="bg-red">Red</div>
                    <label>bg-blue</label>
                    <div class="bg-blue">Blue</div>
                    <label>bg-yellow</label>
                    <div class="bg-yellow">Yellow</div>
                    <label>bg-aqua</label>
                    <div class="bg-aqua">Aqua</div>
                    <label>bg-light-blue</label>
                    <div class="bg-light-blue">Light Blue</div>
                    <label>bg-green</label>
                    <div class="bg-green">Green</div>
                    <label>bg-navy</label>
                    <div class="bg-navy">Navy</div>
                    <label>bg-teal</label>
                    <div class="bg-teal">Teal</div>
                    <label>bg-olive</label>
                    <div class="bg-olive">Olive</div>
                    <label>bg-lime</label>
                    <div class="bg-lime">Lime</div>
                    <label>bg-fuchsia</label>
                    <div class="bg-fuchsia">Fuchsia</div>
                    <label>bg-purple</label>
                    <div class="bg-purple">Purple</div>
                    <label>bg-maroon</label>
                    <div class="bg-maroon">Maroon</div>
                </div>
                <div class="col-sm-3">
                    <label>bg-black-gradient</label>
                    <div class="bg-black-gradient">Black</div>
                    <label>bg-red-gradient</label>
                    <div class="bg-red-gradient">Red</div>
                    <label>bg-blue-gradient</label>
                    <div class="bg-blue-gradient">Blue</div>
                    <label>bg-yellow-gradient</label>
                    <div class="bg-yellow-gradient">Yellow</div>
                    <label>bg-aqua-gradient</label>
                    <div class="bg-aqua-gradient">Aqua</div>
                    <label>bg-light-blue-gradient</label>
                    <div class="bg-light-blue-gradient">Light Blue</div>
                    <label>bg-green-gradient</label>
                    <div class="bg-green-gradient">Green</div>
                    <label>bg-teal-gradient</label>
                    <div class="bg-teal-gradient">Teal</div>
                    <label>bg-purple-gradient</label>
                    <div class="bg-purple-gradient">Purple</div>
                    <label>bg-maroon-gradient</label>
                    <div class="bg-maroon-gradient">Maroon</div>
                </div>
                <div class="col-sm-3">
                    <label>text-red</label>
                    <h3 class="text-red">Text Color</h3>
                    <label>text-yellow</label>
                    <h3 class="text-yellow">Text Color</h3>
                    <label>text-aqua</label>
                    <h3 class="text-aqua">Text Color</h3>
                    <label>text-blue</label>
                    <h3 class="text-blue">Text Color</h3>
                    <label>text-black</label>
                    <h3 class="text-black">Text Color</h3>
                    <label>text-light-blue</label>
                    <h3 class="text-light-blue">Text Color</h3>
                    <label>text-green</label>
                    <h3 class="text-green">Text Color</h3>
                    <label>text-navy</label>
                    <h3 class="text-navy">Text Color</h3>
                </div>
                <div class="col-sm-3">
                    <label>text-teal</label>
                    <h3 class="text-teal">Text Color</h3>
                    <label>text-olive</label>
                    <h3 class="text-olive">Text Color</h3>
                    <label>text-lime</label>
                    <h3 class="text-lime">Text Color</h3>
                    <label>text-orange</label>
                    <h3 class="text-orange">Text Color</h3>
                    <label>text-fuchsia</label>
                    <h3 class="text-fuchsia">Text Color</h3>
                    <label>text-purple</label>
                    <h3 class="text-purple">Text Color</h3>
                    <label>text-maroon</label>
                    <h3 class="text-maroon">Text Color</h3>
                </div>
            </div>
            <div class="col-sm-6">
                            <h4>Progress Bar</h4>
                            <hr/>
                            <div class="col-sm-6">
                            <pre>
            <script class="code" type="text/plain">
<div class="progress-custom">
    <span class="progress-val">50%</span>
    <span class="progress-bar-custom"><span class="progress-in" style="width: 50%"></span></span>
</div></script>
                            </pre>
                            </div>
                            <div class="col-sm-6">
                                <label>Custom Progress Bar</label>
                                <div class="progress-custom">
                                    <span class="progress-val">50%</span>
                                    <span class="progress-bar-custom"><span class="progress-in" style="width: 50%"></span></span>
                                </div>
                            </div>
                        </div>
        </div>
    </div>
@stop