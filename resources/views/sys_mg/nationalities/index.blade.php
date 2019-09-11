@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Nationalities</h4>
    
    {{-- Include the searh component with with title and route --}}
    @component('sys_mg.inc.search',['title' => 'Nationality' , 'route' => 'nationalities.search'])
    @endcomponent

    <div class="row">
        <!-- Show All Cationalities List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">Nationalities List</h5>
                    <!-- Table that shows Nationalities List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>
                                <th>ID</th>
                                <th>Country Name</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if there are any Nationalities to render in view -->
                            @if($nationalities->count())
                                @foreach($nationalities as $nationality)
                                    <tr>
                                        <td>{{$nationality->id}}</td>
                                        <td>{{$nationality->country_name}}</td>
                                        <td>{{$nationality->created_at}}</td>
                                        <td>{{$nationality->updated_at}}</td>
                                        <td>
                                            <div class="row mb-0">
                                              <div class="col">
                                                    <a href="{{route('nationalities.edit',$nationality->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                <div class="col">
                                                    <form class="delete" action="{{route('nationalities.destroy',$nationality->id)}}" method="POST">
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
                                <!-- if there are no nationalities then show this message -->
                                <tr>
                                    <td colspan="5"><h6 class="grey-text text-darken-2 center">No Nationalities Found!</h6></td>
                                </tr>
                            @endif
                            @if(isset($search))
                                <tr>
                                    <td colspan="3">
                                        <a href="/nationalities" class="right">Show All</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Departments Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$nationalities->links('vendor.pagination.default',['paginator' => $nationalities])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to department.create view -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('nationalities.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 

    <script src="{{asset('js/jquery.js')}}"></script>
    <script>
        $(".delete").on("submit", function(){
            return confirm("Do you really want to delete?");
        });
    </script>
@endsection