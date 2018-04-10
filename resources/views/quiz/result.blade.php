<div class="panel-group hidden" id="accordion_" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-container">
            <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-target="#task-details" data-parent="#accordion_" aria-expanded="true">
                <h4 class="panel-title">
                    Shared File
                </h4>
            </div>
            <div id="task-details" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                <div class="panel-body">
                    <div class="panel-content">
                        <table class="table table-hover table-striped">
                            @if(count($files) > 0)
                                @foreach($files as $v)
                                    <tr>
                                        <td>{{ basename($v) }}</td>
                                        <td class="col-sm-3" style="text-align: right">
                                            @if(\App\Helpers\Helper::checkFileIsAudio($v))
                                                <?php
                                                $mime = \App\Helpers\Helper::getMimeType($v);
                                                $mime = array_shift($mime);
                                                ?>
                                                <audio class="player" src="{{ url() . '/assets/shared-files/' . $v->getRelativePathname() }}"></audio>
                                                <i class="fa fa-play audio-btn" style="font-size: 2em;"></i>&nbsp;&nbsp;&nbsp;
                                                <a href="#" data-type="4" class="delete-file-btn" id="{{ basename($v) }}"><i class="fa fa-2x fa-times"></i></a>
                                            @else
                                                <a href="{{ url() . '/assets/shared-files/' . $v->getRelativePathname() }}" target="_blank">
                                                    <i class="fa fa-external-link" style="font-size: 2em;"></i>
                                                </a>&nbsp;&nbsp;&nbsp;
                                                <a href="#" data-type="3" class="delete-file-btn" id="{{ basename($v) }}"><i class="fa fa-2x fa-times"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                 <tr>
                                    <td>No data was found.</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>