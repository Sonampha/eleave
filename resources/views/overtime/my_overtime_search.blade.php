@extends('layouts.app_ot')
@section('content')
<style>
    .right_bold{
        text-align: right; 
        font-weight: bold;
    }
</style>
<div class="container">
    <h4 class="grey-text text-darken-2 center">My Overtimes</h4>
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="/overtime/myovertime" method="POST">
            @csrf()
                <div class="input-field col s10 offset-s1 m4 l4 xl3 offset-xl1">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{date('M d, Y', strtotime($date_from))}}">
                    <label for="date_from">Date From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s10 offset-s1 m4 l4 xl3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{date('M d, Y', strtotime($date_to))}}">
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
                    <!-- Table that shows OT Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>                                
                                <th>Date</th>
                                <th>Staff Name</th>                                
                                <th>From</th>
                                <th>To</th>
                                <th>Minute</th>
                                <th>Reason</th>
                                <th>Verified</th>
                                <th>Approved</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            @if($ot_records->count())                                
                                @foreach($ot_records as $ot_record)
                                    <tr>                                        
                                        <td>{{date("d-M-Y", strtotime($ot_record->ot_date))}}</td>
                                        <td>{{$ot_record->staff_name}}</td>
                                        <td>{{$ot_record->time_from}}</td>
                                        <td>{{$ot_record->time_to}}</td>
                                        <td>{{$ot_record->ot_minute}} mn</td>
                                        <td>{{$ot_record->otReason->ot_reason}}</td>
                                        <td>{{$ot_record->verify_status}}</td> 
                                        <td>{{$ot_record->approve_status == '' ? '-' : $ot_record->approve_status}}</td>                
                                        <td>
                                            <div class="row mb-0">
                                                <div class="col">
                                                    <a href="{{route('overtime.show',$ot_record->id)}}" class="btn btn-small btn-floating waves=effect waves-light teal lighten-2" title="Details"><i class="material-icons">list</i></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> 
                                <?php $total += $ot_record->ot_minute;?> 
                                @endforeach
                                @else
                                    {{-- if there are No Records then show this --}}
                                    <tr>
                                        <td colspan="9"><h6 class="grey-text text-darken-2 center">No O.T Records Found!</h6></td>
                                    </tr>
                                @endif
                                @if($total != 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="right_bold">Total:</td>
                                    <td>{{ $total }} mn</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                @endif
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