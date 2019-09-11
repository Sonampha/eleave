@extends('layouts.app')
@section('content')
<div class="container">
    <h4 class="grey-text text-darken-2 center">In-Leu by Sum</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="in_leu_by_sum" method="POST">
            @csrf()       
                <div class="input-field col s12 m9 9 x9">
                    <select name="department" id="department">
                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ $department->id == $dep_id ? 'selected' : '' }}>{{$department->dept_name}}
                            </option>
                        @endforeach
                    </select>
                    <label for="department">Department:</label>
                    <span class="{{$errors->has('department') ? 'helper-text red-text' : ''}}">{{$errors->has('department') ? $errors->first('department') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s6 offset-s3 m3 l3 xl3">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <!-- Table that shows Leave Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>  
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>In Leu Day</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($in_leus->count())
                                @foreach($in_leus as $in_leu)
                                    <tr>   
                                        <td>
                                            <a href="/inleus/report/detail?staff_id={{$in_leu->staff_id}}" onclick="NewWindow(this.href,'name','1000','500','yes');return false">
                                            {{$in_leu->staff_name}}</a>
                                        </td>
                                        <td>{{$in_leu->staff_id}}</td>
                                        <td>{{$in_leu->inleu_day}}</td>
                                        <td>{{$in_leu->dept_name}}</td>
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

            </div>
        </div>
        <!-- Card END -->
    </div>
</div>
@endsection