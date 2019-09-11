<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{public_path('css/materialize.css')}}">
        <title>Employee Management System</title>
        <style>
            td{
                border-top:#9e9e9e 1px solid !important;
                border-bottom:#9e9e9e 1px solid !important;
                border-right:#e0e0e0 1px solid !important;
                border-left:#e0e0e0 1px solid !important; 
            }
            th{
                border-bottom:#212121 1px solid !important;
                border-top:#212121 1px solid !important;
                border-right:#9e9e9e 1px solid !important;
                border-left:#9e9e9e 1px solid !important;
            }
        </style>
    </head>
    <body>
        <h4 class="grey-text text-darken-1 center">Overtime Export</h4>
        <table>
            <thead class="grey-text text-darken-1">
                <tr>
                    <th>Function</th>
                    <th>Staff Name</th>
                    <th>OT Date</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Minute</th>
                    <th>Reason</th>
                    <th>Remark</th>
                    <th>Verify</th>
                    <th>Verifier</th>
                    <th>Approve</th>
                    <th>Approver</th>
                    <th>OT Type</th>
                    <th>Location</th>                   
                </tr>
            </thead>
            <tbody>
                @foreach($ot_records as $ot_record)
                    <tr>
                        <td>{{$ot_record->function_name}}</td>
                        <td>{{$ot_record->staff_name}}</td>
                        <td>{{date("d-M-Y", strtotime($ot_record->ot_date))}}</td>
                        <td>{{$ot_record->time_from}}</td>
                        <td>{{$ot_record->time_to}}</td>
                        <td>{{$ot_record->ot_minute}}</td>
                        <td>{{$ot_record->ot_reason}}</td>
                        <td>{{$ot_record->ot_remark}}</td>
                        <td>{{$ot_record->verify_status}}</td>
                        <td>{{$ot_record->verify_by}}</td>
                        <td>{{$ot_record->approve_status}}</td>
                        <td>{{$ot_record->approve_by}}</td>
                        <td>{{$ot_record->ot_type}}</td>   
                        <td>{{$ot_record->location_name}}</td>                   
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>