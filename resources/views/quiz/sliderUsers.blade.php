@if(count($user) > 0)
    <ul class="list-group user-list-slider">
    @foreach($user as $v)
        <li class="list-group-item" data-id="min_id" data-total="{{ $v->total_score }}">
            <div class="media">
                <div class="media-left">
                    {!! HTML::image(($v->photo ? $v->photo : 'assets/user/default-avatar.jpg'), '', array('style' => 'width: 64px;')) !!}
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $v->name }}</h4>
                    <?php
                    if(count($v->tags) > 0){
                        $ref = 0;
                        foreach($v->tags as $tags=>$points){
                            ?>
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <strong>{{ $tags ? $tags : 'General' }}</strong>
                                </div>
                                <div class="col-md-10">
                                    <div class="progress">
                                        <div data-tag="{{ $tags ? $tags : 'General' }}" data-points="{{ $points }}" data-maxpoints="{{ $v->total_points }}" class="progress-bar progress-bar-{{ $progressColor[$ref % 4] }}" role="progressbar" aria-valuenow="{{ $points }}" aria-valuemin="0" aria-valuemax="{{ $v->total_points }}" style="{{ 'width: ' . number_format(($points/$v->total_points) * 100, 2) . '%;' }}">
                                            {{ number_format($points, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $ref ++;
                        }
                    }
                    ?>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
@endif