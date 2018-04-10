<div class="profile-container">
    <ul class="list-group">                                                        
        <li class="email list-group-item"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;<a href="mailto:{{$profile->user->email}}">{{$profile->user->email}}</a></li>
        <li class="phone list-group-item"><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;<a href="tel:{{$profile->user->phone}}">{{$profile->user->phone}}<a></li>
                    <li class="skype list-group-item"><i class="fa fa-skype" aria-hidden="true"></i>&nbsp;<a href="skype:{{$profile->user->skype}}">{{$profile->user->skype}}</a></li>
                    <li class="address_1 list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{$profile->user->address_1}}</li>
                    <li class="address_2 list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{$profile->user->address_2}}</li>
                    <li class="zipcode list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;{{$profile->user->zipcode}}</li>
                    <li class="country list-group-item">
                        <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;
                        @foreach($countries as $country)
                        @if($country->country_id === $profile->user->country_id)
                        {{$country->country_name}}
                        @endif
                        @endforeach
                    </li>
                    <li class="country-dropdown hidden list-group-item">
                        <form role="form">
                            <div class="form-group">
                                <label><i class="fa fa-globe" aria-hidden="true"></i></label>
                                &nbsp;
                                <div class="btn-group">
                                    <select class="form-control edit-country" name="country_id" aria-describedby="country-addon">
                                        @foreach($countries as $country)
                                        @if($country->country_id === $profile->user->country_id)
                                        <option selected="selected" value="{{$country->country_id}}">{{$country->country_name}}</option>
                                        @else
                                        <option value="{{$country->country_id}}">{{$country->country_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>    
                    </li>
                    <li class="facebook list-group-item"><i class="fa fa-facebook-square" aria-hidden="true"></i>&nbsp;{{$profile->user->facebook}}</li>
                    <li class="linkedin list-group-item"><i class="fa fa-linkedin-square" aria-hidden="true"></i>&nbsp;{{$profile->user->linkedin}}</li>
                    </ul>
                    </div>                                        