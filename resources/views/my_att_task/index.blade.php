@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">My Pending Attendances</h4>
    
    {{-- Search --}}

    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">List of Pending Attendances</h5>
                    <!-- Table that shows Leave Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>From</th>
                                <th>Staff Name</th>
                                <th>Att Status</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($attendance_problems->count())
                                @foreach($attendance_problems as $attendance_problem)
                                    <tr>
                                        <td>{{date("d-M-Y", strtotime($attendance_problem->att_date))}}</td>
                                        <td>{{$attendance_problem->staff_name}}</td>
                                        <td>{{$attendance_problem->att_status}}</td> 
                                        <td>{{$attendance_problem->status}}</td>
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('my_att_tasks.show',$attendance_problem->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                                @if(Auth::user()->user_type != "USER")
                                                <div class="col">
                                                    <form action="{{route('my_att_tasks.approve',$attendance_problem->id)}}" method="POST">
                                                        @csrf()
                                                        <input type="hidden" id="status" name="status" value="Approved" />
                                                        <button type="submit" title="Approve" class="btn btn-floating btn-small waves=effect waves-light green"><i class="material-icons">done</i></button>
                                                       </form>
                                                </div>                                          
                                                <div class="col">
                                                    <form action="{{route('my_att_tasks.reject',$attendance_problem->id)}}" method="POST">
                                                        @csrf()
                                                        <input type="hidden" id="status" name="status" value="Rejected" />
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red" title="Reject"><i class="material-icons">not_interested</i></button>
                                                       </form>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>                             
                                @endforeach
                                @else
                                    {{-- if there are no Leave Records then show this message --}}
                                    <tr>
                                        <td colspan="5"><h6 class="grey-text text-darken-2 center">No Leave Records Found!</h6></td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                    <!-- Leave Records Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$attendance_problems->links('vendor.pagination.default',['paginator' => $attendance_problems])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection