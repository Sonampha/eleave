@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-1 center">Employees by Department</h4>
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">  
            <form action="employee_by_department" method="POST">
            @csrf()       
                <div class="input-field col s12 m9 9 x9">
                    <select name="department" id="department">
                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ old('department') ? 'selected' : '' }} >{{$department->dept_name}}
                        </option>
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
                <h5 class="pl-15 grey-text text-darken-2">Employee List</h5>
                <!-- Table that shows Employee List -->
                <table class="responsive-table col s12 m12 l12 xl12">
                    <thead class="grey-text text-darken-1">
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Job Title</th>                            
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody id="emp-table">
                        <!-- Check if there are any employee to render in view -->
                        @if($employees->count())                            
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->id}}</td>
                                    <td>
                                    <img class="emp-img" src="{{asset('uploads/employee_images/'.$employee->picture)}}">
                                    </td>
                                    <td>{{$employee->staff_name}}</td>
                                    <td>{{$employee->empDepartment->dept_name}}</td>
                                    <td>{{$employee->empJobTitle->job_name}}</td>
                                    <td>
                                    <div class="row mb-0">
                                        <div class="col">
                                            <a href="{{route('employees.show',$employee->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons">list</i></a>
                                        </div>
                                        @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                                        <div class="col">
                                            <a href="{{route('employees.edit',$employee->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange" title="Edit"><i class="material-icons">mode_edit</i></a>
                                        </div>
                                        <div class="col">
                                            <form class="delete" action="{{route('employees.destroy',$employee->id)}}" method="POST">
                                            @method('DELETE')
                                            @csrf()
                                            <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red"><i class="material-icons">delete</i></button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    </td>
                                </tr>                                
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
            <div class="center">
                {{$employees->links('vendor.pagination.default',['paginator' => $employees])}}
            </div>
        </div>
    </div>
    <!-- Card END -->
</div>
<!-- This is the button that is located at the right bottom, that navigates us to employees.create view -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('employees.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 

    <script src="{{asset('js/jquery.js')}}"></script>
    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure to delete this employee?");
        });
    </script>
@endsection