@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Location</h4>
    
    {{-- Include the searh component with with title and route --}}
    @component('sys_mg.inc.search',['title' => 'Location' , 'route' => 'locations.search'])
    @endcomponent

    <div class="row">
        <!-- Show All Departments List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">Locations List</h5>
                    <!-- Table that shows Departments List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>ID</th>
                                <th>Location Code</th>
                                <th>Nick Name</th>
                                <th>Location Address</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if there are any locations to render in view -->
                            @if($locations->count())
                                @foreach($locations as $location)
                                    <tr>
                                        <td>{{$location->id}}</td>
                                        <td>{{$location->location_name}}</td>
                                        <td>{{$location->nick_name}}</td>
                                        <td>{{$location->location_address}}</td>
                                        <td>
                                            <div class="row mb-0">
                                              <div class="col">
                                                    <a href="{{route('locations.edit',$location->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                <div class="col">
                                                    <form onsubmit="return confirm('Do you really want to delete?');" action="{{route('locations.destroy',$location->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf()
                                                        <button type="submit" class="btn btn-floating btn-small waves=effect waves-light red"><i class="material-icons">delete</i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- if there are no locations then show this message -->
                                <tr>
                                    <td colspan="5"><h6 class="grey-text text-darken-2 center">No Locations found yet!</h6></td>
                                </tr>
                            @endif
                            @if(isset($search))
                                <tr>
                                    <td colspan="3">
                                        <a href="/locations" class="right">Show All</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Locations Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$locations->links('vendor.pagination.default',['paginator' => $locations])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to locations.create view -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('locations.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 
@endsection