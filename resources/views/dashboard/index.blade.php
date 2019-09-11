@extends('layouts.app')
@section('content')
<style>
.col .row {
    margin-left: auto;
    margin-right: auto;
}
#file_box{
    display:none;
}
.loading{
    display: none;
}
</style>
    <br>
        <div class="row white-text">
                <div class="mx-20 card-panel light-blue col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2 offset-xl1 ml-14">
                    <div class="row">
                        <div class="col s7 xl5" style="margin-top: 20px;">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 id="lbl_leave_type" class="no-padding txt-md">Annual Leave</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p id="lbl_amount" class="no-padding center mt txt-big"></p>
                        </div>
                    </div>
                </div>

                <div class="card-panel green col s8 offset-s2 m4 l4 xl2 mx-20">
                    <div class="row">
                        <div class="col s7 xl5" style="margin-top: 20px;">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 class="no-padding txt-md">Leave<br> Taken</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p id="lbl_token" class="no-padding center mt txt-big"></p>
                        </div>
                    </div>
                </div>           
            
                <div class="card-panel blue col s8 offset-s2 m4 offset-m2 l4 offset-l2 xl2 mx-20">
                    <div class="row">
                        <div class="col s7 xl5" style="margin-top: 20px;">
                            <i class="material-icons medium white-text pt-5">filter_none</i>
                            <h6 class="no-padding txt-md">Leave Balance</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p id="lbl_balance" class="no-padding center mt txt-big"></p>
                        </div>
                    </div>
                </div> 
                <div class="mx-20 card-panel orange col s8 offset-s2 m4 l4 xl2">
                    <div class="row">
                        <div class="col s7 xl5" style="margin-top: 20px;">
                            <i class="material-icons medium white-text pt-5">person</i>
                            <h6 class="no-padding txt-md">Line Manager</h6>
                        </div>
                        <div class="col s7 xl7">
                            <p id="lbl_manager" class="no-padding center mt txt-sm" style="margin-top: 50px !important;"></p>
                        </div>
                    </div>
                </div>
          </div>

    <div class="container-fluid">
        <div class="card-panel">
            <div class="row">
                <form method="post" id="upload_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">storage</i>
                        <select id="leave_type" name="leave_type">
                            @foreach($leave_types as $leave_type)
                            <option value="{{ $leave_type->leave_type }}">{{ $leave_type->leave_type }}</option>
                            @endforeach
                        </select>
                        <label>Leave Type</label>
                        <span class="{{$errors->has('leave_type') ? 'helper-text red-text' : ''}}">{{$errors->has('leave_type') ? $errors->first('leave_type') : ''}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="date_from" id="date_from" class="datepicker" value="{{old('date_from') ? : ''}}">
                        <label for="date_from">From</label>
                        <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="date_to" id="date_to" class="datepicker" value="{{old('date_to') ? : ''}}">
                        <label for="date_to">To</label>
                        <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class = "material-icons prefix">mode_edit</i>
                        <textarea id="reason" name="reason" class="materialize-textarea">{{old('reason') ? : ''}}</textarea>
                        <label for="reason">Reason</label>
                        <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->has('reason') ? $errors->first('reason') : ''}}</span>
                    </div>
                </div>
                <div id="file_box" class="row">
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="select_file" id="select_file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" value="{{old('select_file')}}">
                            <span class="{{$errors->has('select_file') ? 'helper-text red-text' : ''}}">{{$errors->has('select_file') ? $errors->first('select_file') : ''}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input value="Full Day" class="with-gap" id="radio_one" name="daytype" type="radio" checked />
                            <span>Full Day</span>
                          </label>
                        </p>
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input value="AM" class="with-gap" id="radio_two" name="daytype" type="radio" />
                            <span>AM</span>
                          </label>
                        </p>
                        <p>
                          <i class = "material-icons prefix">star_half</i>
                          <label>
                            <input value="PM" class="with-gap" id="radio_three" name="daytype" type="radio"  />
                            <span>PM</span>
                          </label>
                        </p>
                    </div>
                    <div class="input-field col s6">
                        <div>
                            <label for="status">Status</label>                        
                            <input id="status" name="status" type="text" value="Pending for submission" readonly>                             
                        </div>
                        <div>
                            <label for="leave_applied">Leave Applied</label>
                            <input id="leave_applied" name="leave_applied" type="text" value="" readonly>
                            </div>
                        <div>
                            <label for="new_balance">New Balance</label>
                            <input id="new_balance" name="new_balance" type="text" value="" readonly>               
                        </div>               
                    </div>
                </div>

                <a href="/" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">cancel</i>Cancel</a>
                <!--<a id="submit" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">send</i>Submit</a>-->
                <input type="submit" name="submit" id="submit" value="submit" class="waves-effect waves-light btn-large"> 
                </form>
            </div>
        </div>
    </div>
    <div class="progress loading">
      <div class="indeterminate"></div>
  </div>
    <br>
    {{-- include the chart.js Library --}}
    <script src="{{asset('js/Chart.js')}}"></script>    
    {{-- Create the chart with javascript using canvas --}}

<script src="{{asset('js/jquery.js')}}"></script>
<script>
$(document).ready(function(){    
    $(document).on("change", '#leave_type', function(e) {         
        //Username = staff_id 
        var staff_id = '<?php echo Auth::user()->username;?>';
        var leave_type = $('#leave_type').val();
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "/dashboard",
            data:{staff_id:staff_id,leave_type:leave_type},
            dataType: 'json',
            success: function(data)
            {
                //console.log(data);
                $('#lbl_token').html(parseFloat(data.sum_token));
                if(leave_type == 'Annual Leave'){  
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Annual Leave');
                    $('#lbl_amount').html(parseFloat(data.ann_leave));
                    $('#lbl_balance').html(parseFloat(data.ann_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.ann_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Sick Leave'){
                    //hide and show dropdown attendance
                    $('#file_box').show();

                    $('#lbl_leave_type').html('Sick<br>Leave');
                    $('#lbl_amount').html(parseFloat(data.sick_leave));
                    $('#lbl_balance').html(parseFloat(data.sick_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.sick_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Maternity Leave'){
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Maternity Leave');
                    $('#lbl_amount').html(parseFloat(data.mat_leave));
                    $('#lbl_balance').html(parseFloat(data.mat_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.mat_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Hospitalization Leave'){
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Hospitalization Leave');
                    $('#lbl_amount').html(parseFloat(data.hop_leave));
                    $('#lbl_balance').html(parseFloat(data.hop_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.hop_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Unpaid Leave'){
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Unpaid Leave');
                    $('#lbl_amount').html(parseFloat(data.unp_leave));
                    $('#lbl_balance').html(parseFloat(data.unp_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.unp_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Special Leave'){
                    //hide and show dropdown attendance
                    $('#file_box').show();

                    $('#lbl_leave_type').html('Special Leave');
                    $('#lbl_amount').html(parseFloat(data.spec_leave));
                    $('#lbl_balance').html(parseFloat(data.spec_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.spec_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Carry Forward'){
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Carry Forward');
                    $('#lbl_amount').html(parseFloat(data.carry_leave));
                    $('#lbl_balance').html(parseFloat(data.carry_leave - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.carry_leave - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }else if(leave_type == 'Leave in Leu'){
                    //hide and show dropdown attendance
                    $('#file_box').hide();

                    $('#lbl_leave_type').html('Leave in Leu');
                    $('#lbl_amount').html(parseFloat(data.in_leu));
                    $('#lbl_balance').html(parseFloat(data.in_leu - data.sum_token));
                    M.toast({html: 'You have '+parseFloat(data.in_leu - data.sum_token)+' day(s) left.'});
                    if($('#date_from').val() != '' && $('#date_to').val() != ''){
                       $('input[name=new_balance]').val($('#lbl_balance').text() - parseFloat($('input[name=leave_applied]').val()) + ' day(s)');
                    }else{
                        //clear input
                       $('input[name=leave_applied]').val('day(s)');
                       $('input[name=new_balance]').val('day(s)');
                    }
                }               
            },
            error: function(e) 
            {
                alert('Error: ' + e);
            }
        });
    });   
});

$(document).ready(function(){   
        //Username = staff_id 
        var staff_id = '<?php echo Auth::user()->username;?>';
        var leave_type = 'Annual Leave';
        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/dashboard",
            data:{staff_id:staff_id,leave_type:leave_type},
            dataType: 'json',
            success: function(data)
            {
                console.log(data);
                $('#lbl_amount').html(parseFloat(data.ann_leave));
                $('#lbl_token').html(parseFloat(data.sum_token));
                $('#lbl_balance').html(parseFloat(data.ann_leave - data.sum_token));
                $('#lbl_work_day').html(data.work_day); 
                $('#lbl_manager').html(data.manager_name);
            },
            error: function(e) 
            {
                alert('Error: ' + e);
            }
        });
  
});
</script>

<script>
 $(document).ready(function(){

    $('#date_from').on('change', function() {
        var date_from = $('#date_from').val(); 
        $('#date_to').on('change', function() {
            var date_to = $('#date_to').val();

            var startDay = new Date(date_from);
            var endDay = new Date(date_to);
            var millisecondsPerDay = 1000 * 60 * 60 * 24;
            var millisBetween = endDay.getTime() - startDay.getTime();
            var days = Math.floor(millisBetween / millisecondsPerDay) + 1;

            $('input[name=leave_applied]').val(days + ' day(s)');  
            var after_balance = $('#lbl_balance').text() - days;
            $('input[name=new_balance]').val(after_balance + ' day(s)'); 
            //reset radio button to default
            $('#radio_one').prop('checked', true);
            if($('#date_from').val()=='' || $('#date_to').val()==''){
                //clear input
                $('input[name=leave_applied]').val('day(s)');
                $('input[name=new_balance]').val('day(s)');
            } 
        });          
    });

    $('#date_to').on('change', function() {
        var date_to = $('#date_to').val(); 
        $('#date_from').on('change', function() {
            var date_from = $('#date_from').val();

            var startDay = new Date(date_from);
            var endDay = new Date(date_to);
            var millisecondsPerDay = 1000 * 60 * 60 * 24;
            var millisBetween = endDay.getTime() - startDay.getTime();
            var days = Math.floor(millisBetween / millisecondsPerDay) + 1;   
            $('input[name=leave_applied]').val(days + ' day(s)'); 
            var after_balance = $('#lbl_balance').text() - days; 
            $('input[name=new_balance]').val(after_balance + ' day(s)');   
            //reset radio button to default
            $('#radio_one').prop('checked', true);
            if($('#date_from').val()=='' || $('#date_to').val()==''){
                //clear input
                $('input[name=leave_applied]').val('day(s)');
                $('input[name=new_balance]').val('day(s)');
            }
        }); 
    });
  });
</script>

<script>
 $(document).ready(function(){

    $('input:radio[name="daytype"]').change(function() {
          if($('#date_from').val() != '' && $('#date_to').val() != ''){
              if($(this).val() == 'AM'){                    
                    //alert toast message
                    M.toast({html: 'You choose to take 1/2 day (Morning Leave).'});
                    $('input[name=leave_applied]').val(0.5 + ' day(s)'); 
                    var after_balance = $('#lbl_balance').text() - 0.5; 
                    $('input[name=new_balance]').val(after_balance + ' day(s)'); 
                    //set datepicker range to 1 days
                    $('input[name=date_to]').val($('input[name=date_from]').val());
              }else if($(this).val() == 'PM'){                    
                    //alert toast message
                    M.toast({html: 'You choose to take 1/2 day (Evening Leave).'});
                    $('input[name=leave_applied]').val(0.5 + ' day(s)');
                    var after_balance = $('#lbl_balance').text() - 0.5; 
                    $('input[name=new_balance]').val(after_balance + ' day(s)'); 
                    //set datepicker range to 1 days
                    $('input[name=date_to]').val($('input[name=date_from]').val());
              }else{                    
                    //alert toast message
                    M.toast({html: 'You choose to take 1 full day leave.'});
                    $('input[name=leave_applied]').val(1 + ' day(s)');
                    var after_balance = $('#lbl_balance').text() - 1; 
                    $('input[name=new_balance]').val(after_balance + ' day(s)'); 
                    //set datepicker range to 1 days
                    $('input[name=date_to]').val($('input[name=date_from]').val());
              }
          }else{
                //alert toast message
                M.toast({html: 'Please select (date-from and date-to) first!'});
                //reset radio button to default
                $('#radio_one').prop('checked', true);
                //clear date range
                $('#date_from').val('');
                $('#date_to').val('');
          }
    });

});
</script>

<script>
$(document).ready(function(){  
    $('#upload_form').on('submit',function(event){
        event.preventDefault();
        var leave_type = $('#leave_type').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var day_off = parseFloat($('#leave_applied').val());
        var unit = $("input[name='daytype']:checked").val();
        var new_balance = parseFloat($('#new_balance').val());
        var reason = $('#reason').val();
        var attach_file = $("#select_file")[0].files.length;

        /* Check Validation Form */       
        if(day_off <= 0){
            M.toast({html: 'Sorry, date range cannot be negative or zero!'});
        }else if(new_balance < 0){
            M.toast({html: 'Sorry, not enough leave balance!'});
        }else if(date_from == '' ||  date_to == '' || reason == ''){  
            M.toast({html: 'Sorry, leave form cannot be empty!'}); 
        }else if(leave_type == 'Sick Leave' || leave_type == 'Special Leave'){
            if(attach_file == 0){
                M.toast({html: 'Medical document need to be uploaded!'});
            }else{
                $('.loading').show();
                $.ajax({
                    url:"/dashboard/postleave",
                    method:"POST",
                    data:new FormData(this),
                    dataType:"JSON",
                    contentType:false,
                    cache:false,
                    processData:false,
                    success:function(data){
                        //console.log(data);
                        if(data.msg){
                            $('.loading').hide();
                            //Prevent user to submit many times 
                            $('#submit').attr('disabled','disabled');                       
                            M.toast({html: data.msg});
                            setTimeout(function() {
                              window.location.href = "/my_leaves";
                            }, 2000);
                        }else{
                            M.toast({html: data.info});
                            $('.loading').hide();
                        }
                    }
                });
            }            
        }else{
            $('.loading').show();
            $.ajax({
                url:"/dashboard/postleave",
                method:"POST",
                data:new FormData(this),
                dataType:"JSON",
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    //console.log(data);
                    if(data.msg){
                        $('.loading').hide();
                        //Prevent user to submit many times 
                        $('#submit').attr('disabled','disabled');                       
                        M.toast({html: data.msg});
                        setTimeout(function() {
                          window.location.href = "/my_leaves";
                        }, 2000);
                    }else{
                        M.toast({html: data.info});
                        $('.loading').hide();
                    }
                }
            });
        }

    });
});
</script>
@endsection