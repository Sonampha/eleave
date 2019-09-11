@extends('layouts.app_ot')
@section('content')
    <style>
        .top_name{font-size:20px;}
        .color_name{color:#000;}
        .card_custom{background:#4CAF50;padding:1px 0 1px 25px;margin:0;}       
    </style>
    <br>
    <div class="container-fluid">
        <div class="card-panel card_custom">
            <p class="top_name">Overtime Entry for: <span class="color_name">{{ Auth::user()->full_name }}</span>
            <!-- Modal Trigger -->
            <a class="waves-effect waves-light btn green darken-1 modal-trigger" href="#demo-modal">Note</a></p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card-panel">
            <div class="row">
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="ot_date" id="ot_date" class="datepicker" value="{{old('ot_date') ? : ''}}" class="validate" required>
                        <label for="ot_date">O.T Date</label>
                        <span class="{{$errors->has('ot_date') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_date') ? $errors->first('ot_date') : ''}}</span>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">date_range</i>
                        <input type="text" name="sub_date" id="sub_date" disabled value="{{$current_date}} (Submit Date)" />
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s1" style="margin-top:25px;">From:</div>
                    <div class="input-field col s2">                        
                        <select id="ot_hour_from" name="ot_hour_from" class="validate" required>
                            @foreach($ot_hours as $ot_hour)
                            <option value="{{ $ot_hour->ot_hour }}">{{ $ot_hour->ot_hour }}</option>
                            @endforeach
                        </select>
                        <label>Hour</label>
                        <span class="{{$errors->has('ot_hour') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_hour') ? $errors->first('ot_hour') : ''}}</span>
                    </div>
                    <div class="input-field col s2">                        
                        <select id="ot_min_from" name="ot_min_from" class="validate" required>
                            @foreach($ot_mins as $ot_min)
                            <option value="{{ $ot_min->ot_min }}">{{ $ot_min->ot_min }}</option>
                            @endforeach
                        </select>
                        <label>Minute</label>
                        <span class="{{$errors->has('ot_min') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_min') ? $errors->first('ot_min') : ''}}</span>
                    </div>                    
                    <div class="input-field col s1" style="margin-top:25px;">To:</div>
                    <div class="input-field col s2">                        
                        <select id="ot_hour_to" name="ot_hour_to" class="validate" required>
                            @foreach($ot_hours as $ot_hour)
                            <option value="{{ $ot_hour->ot_hour }}">{{ $ot_hour->ot_hour }}</option>
                            @endforeach
                        </select>
                        <label>Hour</label>
                        <span class="{{$errors->has('ot_hour') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_hour') ? $errors->first('ot_hour') : ''}}</span>
                    </div>
                    <div class="input-field col s2">                        
                        <select id="ot_min_to" name="ot_min_to" class="validate" required>
                            @foreach($ot_mins as $ot_min)
                            <option value="{{ $ot_min->ot_min }}">{{ $ot_min->ot_min }}</option>
                            @endforeach
                        </select>
                        <label>Minute</label>
                        <span class="{{$errors->has('ot_min') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_min') ? $errors->first('ot_min') : ''}}</span>
                    </div>
                    <div class="input-field col s2">                        
                        <input type="text" name="min_count" id="min_count" disabled value="0 mn" />
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">storage</i>
                        <select id="ot_reason" name="ot_reason" class="validate" required>
                            @foreach($ot_reasons as $ot_reason)
                            <option value="{{ $ot_reason->id }}">{{ $ot_reason->ot_reason }}</option>
                            @endforeach
                        </select>
                        <label>Reason</label>
                        <span class="{{$errors->has('ot_reason') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_reason') ? $errors->first('ot_reason') : ''}}</span>
                    </div>
                    <div class="input-field col s6">
                        <i class = "material-icons prefix">mode_edit</i>
                        <textarea maxlength="30" id="ot_remark" name="ot_remark" class="materialize-textarea" class="validate" required>{{old('ot_remark') ? : ''}}</textarea>
                        <label for="ot_remark">Remark (30 characters only)</label>
                        <span class="{{$errors->has('ot_remark') ? 'helper-text red-text' : ''}}">{{$errors->has('ot_remark') ? $errors->first('ot_remark') : ''}}</span>
                    </div>
                </div>

                <a href="/overtime" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">cancel</i>Cancel</a>
                <a id="submit" class="waves-effect waves-light btn-large">
                    <i class="material-icons right">send</i>Submit</a>
            </div>
        </div>
    </div>
    <br>

  <!-- Modal Structure -->
  <div id="demo-modal" class="modal">
    <div class="modal-content">
      <h4>Note</h4>
      <p>Overtime submission will go to your line manager. (No Email)</p> 
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-red btn green darken-1">Close</a>
    </div>
  </div>

<script src="{{asset('js/jquery.js')}}"></script>

<script>
 $(document).ready(function(){

    $('#ot_hour_from').on('change', function() {
        var hour_1 = $('#ot_hour_from').val(); 
        var min_1 = $('#ot_min_from').val()        

        var hour_2 = $('#ot_hour_to').val(); 
        var min_2 = $('#ot_min_to').val()        

        var your_min = mincalculate(hour_1,min_1,hour_2,min_2);
        $('#min_count').val(your_min + ' mn');         
    });

    $('#ot_hour_to').on('change', function() {
        var hour_1 = $('#ot_hour_from').val(); 
        var min_1 = $('#ot_min_from').val()        

        var hour_2 = $('#ot_hour_to').val(); 
        var min_2 = $('#ot_min_to').val()        

        var your_min = mincalculate(hour_1,min_1,hour_2,min_2);
        $('#min_count').val(your_min + ' mn');         
    });

    $('#ot_min_from').on('change', function() {
        var hour_1 = $('#ot_hour_from').val(); 
        var min_1 = $('#ot_min_from').val()        

        var hour_2 = $('#ot_hour_to').val(); 
        var min_2 = $('#ot_min_to').val()        

        var your_min = mincalculate(hour_1,min_1,hour_2,min_2);
        $('#min_count').val(your_min + ' mn');         
    });

    $('#ot_min_to').on('change', function() {
        var hour_1 = $('#ot_hour_from').val(); 
        var min_1 = $('#ot_min_from').val()        

        var hour_2 = $('#ot_hour_to').val(); 
        var min_2 = $('#ot_min_to').val()        

        var your_min = mincalculate(hour_1,min_1,hour_2,min_2);
        $('#min_count').val(your_min + ' mn');         
    });

    function mincalculate(h1,m1,h2,m2){
        var min_h1 = h1 * 60;
        var min_h2 = h2 * 60;

        var total_h1 = parseInt(min_h1) + parseInt(m1);
        var total_h2 = parseInt(min_h2) + parseInt(m2);

        var diff_min = total_h2 - total_h1;
        return diff_min;
    }
  });
</script>

<script>
$(document).ready(function(){  
    $('#submit').click(function(){        
        var ot_date = $('#ot_date').val();
        var time_from = $('#ot_hour_from').val() + ':' + $('#ot_min_from').val();
        var time_to = $('#ot_hour_to').val() + ':' + $('#ot_min_to').val();
        var ot_minute = parseInt($('#min_count').val());     
        var ot_reason_id = parseInt($('#ot_reason').val());
        var ot_remark = $('#ot_remark').val();

        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });

        $.ajax({
            type: "post",
            url: "/overtime/postovertime",
            data:{ot_date:ot_date,
                time_from:time_from,
                time_to:time_to,
                ot_minute:ot_minute,
                ot_reason_id:ot_reason_id,
                ot_remark:ot_remark},
            dataType: 'json',
            success: function(data)
            {
                //console.log(data);
                if(data.msg){
                    //Prevent user to submit many times
                    $('#submit').attr('disabled','disabled');
                    M.toast({html: data.msg});
                    setTimeout(function() {
                      window.location.href = "/overtime/myovertime";
                    }, 2000);
                }else{                    
                    M.toast({html: data.info});
                }
            }
        });
    });   
});
</script>
@endsection