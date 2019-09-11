@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Add / Edit / Delete</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="{{route('in_leu_records.search1')}}" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3 offset-xl1">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{old('date_from') ? : ''}}">
                    <label for="date_from">Date From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{old('date_to') ? : ''}}">
                    <label for="date_to">Date To</label>
                    <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3 offset-xl1">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">List of In Leu Records</h5>
                    <!-- Table that shows Leave Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>                                
                                <th>Date</th>
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>Day</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($in_leus->count())
                                @foreach($in_leus as $in_leu)
                                    <tr>                                        
                                        <td>{{date("d-M-Y", strtotime($in_leu->inleu_date))}}</td>
                                        <td>{{$in_leu->staff_name}}</td>
                                        <td>{{$in_leu->staff_id}}</td>
                                        <td>{{$in_leu->inleu_day}}</td>
                                        <td>{{$in_leu->reason}}</td> 
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('in_leu_records.show',$in_leu->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2"><i class="material-icons" title="Details">list</i></a>
                                                </div>
                                                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
                                                <div class="col">
                                                    <a href="{{route('in_leu_records.edit',$in_leu->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange" title="Edit"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                @endif
                                                @if(Auth::user()->user_type == "ADMIN")                                               
                                                <div class="col">
                                                    <form onsubmit="return confirm('Do you really want to DELETE?');" action="{{route('in_leu_records.destroy',$in_leu->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf()
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red" title="Delete"><i class="material-icons">delete</i></button>
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
                                {{-- If we are searching then show this link --}}
                        </tbody>
                    </table>
                    <!-- Leave Records Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$in_leus->links('vendor.pagination.default',['paginator' => $in_leus])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to in_leu_records.create view -->

<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('in_leu_records.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 


@endsection