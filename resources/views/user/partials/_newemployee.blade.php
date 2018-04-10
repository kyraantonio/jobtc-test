<div id="employee-{{$profile->user_id}}" class="col-md-6 employee-column">
    <div class="row">
        <div class="col-md-10">
            <i class="pull-left" aria-hidden="true">
                @if($profile->user->photo === '' || $profile->user->photo === NULL)
                <img class="employee-photo thumbnail" src="{{url('assets/user/default-avatar.jpg')}}" />
                @else
                <img class="employee-photo thumbnail" src="{{url($profile->user->photo)}}"/>
                @endif
            </i>
            <div class="employee-details">
                <div class="name">
                    <a class="profile-toggle" data-toggle="collapse" href="#profile-collapse-{{$profile->user->user_id}}">
                        {{$profile->user->name}}
                    </a>
                </div>
                <div class="position"><i class="fa fa-flag" aria-hidden="true"></i>&nbsp;<span>{{$profile->role->name}}</span></div>
                <div class="email"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;<a href="mailto:{{$profile->user->email}}">{{$profile->user->email}}</a></div>
                <div class="phone"><i class="fa fa-phone-square" aria-hidden="true"></i>&nbsp;<a href="tel:{{$profile->user->phone}}">{{$profile->user->phone}}</a></div>
                <div class="skype"><i class="fa fa-skype" aria-hidden="true"></i>&nbsp;<a href="skype:{{$profile->user->skype}}">{{$profile->user->skype}}</a></div>
            </div>
        </div>
        <div class="employee-options pull-right">
            @if($profile->rate->count() > 0)
            <a target="_blank" href="{{url('rate/'.$profile->user->user_id.'/company/'.$profile->company_id)}}" id="rate-{{$profile->user->user_id}}" class="btn-edit btn-sm btn-shadow btn edit-rate">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
                <span>Edit Rate</span>
            </a>
            @else
            <a target="_blank" href="{{url('rate/'.$profile->user->user_id.'/company/'.$profile->company_id)}}" id="rate-{{$profile->user->user_id}}" class="btn-edit btn-sm btn-shadow btn add-rate">
                <i class="fa fa-credit-card" aria-hidden="true"></i>
                <span>Add Rate</span>
            </a>
            @endif
            
            <a target="_blank" href="{{url('user/'.$profile->user->user_id.'/company/'.$profile->company_id)}}" class="btn-edit btn-sm btn-shadow btn employee-profile">
                <i class="fa fa-user" aria-hidden="true"></i>
                Profile
            </a>
            
            @if($module_permissions->where('slug','assign.positions')->count() === 1)  
            <a href="#" class="btn-edit btn-sm btn-shadow btn edit-employee-permissions">
                <i class="fa fa-flag" aria-hidden="true"></i>
                Permissions
            </a>
            @endif
            @if($module_permissions->where('slug','edit.employees')->count() === 1)
            <a href="#" class="btn-edit btn-sm btn-shadow btn edit-employee">
                <i class="fa fa-pencil" aria-hidden="true"></i> 
                Edit
            </a>
            @endif
            @if($module_permissions->where('slug','remove.employees')->count() === 1)
            <a href="#" class="btn-delete btn-sm btn-shadow btn remove-employee">
                <i class="fa fa-times"></i> 
                Remove
            </a>
            @endif
            <input class="user_id" type="hidden" value="{{$profile->user_id}}"/>
            <input class="company_id" type="hidden" value="{{$company_id}}"/>
            @if($profile->rate->count() > 0)
            <input class="rate_id" type="hidden" value="{{$profile->rate[0]->id}}"/>
            @else
            <input class="rate_id" type="hidden" value=""/>
            @endif
        </div>
    </div>
    <div class="row">
        <div id="profile-collapse-{{$profile->user->user_id}}" class="collapse profile-container">
            <ul class="list-group">                                                        
                <li class="address_1 list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<span>{{$profile->user->address_1}}</span></li>
                <li class="address_2 list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<span>{{$profile->user->address_2}}</span></li>
                <li class="zipcode list-group-item"><i class="fa fa-map-marker" aria-hidden="true"></i>&nbsp;<span>{{$profile->user->zipcode}}</span></li>
                <li class="country list-group-item">
                    <i class="fa fa-globe" aria-hidden="true"></i>&nbsp;
                    @foreach($countries as $country)
                    @if($country->country_id == $profile->user->country_id)
                    <span>{{$country->country_name}}</span>
                    @endif
                    @endforeach
                </li>
                <li class="facebook list-group-item"><i class="fa fa-facebook-square" aria-hidden="true"></i>&nbsp;<span>{{$profile->user->facebook}}</span></li>
                <li class="linkedin list-group-item"><i class="fa fa-linkedin-square" aria-hidden="true"></i>&nbsp;<span>{{$profile->user->linkedin}}</span></li>
            </ul>
        </div>
    </div>
</div>