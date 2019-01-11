@extends('layouts.app')
@section('content')
    <br>
    <div>
        <div class="row white-text">

                <div class="mx-20 card-panel pink lighten-1 col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2 offset-xl1 ml-14">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">person</i>
                            <h6 class="no-padding txt-md">Employee Name</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-sm">
                                {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-20 card-panel teal lighten-1 col s8 offset-s2 m4 l4 xl2">                  
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">person</i>
                            <h6 class="no-padding txt-md">Line Manager</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-sm">Kheng Sarath</p>
                        </div>
                    </div>
                </div>

                <div class="mx-20 card-panel red lighten-1 col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">person_outline</i>
                            <h6 class="no-padding txt-md">ID <br>Login</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-sm">{{ Auth::user()->username }}</p>
                        </div>
                    </div>
                </div>

                <div class="mx-20 card-panel purple lighten-1 col s8 offset-s2 m4 l4 xl2">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">work</i>
                            <h6 class="no-padding txt-md">Working Day</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-sm">MON - FRI</p>
                        </div>
                    </div>
                </div>

                <div class="mx-20 card-panel light-blue col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2 offset-xl1 ml-14">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 class="no-padding txt-md">Leave Entitlement</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-big">2</p>
                        </div>
                    </div>
                </div>

                <div class="card-panel green col s8 offset-s2 m4 l4 xl2 mx-20">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 class="no-padding txt-md">Leave Taken</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-big">0</p>
                        </div>
                    </div>
                </div>           
            
                <div class="card-panel blue col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2 mx-20">
                    <div class="row">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 class="no-padding txt-md">Leave Balance</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-big">2</p>
                        </div>
                    </div>
                </div>            
           
                <div class="mx-20 card-panel orange col s8 offset-s2 m4 l4 xl2">
                    <div class="row" style="margin-bottom: 39px;">
                        <div class="col s7 xl5">
                            <i class="material-icons medium white-text pt-5">date_range</i>
                            <h6 class="no-padding txt-md">Current Date</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p class="no-padding center mt txt-sm">{{$current_date}}</p>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-panel">
            <div class="row">
                <form class="col s12" id="reg-form">
                <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">storage</i>
                    <select class="validate" required>
                        <option value="" disabled selected>Choose Leave Types</option>
                        @foreach($tbl_leave_type as $leave_type)
                        <option value="{{ $leave_type->LEAVE_ID }}">{{ $leave_type->LEAVE_TYPE }}</option>
                        @endforeach
                    </select>
                    <label>Leave Type</label>
                </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="leave_from" id="leave_from" class="datepicker" value="{{old('leave_from') ? : ''}}">
                        <label for="leave_from">Leave From</label>
                        <span class="{{$errors->has('leave_from') ? 'helper-text red-text' : ''}}">{{$errors->has('leave_from') ? $errors->first('leave_from') : ''}}</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="leave_to" id="leave_to" class="datepicker" value="{{old('leave_to') ? : ''}}">
                        <label for="leave_to">Leave To</label>
                        <span class="{{$errors->has('leave_to') ? 'helper-text red-text' : ''}}">{{$errors->has('leave_to') ? $errors->first('leave_to') : ''}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class = "material-icons prefix">mode_edit</i>
                        <textarea id="reason" class="materialize-textarea" class="validate" required></textarea>
                        <label for="reason">Leave Reason</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input class="with-gap" name="daytype" type="radio" checked />
                            <span>Full Day</span>
                          </label>
                        </p>
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input class="with-gap" name="daytype" type="radio" />
                            <span>AM</span>
                          </label>
                        </p>
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input class="with-gap" name="daytype" type="radio"  />
                            <span>PM</span>
                          </label>
                        </p>
                    </div>
                    <div class="input-field col s6">
                        <div>
                            <label for="leave-applied">Leave Applied</label>                        
                            <input id="leave-applied" type="text" value="Pending for submission" disabled>
                             
                        </div>
                        <div>
                            <label for="status">Status</label>
                            <input id="status" type="text" value="day(s)" disabled>
                        </div>
                        <div>
                            <label for="new-balance">New Balance</label>
                            <input id="new-balance" type="text" value="day(s)" disabled>               
                        </div>               
                    </div>
                </div>

                <a href="/" class="waves-effect waves-light btn-large"><i class="material-icons right">cancel</i>Cancel</a>
                <a class="waves-effect waves-light btn-large"><i class="material-icons right">send</i>Submit</a>
                </form>
            </div>
        </div>
    </div>
    <br>
    {{-- include the chart.js Library --}}
    <script src="{{asset('js/Chart.js')}}"></script>    
    {{-- Create the chart with javascript using canvas --}}
@endsection