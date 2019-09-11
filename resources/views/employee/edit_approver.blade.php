@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card col s12 m12 l12 xl12 mt-20">
                <div>
                <h4 class="center grey-text text-darken-2 card-title">Edit Verifier and Approver</h4>
                </div>
                
                <div class="card-content">
                    <form action="{{route('employees.post_approver')}}" method="POST" enctype="multipart/form-data">
                        @csrf()
                        <div class="row">
                            <div class="input-field col s12 m3">&nbsp;</div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <input type="text" disabled name="staff_id" id="staff_id" value="{{$employee->staff_id}}">
                                <input type="text" hidden="hidden" name="employee_id" id="employee_id" value="{{$employee->id}}">
                                <label for="disabled">Staff ID</label>
                            </div>
                            <div class="input-field col s12 m3">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m3">&nbsp;</div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" disabled name="staff_name" id="staff_name" value="{{$employee->staff_name}}">
                                <label for="disabled">Staff Name</label>
                            </div>
                            <div class="input-field col s12 m3">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m3">&nbsp;</div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="verifier" id="verifier" value="{{$employee->ot_verifier}}">
                                <label for="verifier">Verifier</label>
                                <span class="{{$errors->has('verifier') ? 'helper-text red-text' : ''}}">{{$errors->first('verifier')}}</span>
                            </div>
                            <div class="input-field col s12 m3">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m3">&nbsp;</div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="approver" id="approver" value="{{$employee->ot_approver}}">
                                <label for="approver">Approver</label>
                                <span class="{{$errors->has('approver') ? 'helper-text red-text' : ''}}">{{$errors->first('approver')}}</span>
                            </div>
                            <div class="input-field col s12 m3">&nbsp;</div>
                        </div>                        
                      <div class = "row">
                         <div class = "col m3 center">&nbsp;</div>
                         <div class = "col m6 center">
                            <button type="submit" class="btn waves-effect waves-light">Update</button>
                         </div>
                         <div class = "col m3 center">&nbsp;</div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection