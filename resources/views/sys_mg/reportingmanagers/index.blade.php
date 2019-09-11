@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">Reporting Manager</h4>

    {{-- Include the searh component with with title and route --}}
    @component('sys_mg.inc.search',['title' => 'Reporting Manager' , 'route' => 'reportingmanagers.search'])
    @endcomponent

    <div class="row">
        <!-- Show All Reporting Managers List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">Reporting Managers List</h5>
                    <!-- Table that shows Reporting Managers List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-1">
                            <tr>
                                <th>ID</th>
                                <th>Manager Name</th>
                                <th>Email</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="item-table">
                            <!-- Check if there are any Reporting Managers to render in view -->
                            @if($reportingmanagers->count())
                                @foreach($reportingmanagers as $reportingmanager)
                                    <tr>
                                        <td>{{$reportingmanager->id}}</td>
                                        <td>{{$reportingmanager->manager_name}}</td>
                                        <td>{{$reportingmanager->email}}</td>
                                        <td>{{$reportingmanager->created_at}}</td>
                                        <td>{{$reportingmanager->updated_at}}</td>
                                        <td>
                                            <div class="row mb-0">
                                              <div class="col">
                                                    <a href="{{route('reportingmanagers.edit',$reportingmanager->id)}}" class="btn btn-floating btn-small waves=effect waves-light orange"><i class="material-icons">mode_edit</i></a>
                                                </div>
                                                <div class="col">
                                                    <form onsubmit="return confirm('Do you really want to delete?');" action="{{route('reportingmanagers.destroy',$reportingmanager->id)}}" method="POST">
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
                                <!-- if there are no Reporting Managers then show this message -->
                                <tr>
                                    <td colspan="5"><h6 class="grey-text text-darken-2 center">No Reporting Managers  found!</h6></td>
                                </tr>
                            @endif
                            @if(isset($search))
                                <tr>
                                    <td colspan="4">
                                        <a href="/reportingmanagers" class="right">Show All</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Reporting Managers Table END -->
                </div>
                <!-- Show Pagination Links -->
                <div class="center">
                  {{$reportingmanagers->links('vendor.pagination.default',['paginator' => $reportingmanagers])}}
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>
</div>


<!-- This is the button that is located at the right bottom, that navigates us to reportingmanager.create view -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves=effect waves-light red" href="{{route('reportingmanagers.create')}}">
        <i class="large material-icons">add</i>
    </a>
</div> 
@endsection