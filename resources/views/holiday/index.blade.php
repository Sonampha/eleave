@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Holiday Management</h4>
    
    {{-- Search --}}
    <div class="row mb-0">
        <ul class="collapsible">
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">search</i>
                    Search Holiday
                </div>
                <div class="collapsible-body">
                    <div class="row mb-0">
                        <form action="{{route('holidays.search')}}" method="POST">
                            @csrf()
                            <div class="input-field col s12 m6 l5 xl6">
                                <input id="search" type="text" name="search" >
                                <label for="search">Search Holiday</label>
                                <span class="{{$errors->has('search') ? 'helper-text red-text' : '' }}">{{$errors->has('search') ? $errors->first('search') : '' }}</span>
                            </div>
                            <div class="input-field col s12 m6 l4 xl4">
                                <select name="options" id="options">
                                    <option value="hol_name">Holiday Name</option>
                                    <option value="day_off">Day Off</option>
                                </select>
                                <label for="options">Search by:</label>
                            </div>
                            <br>
                            <button type="submit" class="btn waves-effect waves-light col s6 offset-s3 m4 offset-m4 l2 xl2">Search</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Holidays List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">List of Holidays</h5>
                    <!-- Table that shows Holidays List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>No.</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Day Off</th>
                                <th>Holiday Name</th>
                                <th>Year</th>
                                @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")  
                                <th>Options</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($holidays->count())
                                <?php $count = 1 ;?>
                                @foreach($holidays as $holiday)
                                    <tr>
                                        <td>{{$count}}</td>
                                        <td>{{date("d-M-Y", strtotime($holiday->date_from))}}</td>
                                        <td>{{date("d-M-Y", strtotime($holiday->date_to))}}</td>
                                        @if($holiday->day_off == 1)
                                            <td>{{$holiday->day_off.' day'}}</td>
                                        @else
                                            <td>{{$holiday->day_off.' days'}}</td>
                                        @endif 
                                        <td>{{$holiday->hol_name}}</td>   
                                        <td>{{$holiday->year}}</td>
                                        @if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")                               
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('holidays.edit',$holiday->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                <div class="col">
                                                    <form class="delete" action="{{route('holidays.destroy',$holiday->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf()
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red"><i class="material-icons">delete</i></button>
                                                       </form>
                                                </div>                                                
                                            </div>
                                        </td>
                                        @endif
                                    </tr>
                                    <?php $count++ ;?>
                                @endforeach
                                @else
                                    {{-- if there are no Holidays then show this message --}}
                                    <tr>
                                        <td colspan="5"><h6 class="grey-text text-darken-2 center">No Holidays Found!</h6></td>
                                    </tr>
                                @endif
                                {{-- If we are searching then show this link --}}
                                @if(isset($search))
                                    <tr>
                                        <td colspan="4">
                                            <a href="/holidays" class="right">Show All</a>
                                        </td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                    <!-- Holidays Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$holidays->links('vendor.pagination.default',['paginator' => $holidays])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to holidays.create view -->
@if(Auth::user()->user_type == "ADMIN" || Auth::user()->user_type == "WEB")
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('holidays.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div>
@endif

    <script src="{{asset('js/jquery.js')}}"></script>
    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure to delete this holiday?");
        });
    </script>
@endsection