@extends('admin/admin')      

@section('content')

 <script src="{{ asset('geojson_id.js') }}"></script>

<style type="text/css">
#map { height: 500px; }

#map1 { height: 500px; }

#map_m { position:absolute; top:0px; bottom:0px; width:100%; }

.my-custom-scrollbar {
  position: relative;
  height: 614px;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}

.form-control{
  border-radius: 0px !important;
}

/*.tableFixHead thead th { position: sticky; top: 0; }*/
</style>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-9">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Map</h3>
          </div>
          <div class="card-body" >
            <div class="col-md-5" style="float: center;">
            <div class="form-group">
              {{-- <input type="number" name="no_telp" class="form-control" id="no_telp"> --}}
              <div class="d-flex justify-content-center my-4">
                <div class="w-100">
                  <label>Tingkat Confidendce</label>
                  <input onchange="change_conf(this)" type="range" class="custom-range" id="customRange11" min="0" max="100" step="5">
                </div>
                <span class="font-weight-bold text-primary ml-2 valueSpan2"></span>
              </div>
            </div>
            </div>
            <div class="container-map">
  	         <div id="map"></div>
            </div>
          </div>
      </div>
    </div>

    <div class="col-md-3">
       <div class="card card-info">
       <div class="card-header">
          <h3 class="card-title">Colaborator</h3>
        </div>
         <div class="card-body" style="height: 645px !important;">
          <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped mb-0 header-fixed example2">
           <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Info</th>
              <th>Waktu</th>
            </tr>
            </thead>
            <tbody>
            @foreach($colabolator as $key => $value)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$value->name}}</td>
              <td>{{$value->keterangan}}</td>
              <td>{{$value->tgl_pelaporan}}</td>
            </tr>
            @endforeach
          </tbody>
          </table>
          </div>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Bar Chart Pelaporan</h3>

          {{-- <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div> --}}
        </div>
        <div class="card-body">
          <div class="chart">
            <div class="col-md-2" style="float: right;">
              <select class="form-control" id="year_chart" onchange="change_chart_data(this.value)">
                @foreach($year as $val)
                  <option <?=($val == date('Y')+0) ? 'selected' : ''?>>{{$val}}</option>
                @endforeach
              </select>
            </div>
            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Data Detail Colabolator</h3>
          </div>
          <div class="card-body">
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Alamat Pelapor</th>
                  <th>Tanggal Pelaporan</th>
                  <th>Longitude</th>
                  <th>Latitude</th>
                  <th>Lokasi Foto</th>
                  <th>Keterangan</th>
                  <th>Photo</th>
                </tr>
                </thead>
                <tbody>
                @foreach($colabolator as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->alamat}}</td>
                  <td>{{$value->tgl_pelaporan}}</td>
                  <td>{{$value->geometry_lng}}</td>
                  <td>{{$value->geometry_lat}}</td>
                  <td>{{$value->geometry_desc}}</td>
                  <td>{{$value->keterangan}}</td>
                  <td><img src="{{ asset($value->path_foto) }}" width="100" height="100"></td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <div class="table-responsive">
            {{-- </div> --}}
            <!-- /.card-body -->
          </div>


          </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<div id="modal_form" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="wizard-title">Campaign Wizard</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
          <div id='map_m'></div>
        </div>
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn-act" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>



<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('lte/plugins/chart.js/Chart.min.js')}}"></script>


<script src='https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.8.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://tiles.locationiq.com/v2/js/liq-styles-ctrl-gl.js?v=0.1.6'></script>
<link href='https://tiles.locationiq.com/v2/css/liq-styles-ctrl-gl.css?v=0.1.6' rel='stylesheet' />

<script type="text/javascript">
$(function () {
  $('.example1').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": false,
  "autoWidth": true,
  "responsive": false,
  });

  $('.example2').DataTable({
  "paging": false,
  "lengthChange": false,
  "searching": false,
  "ordering": true,
  "info": false,
  "autoWidth": true,
  "responsive": false,
  });


  $('.valueSpan2').val(20);
  $('#customRange11').val(20);

  const $valueSpan = $('.valueSpan2');
  const $value = $('#customRange11');
  $valueSpan.html($value.val()+'%');

  generate_map(20);
  change_chart_data();

});


function generate_map(conf)
{
    var url = location.origin+'/generate_map/'+conf;
    $.ajax({
      url:url,
      method:"GET",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      // dataType:"json",
      success:function(data)
      { 
        $('.container-map').html(data);
        unblock_page();
      }
  });
}

function change_conf(param)
{
  block_page();
  var persen = param.value;
  $('.valueSpan2').html(persen+'%');
  generate_map(persen);
}

function change_chart_data(year=null)
{
  if(year){
    
    var url = location.origin+'/get_data_chart/'+year;
    $.ajax({
      url:url,
      method:"GET",
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType:"json",
      success:function(data)
      { 
          fill_chart(data)
      }
    });

  }else{
    fill_chart({{$result_bar}});
  } 
}


function fill_chart(data_chat)
{
  var areaChartData = {
  labels  : ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
  datasets: [
    {
      label               : 'Data Pelaporan',
      backgroundColor     : 'rgba(60,141,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius          : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      // data                : [28, 48, 40, 19, 86, 27, 90, 20, 15, 45, 35, 60]
      data  : data_chat
    }
  ]
  }

  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChartData = jQuery.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  // var temp1 = areaChartData.datasets[1]
  // barChartData.datasets[0] = temp1
  barChartData.datasets[0] = temp0

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  }

  var barChart = new Chart(barChartCanvas, {
    type: 'bar', 
    data: barChartData,
    options: barChartOptions
  });
}

</script>

@endsection
