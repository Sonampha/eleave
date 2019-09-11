@extends('layouts.app_ot')
@section('content')
<style>
    .right_bold{
        text-align: right; 
        font-weight: bold;
    }
</style>
<div class="container">
    <h4 class="grey-text text-darken-2 center">Report Overtime</h4>    
    {{-- Search --}}
    <div class="card-panel">
        <div class="row mb-0">
            <form action="report_by_sum" method="POST">
            @csrf()
                <div class="input-field col s4">
                    <select name="functional" id="functional">
                        <option value="" disabled>Choose ...</option>
                        @foreach($functionals as $functional)
                        <option value="{{$functional->id}}" {{ $functional->id == $function_id ? 'selected' : '' }}>{{$functional->function_name}}</option>
                        @endforeach
                    </select>
                    <label for="functional">Function:</label>
                    <span class="{{$errors->has('functional') ? 'helper-text red-text' : ''}}">{{$errors->has('functional') ? $errors->first('functional') : ''}}</span>
                </div>
                <div class="input-field col s3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_from" id="date_from" class="datepicker" value="{{date('M d, Y', strtotime($date_from))}}">
                    <label for="date_from">Date From</label>
                    <span class="{{$errors->has('date_from') ? 'helper-text red-text' : ''}}">{{$errors->has('date_from') ? $errors->first('date_from') : ''}}</span>
                </div>
                <div class="input-field col s3">
                    <i class="material-icons prefix">date_range</i>
                    <input type="text" name="date_to" id="date_to" class="datepicker" value="{{date('M d, Y', strtotime($date_to))}}">
                    <label for="date_to">Date To</label>
                    <span class="{{$errors->has('date_to') ? 'helper-text red-text' : ''}}">{{$errors->has('date_to') ? $errors->first('date_to') : ''}}</span>
                </div>
                <div class="input-field col s2">
                    <select name="location" id="location">
                        <option value="" disabled>Choose ...</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}" {{ $location->id == $location_id ? 'selected' : '' }}>{{$location->location_name}}</option>
                        @endforeach       
                    </select>
                    <label for="location">Location:</label>
                    <span class="{{$errors->has('location') ? 'helper-text red-text' : ''}}">{{$errors->has('location') ? $errors->first('location') : ''}}</span>
                </div>
                <br>
                <button type="submit" class="btn col s12 m4 l2">Search</button>
            </form>
        </div>
    </div>
    {{-- Search END --}}
    
    <div class="row">
        <!-- Show All O.T Records List as a Card -->
        <div class="card col s12 m12 l12 xl12">
            <div class="card-content">
                <div class="row" id="printArea">
                    <!-- Table that shows O.T Records List -->
                    <table class="responsive-table col s12 m12 l12 xl12">
                        <thead class="grey-text text-darken-2">
                            <tr>                                
                                <th>Staff ID</th>
                                <th>Staff Name</th>
                                <th>Function</th>
                                <th>Position</th>
								<th>Location</th>
                                <th>Minute</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total = 0; ?>
                        @if($ot_records->count())                            
                            @foreach($ot_records as $ot_record)
                                    <tr>
                                        <td><a href="/overtime/report/detail?staff_id={{$ot_record->staff_id}}&date1={{$date_from}}&date2={{$date_to}}" onclick="NewWindow(this.href,'name','1000','500','yes');return false">{{$ot_record->staff_id}}</a></td> 
                                        <td>{{$ot_record->staff_name}}</td>
                                        <td>{{$ot_record->function_name}}</td>
                                        <td>{{$ot_record->job_name}}</td>
										<td>{{$ot_record->location_name}}</td>
                                        <td>{{$ot_record->ot_minute}}</td> 
                                    </tr>
                                <?php $total += $ot_record->ot_minute;?>          
                            @endforeach
                            @else
                                {{-- if there are no O.T Records then show this message --}}
                                <tr>
                                    <td colspan="6"><h6 class="grey-text text-darken-2 center">No O.T Records Found!</h6></td>
                                </tr>
                            @endif
                            {{-- If we are searching then show this link --}}
                            @if($total != 0)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td class="right_bold">Total:</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- O.T Records Table END -->
                </div>
                <!-- Show Pagination Links -->

            </div>
        </div>
        <!-- Card END -->
        <a class="waves-effect waves-light btn green darken-1 modal-trigger" href="#demo-modal">Note</a>
        <a class="btn cyan darken-4" style="text-transform: capitalize;" onclick="printDiv('printArea')">Print</a>
    </div>
</div>

  <!-- Modal Structure -->
  <div id="demo-modal" class="modal">
    <div class="modal-content">
      <h4>Note</h4>
      <p>* Only Approved Overtime is shown here</p> 
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-red btn green darken-1">Close</a>
    </div>
  </div>

<script>
  function printDiv(divName) {
       var printContents = document.getElementById(divName).innerHTML;
       var originalContents = document.body.innerHTML;

       document.body.innerHTML = printContents;
       window.print();
       document.body.innerHTML = originalContents;
  }
</script>
@endsection