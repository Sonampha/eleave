@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Create New Employee</h4>
                </div>
                <hr>
                <div class="card-content">
                    <form action="{{route('employees.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" name="staff_id" id="staff_id" value="{{Request::old('staff_id') ? : ''}}">
                                <label for="staff_id">Staff ID</label>
                                <span class="{{$errors->has('staff_id') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_id')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="staff_name" id="staff_name" value="{{Request::old('staff_name') ? : ''}}">
                                <label for="staff_name">Staff Name</label>
                                <span class="{{$errors->has('staff_name') ? 'helper-text red-text' : ''}}">{{$errors->first('staff_name')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">face</i>
                                <select name="gender" class="validate" required>
                                    <option value="" disabled {{ old('gender')? '' : 'selected' }}>Choose ...</option>
                                    @foreach($genders as $gender)
                                        <option value="{{$gender->id}}" {{ old('gender') == $gender->id ? 'selected' : '' }}>{{$gender->gender_name}}</option>
                                    @endforeach
                                </select>
                                <label>Gender</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">flag</i>
                                <select name="nationality" class="validate" required>
                                    <option value="" disabled {{ old('nationality') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{$nationality->id}}" {{ old('nationality') == $nationality->id ? 'selected' : '' }} >{{$nationality->country_name}}</option>
                                    @endforeach
                                </select>
                                <label>Nationality</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="birth_date" id="birth_date" class="datepicker" value="{{Request::old('birth_date') ? : ''}}">
                                <label for="birth_date">Date of birth</label>
                                <span class="{{$errors->has('birth_date') ? 'helper-text red-text' : ''}}">{{$errors->has('birth_date') ? $errors->first('birth_date') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" value="{{Request::old('email') ? : ''}}">
                                <label for="email">Email</label>
                                <span class="{{$errors->has('email') ? 'helper-text red-text' : ''}}">{{$errors->has('email') ? $errors->first('email') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">smartphone</i>
                                <input type="number" name="phone" id="phone" value="{{Request::old('phone') ? : ''}}">
                                <label for="phone">Phone</label>
                                <span class="{{$errors->has('phone') ? 'helper-text red-text' : ''}}">{{$errors->has('phone') ? $errors->first('phone') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">location_on</i>
                                <textarea name="address" id="address" class="materialize-textarea" >{{Request::old('address') ? : ''}}</textarea>
                                <label for="address">Address</label>
                                <span class="{{$errors->has('address') ? 'helper-text red-text' : ''}}">{{$errors->has('address') ? $errors->first('address') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">date_range</i>
                                <input type="text" name="join_date" id="join_date" class="datepicker" value="{{old('join_date') ? : ''}}">
                                <label for="join_date">Date Joined</label>
                                <span class="{{$errors->has('join_date') ? 'helper-text red-text' : ''}}">{{$errors->has('join_date') ? $errors->first('join_date') : ''}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">business</i>
                                <select name="department" id="department" class="validate" required>
                                    <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{ old('department') == $department->id ? 'selected' : '' }}>{{$department->dept_name}}</option>
                                    @endforeach
                                </select>
                                <label>Department</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">functions</i>
                                <select name="functional" id="functional" class="validate" required>
                                    <option value="" disabled>Choose ...</option>
                                </select>
                                <label>Function</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">work</i>
                                <select name="jobtitle" id="jobtitle" class="validate" required>
                                    <option value="" disabled>Choose ...</option>
                                </select>
                                <label>Job Title</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">location_city</i>
                                <select name="location" class="validate" required>
                                    <option value="" disabled {{ old('location') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}" {{ old('location') == $location->id ? 'selected' : '' }} >{{$location->location_name}}</option>
                                    @endforeach
                                </select>
                                <label>location</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">person_pin</i>
                                <select name="reporting_manager" class="validate" required>
                                    <option value="" disabled {{ old('reporting_manager') ? '' : 'selected' }}>Choose ...</option>
                                    @foreach($reporting_managers as $reporting_manager)
                                        <option value="{{$reporting_manager->id}}" {{ old('reporting_manager') == $reporting_manager->id ? 'selected' : '' }}>{{$reporting_manager->manager_name}}</option>
                                    @endforeach
                                </select>
                                <label>Reporting Manager</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">work</i>
                                <select name="work_day" class="validate" required>
                                    <option value="" disabled {{ old('work_day') ? '' : 'selected' }}>Choose ...</option>                
                                    <option value="Mon-Fri" {{ old('work_day') == "Mon-Fri" ? 'selected' : '' }}>Mon-Fri</option>
                                    <option value="Mon-Sat" {{ old('work_day') == "Mon-Sat" ? 'selected' : '' }}>Mon-Sat</option>         
                                </select>
                                <label>Work-Day</label>
                            </div>
                            <div class="input-field col s12 m6 l6">
                                <i class="material-icons prefix">swap_horiz</i>
                                <select name="direct_report" class="validate" required>
                                    <option value="" disabled {{ old('direct_report') ? '' : 'selected' }}>Choose ...</option>                
                                    <option value="1" {{ old('direct_report') == "1" ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ old('direct_report') == "0" ? 'selected' : '' }}>No</option>         
                                </select>
                                <label>Direct Report</label>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="ann_leave" min="0" max="30" value="" step="0.5" id="ann_leave" value="{{Request::old('ann_leave') ? : ''}}">
                                <label for="ann_leave">Annual Leave</label>
                                <span class="{{$errors->has('ann_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('ann_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="sick_leave" min="0" max="30" step="0.5" id="sick_leave" value="{{Request::old('sick_leave') ? : ''}}">
                                <label for="sick_leave">Sick Leave</label>
                                <span class="{{$errors->has('sick_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('sick_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="mat_leave" min="0" max="90" step="0.5" id="mat_leave" value="{{Request::old('mat_leave') ? : ''}}">
                                <label for="mat_leave">Maternity Leave</label>
                                <span class="{{$errors->has('mat_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('mat_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="hop_leave" min="0" max="30" step="0.5" id="hop_leave" value="{{Request::old('hop_leave') ? : ''}}">
                                <label for="hop_leave">Hospitalization Leave</label>
                                <span class="{{$errors->has('hop_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('hop_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="unp_leave" min="0" max="30" step="0.5" id="unp_leave" value="{{Request::old('unp_leave') ? : ''}}">
                                <label for="unp_leave">Unpaid Leave</label>
                                <span class="{{$errors->has('unp_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('unp_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="spec_leave" min="0" max="30" step="0.5" id="spec_leave" value="{{Request::old('spec_leave') ? : ''}}">
                                <label for="spec_leave">Special Leave</label>
                                <span class="{{$errors->has('spec_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('spec_leave')}}</span>
                            </div>
                            <div class="input-field col s12 m6 l6 xl3">
                                <i class="material-icons prefix">control_point</i>
                                <input type="number" name="carry_leave" min="0" max="30" step="0.5" id="carry_leave" value="{{Request::old('carry_leave') ? : ''}}">
                                <label for="carry_leave">Carry Forward</label>
                                <span class="{{$errors->has('carry_leave') ? 'helper-text red-text' : ''}}">{{$errors->first('carry_leave')}}</span>
                            </div>
                            <div class="file-field input-field col s12 m12 l12 x20">
                                <div class="btn">
                                    <span>Picture</span>
                                    <input type="file" name="picture">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" value="{{old('picture') ? : '' }}">
                                    <span class="{{$errors->has('picture') ? 'helper-text red-text' : ''}}">{{$errors->has('picture') ? $errors->first('picture') : ''}}</span>
                                </div>
                            </div>
                        </div>
                        @csrf()
                        <div class="row">
                            <button type="submit" class="btn waves-effect waves-light col s8 offset-s2 m4 offset-m4 l4 offset-l4 xl4 offset-xl4">Add</button>
                        </div>
                    </form>
                </div>
                <div class="card-action">
                    <a href="/employees">Go Back</a>
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('js/jquery.js')}}"></script>
<script>
$(document).ready(function(){    
    $(document).on("change", '#department', function(e) {         
        var dept_id = $("#department").val();  
        $('#jobtitle').html('<option value="" disabled selected>Choose ...</option>');
        $('#jobtitle').formSelect()

        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/employee/filter_dept",
            data:{dept_id:dept_id},
            dataType: 'json',
            success: function(data)
            {
                var options = '<option value="" disabled selected>Choose ...</option>';
                console.log(data);
                $.each(data, function(){
                    options += '<option value="' + this.id + '">' + this.function_name + '</option>';
                });
                $('#functional').html(options); 
                $('#functional').formSelect()
            },
            error: function(e) 
            {
                alert('Error: ' + e);
            }
        });
    });

    $(document).on("change", '#functional', function(e) {         
        var function_id = $("#functional").val();  

        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/employee/filter_funct",
            data:{function_id:function_id},
            dataType: 'json',
            success: function(data)
            {
                var options = '<option value="" disabled selected>Choose ...</option>';
                console.log(data);
                $.each(data, function(){
                    options += '<option value="' + this.id + '">' + this.job_name + '</option>';
                });
                $('#jobtitle').html(options); 
                $('#jobtitle').formSelect()
            },
            error: function(e) 
            {
                alert('Error: ' + e);
            }
        });
    });

});
</script>
@endsection