@extends('layouts.app_ot')
@section('content')
    <style>
        .row .col.offset-xl2 {
            margin-left: 35%;
        }
        .row .col.xl3 {
            width: 30%;
        }
    </style>
    <?php

        function pluralize( $count, $text ) 
        { 
            return $count . ( ( $count == 1 ) ? ( " $text" ) : ( " ${text}s" ) );
        }

        function ago( $datetime )
        {
            $interval = date_create('now')->diff( $datetime );
            $suffix = ( $interval->invert ? ' ago' : '' );
            if ( $v = $interval->y >= 1 ) return pluralize( $interval->y, 'year' ) . $suffix;
            if ( $v = $interval->m >= 1 ) return pluralize( $interval->m, 'month' ) . $suffix;
            if ( $v = $interval->d >= 1 ) return pluralize( $interval->d, 'day' ) . $suffix;
            if ( $v = $interval->h >= 1 ) return pluralize( $interval->h, 'hour' ) . $suffix;
            if ( $v = $interval->i >= 1 ) return pluralize( $interval->i, 'minute' ) . $suffix;
            return pluralize( $interval->s, 'second' ) . $suffix;
        }

    ?>
    <div class="container">
        <div class="card-panel grey-text text-darken-2 mt-20">
            <h4 class="grey-text text-darken-1 center">Overtime Details</h4>
            <div class="row">
            <br><br>
            <table class = "striped bordered" style="width:50%">
                <tbody>
                <tr>
                    <th>Submit Date</th>
                    <td>{{date("d-M-Y h:i:s A", strtotime($ot_record->submit_date))}} ({{ago( new DateTime($ot_record->submit_date) )}})</td>
                </tr>
                <tr>
                    <th>Staff Name</th>
                    <td>{{$ot_record->staff_name}}</td>
                </tr>
                <tr>
                    <th>Staff ID</th>
                    <td>{{$ot_record->staff_id}}</td>
                </tr>
                </tbody>
            </table>
                <br><br><br>

                <table class = "striped bordered">
                    <thead>
                    <tr>
                        <th>O.T Date</th>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Minute</th>
                        <th>Reason</th>
                        <th>Remark</th>
                    </tr>
                    </thead>                 
                    <tbody>
                    <tr>
                        <td>{{date("d-M-Y", strtotime($ot_record->ot_date))}}</td>
                        <td>{{$ot_record->ot_type}}</td>
                        <td>{{$ot_record->time_from}}</td>
                        <td>{{$ot_record->time_to}}</td>
                        <td>{{$ot_record->ot_minute}} mn</td>
                        <td>{{$ot_record->otReason->ot_reason}}</td>
                        <td>{{$ot_record->ot_remark}}</td>
                    </tr>
                    </tbody>
                </table>

                <br><br><br>
              <table class = "striped bordered" style="width:80%">
                    <tbody>
                    <tr>
                        <th style="width:40%">Verifier</th>
                        <th style="width:40%">Approver</th>
                    </tr>
                    <tr>
                       <td>Status: {{$ot_record->verify_status == '' ? '-' : $ot_record->verify_status}}</td>
                       <td>Status: {{$ot_record->approve_status}}</td>                      
                    </tr>
                    <tr>
                        <td>Name: {{$ot_record->verify_by}}</td>
                        <td>Name: {{$ot_record->approve_by}}</td>
                    </tr> 
                    <tr>
                       <td>Date: {{$ot_record->verify_status == 'Pending' ? '' : date("d-M-Y h:i:s A", strtotime($ot_record->verify_date))}}</td>
                       <td>Date: {{$ot_record->approve_date == '' ? '' : date("d-M-Y h:i:s A", strtotime($ot_record->approve_date))}}</td>
                    </tr>                  
                 </tbody>
              </table>

                @if($ot_record->verify_status == "Pending" && Auth::user()->user_type == "USER")
                <form action="{{route('overtime.cancel',$ot_record->id)}}" method="POST">
                    @csrf()
                    <input type="hidden" id="status" name="status" value="Cancelled" />
                    <button class="btn green col s3 offset-s2 m3 offset-m2 l3 offset-l2 xl3 offset-xl2" type="submit">Cancel Request</button>
                </form>
                @endif

            </div>
        </div>
    </div>
@endsection