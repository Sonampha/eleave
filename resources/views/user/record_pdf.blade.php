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
                    <th>username</th>
                    <th>full_name</th>
                    <th>user_type</th>
                    <th>email</th>
                    <th>password</th>                   
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->username}}</td>
                        <td>{{$user->full_name}}</td>
                        <td>{{$user->user_type}}</td>
                        <td>{{$user->email}}</td> 
                        <td>{{$user->password}}</td>                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>