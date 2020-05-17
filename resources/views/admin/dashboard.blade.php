@extends('admin/admin')      

@section('content')

 <script src="{{ asset('geojson_id.js') }}"></script>

<style type="text/css">
#map { height: 500px; }

.my-custom-scrollbar {
  position: relative;
  height: 500px;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}
</style>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-9">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Map</h3>
          </div>
          <div class="card-body">
  	         <div id="map"></div>
          </div>
      </div>
    </div>

    <div class="col-md-3">
       <div class="card card-info">
       <div class="card-header">
          <h3 class="card-title">Colaborator</h3>
        </div>
         <div class="card-body">
          <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-bordered table-striped mb-0">
            <tr>
              <th>Nama</th>
              <th>Info</th>
              <th>Waktu</th>
            </tr>
            @for ($i = 0; $i < 10; $i++)
            <tr>
              <td>Dede</td>
              <td>Terjadi Kebakaran Hebat di hutan musi</td>
              <td>20:00 00:00</td>
            </tr>
            @endfor
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
              <h3 class="card-title">Data</h3>
          </div>
          <div class="card-body">
            
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 5.0
                  </td>
                  <td>Win 95+</td>
                  <td>5</td>
                  <td>C</td>
                </tr>
                <tr>
                  <td>Misc</td>
                  <td>PSP browser</td>
                  <td>PSP</td>
                  <td>-</td>
                  <td>C</td>
                </tr>
                <tr>
                  <td>Other browsers</td>
                  <td>All others</td>
                  <td>-</td>
                  <td>-</td>
                  <td>U</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot>
              </table>
            {{-- </div> --}}
            <!-- /.card-body -->
          </div>


          </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="card-title">Bar Chart</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="chart">
            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('lte/plugins/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript">
$(function () {
  $('#example1').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  });
});

/*start map*/
/*var long = 113.9213257;
var lat  = -0.789275;
var zoom = 5;
var mymap = L.map('mapid').setView([lat, long], zoom);
var apikey = 'pk.eyJ1IjoiY2hhbmRyYWRhcm1hd2FuMTciLCJhIjoiY2s5OGp6MWxxMDJ6bDNtbW5ndWtpeTR1MiJ9.dOWewSSFZpkoosXlkf99Pg';
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  maxZoom: 18,
  id: 'mapbox/light-v9',
  tileSize: 512,
  zoomOffset: -1,
  accessToken: apikey
}).addTo(mymap);
*/
//add marker
// var marker = L.marker([-6.173110,106.829361]).addTo(mymap);
// marker.bindPopup("<b>Hello world!</b><br>I am a popup.");


/*add cluster marker*/
var apikey = 'pk.eyJ1IjoiY2hhbmRyYWRhcm1hd2FuMTciLCJhIjoiY2s5OGp6MWxxMDJ6bDNtbW5ndWtpeTR1MiJ9.dOWewSSFZpkoosXlkf99Pg';
var cloudmade = new L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  maxZoom: 18,
  id: 'mapbox/light-v9',
  tileSize: 512,
  zoomOffset: -1,
  accessToken: apikey
});

var lat  = -0.789275;
var long = 113.9213257;
var latlng = new L.LatLng(lat, long);

var map = new L.Map('map', {center: latlng, zoom: 5, layers: [cloudmade]});

var markers = new L.MarkerClusterGroup();
var markersList = [];

function populate() {
  for (var i = 0; i < 100; i++) {
    var m = new L.Marker(getRandomLatLng(map));
    markersList.push(m);
    markers.addLayer(m);
  }
  return false;
}

function getRandomLatLng(map) {
  var bounds = map.getBounds(),
    southWest = bounds.getSouthWest(),
    northEast = bounds.getNorthEast(),
    lngSpan = northEast.lng - southWest.lng,
    latSpan = northEast.lat - southWest.lat;

  return new L.LatLng(
      southWest.lat + latSpan * Math.random(),
      southWest.lng + lngSpan * Math.random());
}

populate();
map.addLayer(markers);
/*end cluster marker*/

// L.geoJson(indoData).addTo(map);
/*end map*/

/*
    chart area
*/
var areaChartData = {
labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
datasets: [
  {
    label               : 'Digital Goods',
    backgroundColor     : 'rgba(60,141,188,0.9)',
    borderColor         : 'rgba(60,141,188,0.8)',
    pointRadius          : false,
    pointColor          : '#3b8bba',
    pointStrokeColor    : 'rgba(60,141,188,1)',
    pointHighlightFill  : '#fff',
    pointHighlightStroke: 'rgba(60,141,188,1)',
    data                : [28, 48, 40, 19, 86, 27, 90]
  },
  {
    label               : 'Electronics',
    backgroundColor     : 'rgba(210, 214, 222, 1)',
    borderColor         : 'rgba(210, 214, 222, 1)',
    pointRadius         : false,
    pointColor          : 'rgba(210, 214, 222, 1)',
    pointStrokeColor    : '#c1c7d1',
    pointHighlightFill  : '#fff',
    pointHighlightStroke: 'rgba(220,220,220,1)',
    data                : [65, 59, 80, 81, 56, 55, 40]
  },
]
}

var barChartCanvas = $('#barChart').get(0).getContext('2d')
var barChartData = jQuery.extend(true, {}, areaChartData)
var temp0 = areaChartData.datasets[0]
var temp1 = areaChartData.datasets[1]
barChartData.datasets[0] = temp1
barChartData.datasets[1] = temp0

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

</script>

@endsection
