@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Update Employee</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('employees.update',$employee->id)}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{old('staff_id') ? : $employee->staff_id}}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="staff_name" id="staff_name" value="{{old('staff_name') ? : $employee->staff_name}}">
                                <label for="staff_name">Staff Name</label>
                                <span class="{{$errors->has('staff_name') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_name')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">face</i>
                                <select name="gender">
                                    <option value="" disabled>Choose ...</option>
                                    <!--
                                        make the option active which matches the employee gender
                                    -->
                                    @foreach($genders as $gender)
                                        <option value="{{$gender->id}}" {{old('gender') ? 'selected' : '' }} {{ $employee->empGender==$gender ? 'selected' : '' }} >{{$gender->gender_name}}</option>
                                    @endforeach
                                </select>
                                <label>Gender</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">flag</i>
                                <select name="nationality">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{$nationality->id}}" {{ old('nationality') ? 'selected' : '' }} {{ $employee->empNationality==$nationality ? 'selected' : '' }} >{{$nationality->country_name}}</option>
                                    @endforeach
                                </select>
                                <label>Nationality</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="birth_date" id="birth_date" class="datepicker" value="{{Request::old('birth_date') ? : $employee->birth_date}}">
                                <label for="birth_date">Date of birth</label>
                                <span class="{{$errors->has('birth_date') ? 'helper-text red-text' : ''}}">{{$errors->has('birth_date') ? $errors->first('birth_date') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" value="{{old('email') ? : $employee->email}}">
                                <label for="email">Email</label>
                                <span class="{{$errors->has('email') ? 'helper-text red-text' : ''}}">{{$errors->has('email') ? $errors->first('email') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">smartphone</i>
                                <input type="text" name="phone" id="phone" value="{{old('phone') ? : $employee->phone}}">
                                <label for="phone">Phone</label>
                                <span class="{{$errors->has('phone') ? 'helper-text red-text' : ''}}">{{$errors->has('phone') ? $errors->first('phone') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">location_on</i>
                                <textarea name="address" id="address" class="materialize-textarea" >{{Request::old('address') ? : $employee->address}}</textarea>
                                <label for="address">Address</label>
                                <span class="{{$errors->has('address') ? 'helper-text red-text' : ''}}">{{$errors->has('address') ? $errors->first('address') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="join_date" id="join_date" class="datepicker" value="{{Request::old('join_date') ? : $employee->join_date}}">
                                <label for="join_date">date joined</label>
                                <span class="{{$errors->has('join_date') ? 'helper-text red-text' : ''}}">{{$errors->has('join_date') ? $errors->first('join_date') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">business</i>
                                <select name="department">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{old('department') ? 'selected' : ''}} {{ $employee->empDepartment==$department ? 'selected' : '' }} >{{$department->dept_name}}</option>
                                    @endforeach
                                </select>
                                <label>Department</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">functions</i>
                                <select name="functional">
                                    <option value="" disabled >Choose ...</option>
                                    @foreach($functionals as $functional)
                                        <option value="{{$functional->id}}" {{ old('functional') ? 'selected' : '' }} {{ $employee->empfunctional==$functional ? 'selected' : '' }} >{{$functional->function_name}}</option>
                                    @endforeach
                                </select>
                                <label>Function</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">work</i>
                                <select name="jobtitle">
                                    <option value="" disabled >Choose ...</option>
                                    @foreach($jobtitles as $jobtitle)
                                        <option value="{{$jobtitle->id}}" {{ old('jobtitle') ? 'selected' : '' }} {{ $employee->empJobTitle==$jobtitle ? 'selected' : '' }} >{{$jobtitle->job_name}}</option>
                                    @endforeach
                                </select>
                                <label>Job Title</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">location_city</i>
                                <select name="location">
                                    <option value="" disabled >Choose ...</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}" {{ $employee->empLocation==$location ? 'selected' : '' }}>{{$location->location_name}}</option>
                                    @endforeach
                                </select>
                                <label>Location</label>
                            </div>                            
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person_pin</i>
                                <select name="reporting_manager">
                                    <option value="" disabled>Choose ...</option>
                                    @foreach($reporting_managers as $reporting_manager)
                                        <option value="{{$reporting_manager->id}}" {{old('reporting_manager') ? 'selected' : ''}} {{ $employee->empReportingManager==$reporting_manager ? 'selected' : '' }} >{{$reporting_manager->manager_name}}</option>
                                    @endforeach
                                </select>
                                <label>Reporting Manager</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">work</i>
                                <select name="work_day">
                                    <option value="" disabled >Choose ...</option>
                                    <option value="Mon-Fri" {{ $employee->work_day=="Mon-Fri" ? 'selected' : '' }}>Mon-Fri</option>
                                    <option value="Mon-Sat" {{ $employee->work_day=="Mon-Sat" ? 'selected' : '' }}>Mon-Sat</option>                          
                                </select>
                                <label>Work-Day</label>
                            </div>                            
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">swap_horiz</i>
                                <select name="direct_report">
                                    <option value="" disabled >Choose ...</option>
                                    <option value="1" {{ $employee->have_direct_report==1 ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ $employee->have_direct_report==0 ? 'selected' : '' }}>No</option>                              
                                </select>
                                <label>Direct Report</label>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="ann_leave" id="ann_leave" value="{{old('ann_leave') ? : $employee->ann_leave}}">
                                <label for="ann_leave">Annual Leave</label>
                                <span class="{{$errors->has('ann_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('ann_leave') ? $errors->first('ann_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="sick_leave" id="sick_leave" value="{{old('sick_leave') ? : $employee->sick_leave}}">
                                <label for="sick_leave">Sick Leave</label>
                                <span class="{{$errors->has('sick_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('sick_leave') ? $errors->first('sick_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="mat_leave" id="mat_leave" value="{{old('mat_leave') ? : $employee->mat_leave}}">
                                <label for="mat_leave">Maternity Leave</label>
                                <span class="{{$errors->has('mat_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('mat_leave') ? $errors->first('mat_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="hop_leave" id="hop_leave" value="{{old('hop_leave') ? : $employee->hop_leave}}">
                                <label for="hop_leave">Hospitalization Leave</label>
                                <span class="{{$errors->has('hop_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('hop_leave') ? $errors->first('hop_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="unp_leave" id="unp_leave" value="{{old('unp_leave') ? : $employee->unp_leave}}">
                                <label for="unp_leave">Unpaid Leave</label>
                                <span class="{{$errors->has('unp_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('unp_leave') ? $errors->first('unp_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="spec_leave" id="spec_leave" value="{{old('spec_leave') ? : $employee->spec_leave}}">
                                <label for="spec_leave">Special Leave</label>
                                <span class="{{$errors->has('spec_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('spec_leave') ? $errors->first('spec_leave') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="carry_leave" id="carry_leave" value="{{old('carry_leave') ? : $employee->carry_leave}}">
                                <label for="carry_leave">Carry Forward</label>
                                <span class="{{$errors->has('carry_leave') ? 'helper-text red-text' : ''}}">{{$errors->has('carry_leave') ? $errors->first('carry_leave') : ''}}</span>
                            </div>
                            <div class="file-field input-field col s12 m12 l12 x20">
                                <div class="btn">
                                    <span>Picture</span>
                                    <input type="file" name="picture">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="{{Request::old('picture') ? : '' }}">
                                    <span class="{{$errors->has('picture') ? 'helper-text red-text' : ''}}">{{$errors->has('picture') ? $errors->first('picture') : ''}}</span>
                                </div>
                            </div>
                        </div>
                        @method('PUT')
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Update</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/employees">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection