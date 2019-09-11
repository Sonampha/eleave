<style>
    .leave_color{color:#01579b !important;}
    .ot_color{color:#2e7d32 !important;}
    .att_color{color:#ff6d00 !important;}
    .hr_color{color:darkgoldenrod  !important;}
    .p-left{padding-left: 0 !important;}
</style>
<ul id="slide-out" class="sidenav sidenav-fixed grey lighten-4">
    <li class="gradient-to-right">
        <div>
            <img src="{{asset('uploads/logo/dhl_express_logo_transparent.png')}}" style="margin-left:10px;">
        </div>
        <div class="user-view">
            {{-- Get picture of authenicated user --}}
            <a href="{{route('auth.show')}}"><img class="circle" src="{{asset('uploads/users/'.Auth::user()->picture)}}"></a>
            {{-- Get first and last name of authenicated user --}}
            <a href="{{route('auth.show')}}"><span class="black-text name">{{ Auth::user()->full_name }}</span></a>
            {{-- Get email of authenicated user --}}
            <a href="{{route('auth.show')}}"><span class="black-text email">{{ Auth::user()->email }}</span></a>
        </div>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('dashboard') ? '' : '' || 
            Request::is('my_leaves*') ? 'active' : '' ||
            Request::is('my_leave_tasks') ? 'active' : '' ||
            Request::is('my_reports/leave_reports*') ? 'active' : '' ||
            Request::is('my_reports/report_pending*') ? 'active' : '' ||
            Request::is('my_reports/report_by_id*') ? 'active' : '' ||
            Request::is('my_reports/report_by_sum*') ? 'active' : ''}}">
                <a class="collapsible-header"><i class="material-icons pl-15 leave_color">filter_none</i><span class="pl-15">Apply Leave</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/dashboard"><i class="material-icons leave_color">chevron_right</i>Apply Form</a>
                        </li>
                        <li class="{{ Request::is('my_leaves*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/my_leaves"><i class="material-icons leave_color">chevron_right</i>My Leave</a>
                        </li>
                        @if(Auth::user()->user_type != "USER")
                        <li class="{{ Request::is('my_leave_tasks') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/my_leave_tasks"><i class="material-icons leave_color">chevron_right</i>Approve</a>
                        </li>
                        @endif
                        @if(Auth::user()->user_type != "ADMIN")
                        <li>
                        <ul class="collapsible collapsible-accordion">
                        <li class="{{Request::is('my_reports/leave_reports*') ? 'active' : '' || Request::is('my_reports/report_pending*') ? 'active' : '' || Request::is('my_reports/report_by_id*') ? 'active' : '' || Request::is('my_reports/report_by_sum*') ? 'active' : ''}}">
                        <a class="collapsible-header">
                        <i class="material-icons p-left leave_color">search</i><span class="p-left">Search</span>
                        </a>
                            <div class="collapsible-body">
                            <ul>
                                <li class="{{ Request::is('my_reports/report_pending*') ? 'active' : '' }}">
                                    <a class="waves-effect waves-grey" href="/my_reports/report_pending">
                                        <i class="material-icons pl-15 leave_color">chevron_right</i><span class="pl-15">Search Pending</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('my_reports/report_by_id*') ? 'active' : '' }}">
                                    <a class="waves-effect waves-grey" href="/my_reports/report_by_id">
                                        <i class="material-icons pl-15 leave_color">chevron_right</i><span class="pl-15">Search by ID</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('my_reports/leave_reports*') ? 'active' : '' }}">
                                    <a class="waves-effect waves-grey" href="/my_reports/leave_reports">
                                        <i class="material-icons pl-15 leave_color">chevron_right</i><span class="pl-15">Search by Date</span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('my_reports/report_by_sum*') ? 'active' : '' }}">
                                    <a class="waves-effect waves-grey" href="/my_reports/report_by_sum">
                                        <i class="material-icons pl-15 leave_color">chevron_right</i><span class="pl-15">Search by Sum</span>
                                    </a>
                                </li>
                            </ul>
                            </div>
                        </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('overtime') ? 'active' : '' || Request::is('overtime/myovertime*') ? 'active' : '' ||
            Request::is('overtime/verify') ? 'active' : '' ||
            Request::is('overtime/approve') ? 'active' : '' ||
            Request::is('overtime/report*') ? 'active' : '' ||
            Request::is('overtime/export*') ? 'active' : ''}}">
                <a class="collapsible-header"><i class="material-icons pl-15 ot_color">filter_none</i><span class="pl-15">Apply O.T</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('overtime') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime"><i class="material-icons ot_color">chevron_right</i>Apply Form</a>
                        </li>
                        <li class="{{ Request::is('overtime/myovertime*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime/myovertime"><i class="material-icons ot_color">chevron_right</i>My Overtime</a>
                        </li>
                        @if(Auth::user()->user_type != "USER")
                        <li class="{{ Request::is('overtime/verify') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime/verify"><i class="material-icons ot_color">chevron_right</i>Verify</a>
                        </li>
                        <li class="{{ Request::is('overtime/approve') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime/approve"><i class="material-icons ot_color">chevron_right</i>Approve</a>
                        </li>
                        <li class="{{ Request::is('overtime/report*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime/report_by_sum"><i class="material-icons ot_color">chevron_right</i>Report</a>
                        </li>                        
                        <li class="{{ Request::is('overtime/export*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/overtime/export"><i class="material-icons ot_color">chevron_right</i>Export</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('attendance') ? 'active' : '' || 
            Request::is('my_attendances*') ? 'active' : '' ||
            Request::is('my_att_tasks') ? 'active' : ''}}">
                <a class="collapsible-header"><i class="material-icons pl-15 att_color">filter_none</i><span class="pl-15">Apply Late...</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('attendance') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/attendance"><i class="material-icons att_color">chevron_right</i>Apply Form</a>
                        </li>
                        <li class="{{ Request::is('my_attendances*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/my_attendances"><i class="material-icons att_color">chevron_right</i>My Attendance</a>
                        </li>
                        @if(Auth::user()->user_type != "USER")
                        <li class="{{ Request::is('my_att_tasks') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey" href="/my_att_tasks"><i class="material-icons att_color">chevron_right</i>Approve</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li class="{{ Request::is('holidays*') ? 'active' : '' }}">
        <a class="waves-effect waves-grey" href="/holidays"><i class="material-icons hr_color">today</i>Holiday</a>
    </li>
    @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
    <li class="no-padding to">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('leaves/leave_pending*') ? 'active' : '' ||
            Request::is('leaves/leave_records*') ? 'active' : '' || 
            Request::is('leaves/leave_by_department*') ? 'active' : '' || Request::is('leaves/leave_by_date*') ? 'active' : '' ||
            Request::is('leaves/leave_by_sum*') ? 'active' : '' ||
            Request::is('leaves/leave_by_id*') ? 'active' : ''}}">
                <a class="collapsible-header hr_color"><i class="material-icons pl-15 hr_color">person</i><span class="pl-15">HR Leave</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('leaves/leave_pending*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/leaves/leave_pending">
                                <i class="material-icons hr_color">search</i>Pending
                            </a>
                        </li>
                        <li class="{{ Request::is('leaves/leave_by_sum*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/leaves/leave_by_sum">
                                <i class="material-icons hr_color">search</i>Search by Sum
                            </a>
                        </li>
                        <li class="{{ Request::is('leaves/leave_records*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/leaves/leave_records">
                                <i class="material-icons hr_color">edit</i>Search and Edit
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    @endif
    @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('inleus/in_leu_by_add*') ? 'active' : '' || Request::is('inleus/in_leu_records*') ? 'active' : '' || Request::is('inleus/in_leu_by_department*') ? 'active' : '' || Request::is('inleus/in_leu_by_sum*') ? 'active' : ''}}">
                <a class="collapsible-header hr_color"><i class="material-icons pl-15 hr_color">person</i><span class="pl-15">HR in Leu</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('inleus/in_leu_by_add*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/inleus/in_leu_by_add">
                                <i class="material-icons hr_color">insert_drive_file</i>Add by Dept
                            </a>
                        </li>
                        <li class="{{ Request::is('inleus/in_leu_by_department*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/inleus/in_leu_by_department">
                                <i class="material-icons hr_color">insert_drive_file</i>By Dept
                            </a>
                        </li>
                        <li class="{{ Request::is('inleus/in_leu_by_sum*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/inleus/in_leu_by_sum">
                                <i class="material-icons hr_color">insert_drive_file</i>By Sum
                            </a>
                        </li>
                        <li class="{{ Request::is('inleus/in_leu_records*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/inleus/in_leu_records">
                                <i class="material-icons hr_color">insert_drive_file</i>Add-Edit-Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    @endif
    @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('attendances/attendance_problems*') ? 'active' : '' || Request::is('attendances/att_by_department*') ? 'active' : ''}}">
                <a class="collapsible-header hr_color"><i class="material-icons pl-15 hr_color">person</i><span class="pl-15">HR Attendance</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('attendances/attendance_problems*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/attendances/attendance_problems">
                                <i class="material-icons hr_color">insert_drive_file</i>Edit
                            </a>
                        </li>
                        <li class="{{ Request::is('attendances/att_by_department*') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/attendances/att_by_department">
                                <i class="material-icons hr_color">insert_drive_file</i>Report
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    @endif
    @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")  
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('employees') ? 'active' : '' || Request::is('employee_by_department') ? 'active' : '' ||
            Request::is('employee_verifier_approver') ? 'active' : '' }}">
                <a class="collapsible-header hr_color"><i class="material-icons pl-15 hr_color">supervisor_account</i><span class="pl-15">HR Employee</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('employees') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/employees"><i class="material-icons hr_color">person</i>Single Search</a>
                        </li>
                        <li class="{{ Request::is('employee_by_department') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/employee_by_department"><i class="material-icons hr_color">supervisor_account</i>Dept Search</a>
                        </li>
                        <li class="{{ Request::is('employee_verifier_approver') ? 'active' : '' }}">
                            <a class="waves-effect waves-grey hr_color" href="/employee_verifier_approver"><i class="material-icons hr_color">supervisor_account</i>O.T Approver</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="/users" class="waves-effect waves-grey hr_color"><i class="material-icons hr_color">account_circle</i>HR Users</a>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li class="{{ Request::is('departments*') ? 'active' : '' || Request::is('locations*') ? 'active' : '' || Request::is('functionals*') ? 'active' : '' || Request::is('jobtitles*') ? 'active' : '' || Request::is('reportingmanagers*') ? 'active' : '' || Request::is('nationalities*') ? 'active' : '' || Request::is('reports') ? 'active' : ''}}">
                <a class="collapsible-header hr_color"><i class="material-icons pl-15 hr_color">settings</i><span class="pl-15">Settings</span></a>
                <div class="collapsible-body">
                    <ul>
                        <li class="{{ Request::is('departments*') ? 'active' : '' }}">
                            <a href="/departments" class="waves-effect waves-grey hr_color">
                                <i class="material-icons hr_color">business</i>
                                Department
                            </a>
                        </li>
                        <li class="{{ Request::is('locations*') ? 'active' : '' }}">
                            <a href="/locations" class="waves-effect waves-grey hr_color">
                                <i class="material-icons hr_color">place</i>
                                Location
                            </a>
                        </li>
                        <li class="{{ Request::is('functionals*') ? 'active' : '' }}">
                            <a href="/functionals" class="waves-effect waves-grey hr_color">
                            <i class="material-icons hr_color">functions</i>
                                Function
                            </a>
                        </li>
                        <li class="{{ Request::is('jobtitles*') ? 'active' : '' }}">
                            <a href="/jobtitles" class="waves-effect waves-grey hr_color">
                            <i class="material-icons hr_color">work</i>
                                Job Title
                            </a>
                        </li>
                        <li class="{{ Request::is('reportingmanagers*') ? 'active' : '' }}">
                            <a href="/reportingmanagers" class="waves-effect waves-grey hr_color">
                            <i class="material-icons hr_color">person_pin</i>
                                Reporting Manager
                            </a>
                        </li>
                        <li class="{{ Request::is('nationalities*') ? 'active' : '' }}">
                            <a href="/nationalities" class="waves-effect waves-grey hr_color">
                            <i class="material-icons hr_color">terrain</i>
                                Nationality
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    @endif
</ul>