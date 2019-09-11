@extends('layouts.app_att')
@section('content')
    <style>
        .top_name{font-size:20px;}
        .color_name{color:#000;}
        .card_custom{background:#ff9800;padding:1px 0 1px 25px;margin:0;}  
    </style>
    <br>
    <div class="container-fluid">
        <div class="card-panel card_custom">
            <p class="top_name">Attendance Entry for: <span class="color_name">{{ Auth::user()->full_name }}</span>
            <!-- Modal Trigger -->
            <a class="waves-effect waves-light btn modal-trigger" href="#demo-modal">Note</a></p>
        </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-panel">
            <div class="row">

                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">storage</i>
                        <select id="att_status" name="att_status" class="validate" required>
                            @foreach($att_statuses as $att_status)
                            <option value="{{ $att_status->att_status }}">{{ $att_status->att_status }}</option>
                            @endforeach
                        </select>
                        <label>Attendance Status</label>
                        <span class="{{$errors->has('att_status') ? 'helper-text red-text' : ''}}">{{$errors->has('att_status') ? $errors->first('att_status') : ''}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="date_from" id="date_from" class="datepicker" value="{{old('date_from') ? : ''}}" class="validate" required>
                        <label id="from_label" for="date_from">Date</label>
                        <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class = "material-icons prefix">mode_edit</i>
                        <textarea id="reason" name="reason" class="materialize-textarea" class="validate" required>{{old('reason') ? : ''}}</textarea>
                        <label for="reason">Reason</label>
                        <span class="{{$errors->has('reason') ? 'helper-text red-text' : ''}}">{{$errors->has('reason') ? $errors->first('reason') : ''}}</span>
                    </div>
                </div>

                <a href="/attendance" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">cancel</i>Cancel</a>                
                <a id="submit_two" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">send</i>Submit</a>
            </div>
        </div>
    </div>
    <br>

  <!-- Modal Structure -->
  <div id="demo-modal" class="modal">
    <div class="modal-content">
      <h4>Note</h4>
      <p>Attendance submission will send an Email to your line manager.</p> 
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-red btn orange darken-1">Close</a>
    </div>
  </div>

<script src="{{asset('js/jquery.js')}}"></script>
<script>
$(document).ready(function(){  
    $('#submit_two').click(function(){
        var att_status = $('#att_status').val();
        var att_date = $('#date_from').val();
        var att_reason = $('#reason').val();
		
        if(att_date != '' && att_reason != ''){
            //Prevent user to submit many times
            $('#submit_two').attr('disabled',true);
        }

        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/dashboard/attendance",
            data:{att_status:att_status,
                att_date:att_date,
                att_reason:att_reason},
            dataType: 'json',
            success: function(data)
            {
                if(data.msg){
                    //Prevent user to submit many times
                    M.toast({html: data.msg});
                    setTimeout(function() {
                      window.location.href = "/my_attendances";
                    }, 2000);
                }else{
					$('#submit_two').removeAttr("disabled");
                    M.toast({html: data.info});
                }
            }
        });
    });   
});
</script>
@endsection