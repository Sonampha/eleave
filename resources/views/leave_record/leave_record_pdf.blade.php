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
        <h4 class="grey-text text-darken-1 center">Employee Hired Report</h4>
        <table>
            <thead class="grey-text text-darken-1">
                <tr>
                    <th>From</th>
                    <th>To</th>
                    <th>Day-Off</th>
                    <th>Unit</th>
                    <th>Staff Name</th>
                    <th>Leave Type</th>
                    <th>Status</th>                   
                </tr>
            </thead>
            <tbody>
                @foreach($leave_records as $leave_record)
                    <tr>
                        <td>{{date("d-M-Y", strtotime($leave_record->date_from))}}</td>
                        <td>{{date("d-M-Y", strtotime($leave_record->date_to))}}</td>
                        <td>{{$leave_record->day_off}}</td>
                        <td>{{$leave_record->unit}}</td>
                        <td>{{$leave_record->staff_name}}</td>
                        <td>{{$leave_record->leave_type}}</td> 
                        <td>{{$leave_record->status}}</td>                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>