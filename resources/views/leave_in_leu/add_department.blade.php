@extends('layouts.app')
@section('content')
<style>
    #date_reason_table{display: none;}
    td, th {padding: 5px 5px;}
    [type="checkbox"] + span:not(.lever) {
        height: 15px;
    }
</style>
<div class="container">
    <h4 class="grey-text text-darken-2 center">Multiple Add</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">            
                <div class="input-field col s12 m9 9 x9">
                    <select name="department" id="department">
                        <option value="" disabled {{ old('department') ? '' : 'selected' }}>Choose ...</option>
                        @foreach($departments as $department)
                            <option value="{{$department->id}}" {{ old('department') ? 'selected' : '' }} >{{$department->dept_name}}
                        </option>
                        @endforeach
                    </select>
                    <label for="department">Department:</label>
                    <span class="{{$errors->has('department') ? 'helper-text red-text' : ''}}">{{$errors->has('department') ? $errors->first('department') : ''}}</span>
                </div>
                <br>
                <button id="submit_search" class="btn col s12 m2 2 x2">Search</button>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All Leave Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <h5 class="pl-15 grey-text text-darken-2">Staff by Department</h5>
                    <!-- Table that shows Leave Records List -->
                    <table id="employeeTable" class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>    
                                <th>No.</th>                           
                                <th>                                    
                                    <label><input type="checkbox" id="selectall" class="filled-in selectBox" unchecked value="yes" /><span></span></label>
                                    Select All
                                </th>
                                <th>Staff Name</th>
                                <th>Staff ID</th>
                                <th>Department</th>
                                <th>Days</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <!-- Leave Records Table END -->
                </div>
            </div>
        </div>
        <!-- Card END -->
    </div>

    <div class="row" id="date_reason_table">
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row">
                    <table class="responsive-table col s12 m12 l12 xl12">
                            <tr>
                                <td style="width:30%">
                                    <div class="input-field">
                                        <i class="material-icons prefix">date_range</i>
                                        <input type="text" name="inleu_date" id="inleu_date" class="datepicker" value="{{old('inleu_date') ? : ''}}" class="validate" required>
                                        <label for="inleu_date">Date</label>
                                        <span class="{{$errors->has('inleu_date') ? 'helper-text red-text' : ''}}">{{$errors->has('inleu_date') ? $errors->first('inleu_date') : ''}}</span>
                                    </div>
                                </td>
                                <td style="width:60%">
                                    <div class="input-field">
                                        <i class = "material-icons prefix">mode_edit</i>
                                        <textarea id="reason" name="reason" class="materialize-textarea" class="validate" required>{{old('reason') ? : ''}}</textarea>
                                        <label for="reason">Reason</label>
                                        <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->has('reason') ? $errors->first('reason') : ''}}</span>
                                    </div>
                                </td>
                                <td style="width:10%">
                                    <a id="submit_add" class="waves-effect waves-light btn-large">Save</a>
                                    <div style="" id="log"></div>
                                </td>
                            </tr>                       
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.js')}}"></script>
<script>
$(document).ready(function(){  
    array_staff=[];
    array_num=[];

    $('#submit_search').click(function(){
        //clear array data for new search
        array_staff=[];
        array_num=[];
        $('#selectall').prop('checked',false);

        var department = $('#department').val();
        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/inleus/in_leu_by_add/search3",
            data:{department:department},
            dataType: 'json',
            success: function(data)
            {
                if(data.return_arr){
                    //console.log(data.return_arr);
                    var len = data.return_arr.length;
                    $tbody = '';
                    for(var i=0; i<len; i++){              
                        var dept_name = data.return_arr[i]['dept_name'];
                        var staff_name = data.return_arr[i]['staff_name'];
                        var staff_id = data.return_arr[i]['staff_id'];

                        $tbody += '<tr>' + 
                                '<td>' + (i+1) + '</td>' +                             
                                '<td><label><input type="checkbox" name="allowance[]" class="filled-in selectBox" unchecked value="yes" /><span></span></label></td>' +   
                                '<td>' + staff_name + '</td>' +
                                '<td>' + staff_id + 
                                '<input type="hidden" class="staff_id" name="staff_id[]" value="' + staff_id + '"/></td>' +
                                '<td>' + dept_name + '</td>' +
                                '<td><input type="number" name="num_day[]" class="num_day" style="width:50px" min="0.5" max="30" step="0.5" value="0.5" disabled /></td>' +
                            '</tr>';                        
                    }

                    $("#employeeTable tbody").html($tbody);
                    $('#date_reason_table').show();
        
                    $(".selectBox").on("change",function(){  

                        var val_staff = $(this).closest("tr").find(".staff_id").val();
                        var val_num = $(this).closest("tr").find(".num_day").val();

                        if($(this).is(':checked')){                
                            $(this).closest("tr").find(".num_day").prop('disabled',false);
                            array_staff.push(val_staff);
                            array_num.push(val_num);
                        }else{
                            $(this).closest("tr").find(".num_day").prop('disabled',true);
                            array_staff.splice($.inArray(val_staff, array_staff),1);
                            array_num.splice($.inArray(val_num, array_num),1);
                       }  
                    });

                    $(".num_day").on("change",function(){       
                        $(':checkbox').prop('checked',false);
                        array_staff=[];
                        array_num=[];
                    });
                }
                if(data.info){
                    M.toast({html: data.info});
                }           
            }
        });   
    });

    $('#submit_add').click(function(){
        var inleu_date = $('#inleu_date').val();
        var reason = $('#reason').val();
        var allowances = $('input[name="allowance[]"]:checked').map(function(){ return this.value; }).get();
        var len = allowances.length;
        console.log(array_staff);
        console.log(array_num);
        if(inleu_date == ''){
            M.toast({html: 'Sorry, date cannot be empty!'});
        }else if(reason == ''){
            M.toast({html: 'Sorry, reason cannot be empty!'});
        }else if(len < 1){
            M.toast({html: 'Sorry, checkbox need to be checked!'});
        }else{
            //convert date to ISO format
            var new_date = new Date(inleu_date);
            var date_iso = 
            new Date(new_date.getTime() - (new_date.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];

            $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
            });

            $.ajax({
                type: "post",
                url: "/inleus/in_leu_by_department/post_inleu",
                data:{date_iso:date_iso,array_staff:array_staff,array_num:array_num,reason:reason,},
                dataType: 'json',
                success: function(data)
                {
                    //console.log(data);
                    if(data.msg){
                        //Prevent user to submit many times
                        $('#submit_add').attr('disabled','disabled');
                        M.toast({html: data.msg});
                        setTimeout(function() {
                          window.location.href = "/inleus/in_leu_records";
                        }, 2000);
                    }else{
                        M.toast({html: data.info});
                    }
                }
            });
        }

    });

    $("#selectall").on("change",function(){
        if($(this).is(":checked")){
            $(':checkbox').prop('checked',true);
            $(".num_day").prop('disabled',false);
            array_staff=[];
            array_num=[];
            array_staff = $('input[name="staff_id[]"]').map(function(){ return this.value; }).get();
            array_num = $('input[name="num_day[]"]').map(function(){ return this.value; }).get();  
        }else{
            $(':checkbox').prop('checked',false);
            $(".num_day").prop('disabled',true);
            array_staff=[];
            array_num=[];
        }  
    });  
});
</script>
@endsection