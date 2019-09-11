@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-1 center">Employees by Department</h4>
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">  
            <form action="employee_verifier_approver" method="POST">
            @csrf()       
                <div class="input-field col s12 m9 9 x9">
                    <select name="department">
                        <option value="" disabled>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ $department->id == $dept_id ? 'selected' : '' }}>{{$department->dept_name}}</option>
                        @endforeach
                    </select>
                    <label for="department">Department:</label>
                    <span class="{{$errors->has('department') ? 'helper-text red-text' : ''}}">{{$errors->has('department') ? $errors->first('department') : ''}}</span>
                </div>
                <br>
                <button id="submit_search" class="btn col s12 m2 2 x2">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
        <!-- Show All Employee List as a Card -->
    <div class="card">
        <div class="card-content">
            <div class="row">
                <h5 class="pl-15 grey-text text-darken-2">{{$dept_name}}</h5>
                <!-- Table that shows Employee List -->
                <table class="responsive-table col s12 m12 l12 xl12">
                    <thead class="grey-text text-darken-1">
                        <tr>
                            <th>No.</th>
                            <th>Staff Name</th>
                            <th>Verifier</th>
                            <th>Approver</th>
                            <th>Department</th>                            
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="emp-table">
                        <!-- Check if there are any employee to render in view -->
                        @if($employees->count())  
                            <?php $num = 1;?>                          
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$num}}</td>
                                    <td>{{$employee->staff_name}}</td>     
                                    <td>{{$employee->ot_verifier == '' ? '-' : $employee->ot_verifier}}</td>
                                    <td>{{$employee->ot_approver == '' ? '-' : $employee->ot_approver}}</td>
                                    <td>{{$employee->empDepartment->dept_name}}</td>
                                    <td>
                                    <div class="row mb-0">
                                        @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                                        <div class="col">
                                            <a href="{{route('employees.edit_approver',$employee->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange" title="Edit"><i class="material-icons">mode_edit</i></a>
                                        </div>
                                        @endif
                                    </div>
                                    </td>
                                </tr>
                                <?php $num++;?>                                 
                            @endforeach
                        @else
                            {{-- if there are no employees then show this message --}}
                            <tr>
                                <td colspan="5"><h6 class="grey-text text-darken-2 center">No Employees Found!</h6></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <!-- employees Table END -->
            </div>
            <!-- Show Pagination Links -->

        </div>
    </div>
    <!-- Card END -->
</div>
@endsection