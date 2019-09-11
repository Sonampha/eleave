@extends('layouts.app')
@section('content')
    <div class="container">
          <h4 class="grey-text text-darken-2 center">Import - Export Sample</h4>


            <a href="{{ url('exports/downloadPdf/pdf') }}" class="btn cyan darken-4" style="text-transform: capitalize;">Download PDF</a>
            <a href="{{ url('exports/downloadExcel/xls') }}" class="btn cyan darken-4" style="text-transform: capitalize;">Download Excel xls</a>
            <a href="{{ url('exports/downloadExcel/xlsx') }}" class="btn cyan darken-4" style="text-transform: capitalize;">Download Excel xlsx</a>
            <a href="{{ url('exports/downloadExcel/csv') }}" class="btn cyan darken-4" style="text-transform: capitalize;">Download CSV</a>  
    </div>
@endsection