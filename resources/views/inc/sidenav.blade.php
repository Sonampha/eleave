<ul id="slide-out" class="sidenav sidenav-fixed grey lighten-4">
    <li class="gradient-to-right">
        <div>
            <img src="{{asset('storage/logo/dhl_express_logo_transparent.png')}}" style="margin-left:10px;">
        </div>
        <div class="user-view">
            {{-- Get picture of authenicated user --}}
            <a href="{{route('auth.show')}}"><img class="circle" src="{{asset('storage/users/'.Auth::user()->picture)}}"></a>
            {{-- Get first and last name of authenicated user --}}
            <a href="{{route('auth.show')}}"><span class="black-text name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span></a>
            {{-- Get email of authenicated user --}}
            <a href="{{route('auth.show')}}"><span class="black-text email">{{ Auth::user()->email }}</span></a>
        </div>
    </li>
    <li>
        <a class="waves-effect waves-grey" href="/dashboard"><i class="material-icons">filter_none</i>Apply Form</a>
    </li>
    <li>
        <a class="waves-effect waves-grey" href="/#"><i class="material-icons">history</i>My Leave</a>
    </li>
    <li>
        <a class="waves-effect waves-grey" href="/#"><i class="material-icons">today</i>Holiday</a>
    </li>
    @if(Auth::user()->user_type !== "USER")  
    <li>
        <a class="waves-effect waves-grey" href="/employees"><i class="material-icons">supervisor_account</i>Employee List</a>
    </li>
    <li>
        <a href="/users" class="waves-effect waves-grey"><i class="material-icons">account_circle</i>All Users</a>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header"><i class="material-icons pl-15">settings</i><span class="pl-15">Configuration</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li>
                            <a href="/departments" class="waves-effect waves-grey">
                                <i class="material-icons">business</i>
                                Department
                            </a>
                        </li>
                        <li>
                            <a href="/salaries" class="waves-effect waves-grey">
                                <i class="material-icons">attach_money</i>
                                Salary
                            </a>
                        </li>
                        <li>
                            <a href="/divisions" class="waves-effect waves-grey">
                            <i class="material-icons">business</i>
                                Division
                            </a>
                        </li>
                        <li>
                            <a href="/cities" class="waves-effect waves-grey">
                            <i class="material-icons">location_city</i>
                                City
                            </a>
                        </li>
                        <li>
                            <a href="/states" class="waves-effect waves-grey">
                            <i class="material-icons">grid_on</i>
                                State
                            </a>
                        </li>
                        <li>
                            <a href="/countries" class="waves-effect waves-grey">
                            <i class="material-icons">terrain</i>
                                Country
                            </a>
                        </li>
                        <li>
                            <a href="/reports" class="waves-effect waves-grey">
                                <i class="material-icons">insert_drive_file</i>
                                Report
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    @endif
</ul>
