<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Form</title>
    {{--   <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- Font Icon -->
    <link rel="stylesheet" href="{{ asset('wizard-form/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('wizard-form/vendor/nouislider/nouislider.min.css') }}">

    {{-- bootsrap --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('wizard-form/css/style.css') }}">

    {{-- leaflet --}}
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
    <script src="{{ asset('leaflet/leaflet.js') }}"></script>

    {{-- marker cluster --}}
    <link rel="stylesheet" href="{{ asset('leaflet/MarkerCluster.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/MarkerCluster.Default.css') }}">
    <script src="{{ asset('leaflet/leaflet.markercluster-src.js') }}"></script>
    <script src="{{ asset('openlayer/OpenLayers.js') }}"></script>
</head>

<script type="text/javascript">
  $(document).ready(function() {
    {{-- get user long lat --}}
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("Geolocation is not supported by this browser.");
    }

    $('#map_manual').hide();
    $('#map_sistem').hide();
    $('#prev_foto').hide();

  });
    

    function showPosition(position) {
      var lat = position.coords.latitude;
      var long =  position.coords.longitude;

      document.getElementById("long_sistem").value = lat;
      document.getElementById("lat_sistem").value = long;

      var address = position.coords.accuracy;
      // console.log(address);

      /*get user full address*/
      var url = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude="+lat+"&longitude="+long+"&localityLanguage=id";
      $.ajax(
       {
          type: "GET",
          dataType: "json",
          url: url,
          success: function(ress) 
          { 
            var alamat = [];
            $.each( ress.localityInfo.administrative, function( key, value ) {
                 alamat.push(value.name);
            });
            var full_add = alamat.toString();
            console.log(full_add);
            $('#alamat_sistem').val(full_add);
            $('#full_add').html(full_add);
          },
          error: function(error)
          {
            alert(error);
          }
       });
      
      var zoom = 16;
      var mymap = L.map('mapid').setView([lat, long], zoom);
      var apikey = 'pk.eyJ1IjoiY2hhbmRyYWRhcm1hd2FuMTciLCJhIjoiY2s5OGp6MWxxMDJ6bDNtbW5ndWtpeTR1MiJ9.dOWewSSFZpkoosXlkf99Pg';
      L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        maxZoom: 20,
        id: 'mapbox/light-v9',
        // id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: apikey
      }).addTo(mymap);

      //add marker
      var marker = L.marker([lat, long]).addTo(mymap);
      marker.bindPopup("<b>Hello world!</b><br>I am a popup.");
    }

    function change_type_address(type){
     if(type == 'sistem'){
      $('#map_sistem').show();
      $('#map_manual').hide();
     }else{
      $('#map_sistem').hide();
      $('#map_manual').show();
     }
    }

    function change_prov(id_prov){
      var url = location.origin+'/get_kabupaten/'+id_prov;
      $.ajax(
       {
          type: "GET",
          url: url,
          success: function(ress) 
          { 
            $('#kabupaten').html(ress);
          },
          error: function(error)
          {
            alert(error);
          }
       });
    }

    function change_kab(id_kab){
      var url = location.origin+'/get_kecamatan/'+id_kab;
      $.ajax(
       {
          type: "GET",
          url: url,
          success: function(ress) 
          { 
            $('#kecamatan').html(ress);
          },
          error: function(error)
          {
            alert(error);
          }
       });
    }

    function change_kec(id_kel){
      var url = location.origin+'/get_kelurahan/'+id_kel;
      $.ajax(
       {
          type: "GET",
          url: url,
          success: function(ress) 
          { 
            $('#kelurahan').html(ress);
          },
          error: function(error)
          {
            alert(error);
          }
       });
    }

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
          $('#prev_foto').attr('src', e.target.result);
          $('#prev_foto').show();
        }
        
        reader.readAsDataURL(input.files[0]); // convert to base64 string
      }
    }

    function get_foto(val){
      readURL(val);
      read_detail_foto();
    }

    function read_detail_foto()
    {
      var name = document.getElementById("foto_kebakaran").files[0].name;
      var form_data = new FormData();
      var ext = name.split('.').pop().toLowerCase();
      if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
      {
       alert("Invalid Image File");
      }

      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("foto_kebakaran").files[0]);
      var f = document.getElementById("foto_kebakaran").files[0];
      var fsize = f.size||f.fileSize;
      // if(fsize > 2000000){
      if(fsize > 10000000){
        alert("Ukuran File Gambar Terlalu Besar Maksimal 10MB");
      }else{
       form_data.append("foto_kebakaran", document.getElementById('foto_kebakaran').files[0]);
       var url = location.origin+'/read_image';
       $.ajax({
        url:url,
        method:"POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend:function(){
         $('#deskripsi_foto').html("<label class='text-success'>Sedang Membaca Foto...</label>");
        },
        success:function(data)
        {
         $('#deskripsi_foto').html(data);
          generate_lokasi_foto();
        }
       });
      }
    }

    function generate_lokasi_foto()
    {
      var lat = $('#latitude_foto').val();
      var long = $('#longitude_foto').val();
      var url = "https://api.bigdatacloud.net/data/reverse-geocode-client?latitude="+lat+"&longitude="+long+"&localityLanguage=id";
      $.ajax(
       {
          type: "GET",
          dataType: "json",
          url: url,
          success: function(ress) 
          { 
            var alamat = [];
            $.each( ress.localityInfo.administrative, function( key, value ) {
                 alamat.push(value.name);
            });
            var full_add = alamat.toString();
            console.log(full_add);
            // $('#lokasi_foto').val(full_add);
            $('#lokasi_foto').val(full_add);
          },
          error: function(error)
          {
            alert(error);
          }
       });
    }

    </script>

<style type="text/css">
  #mapid { 
    height: 220px;
    width: 670px; 
  }
  .form-find{
    padding-bottom: 10px !important;
  }
  .choose-bank-desc {
    padding-top: 0px !important;
    padding-bottom: 0px !important;
  }
  .form-control{
    border-radius : 0px !important;
  }
</style>

<body>

    <div class="main">

        <div class="container">
            <form method="POST" id="signup-form" class="signup-form" action="#">
              <meta name="csrf-token" content="{{ csrf_token() }}" />
                <div>
                    <h3>Data Pelapor</h3>
                    <fieldset>
                        <h2>Informasi Pelapor</h2>
                        <p class="desc">Mohon Isi data dengan jujur,valid, dan benar</p>
                        <div class="fieldset-content">
                            <div class="form-row">
                                <label class="form-label">Nama</label>
                                <div class="form-flex">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="first_name" />
                                        <span class="text-input">Depan</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="last_name" />
                                        <span class="text-input">Belakang</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" />
                                <span class="text-input">Contoh  :<span> <code>bobby@gmail.com </code></span></span>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">No Telp :</label>
                                <input type="text" name="phone" id="phone" />
                            </div>
                        </div>
                    </fieldset>

                    <script type="text/javascript">
                      
                    </script>

                    <h3>Identitas Pelapor</h3>
                    <fieldset>
                        <h2>Informasi Pelapor</h2>
                        <p class="desc">Mohon Isi data dengan jujur,valid, dan benar</p>
                        <div class="fieldset-content">
                            <div class="form-group">
                                <label for="find_bank" class="form-label">Alamat Anda</label>
                                  <select  class="form-control" id="tipe_alamat" onchange="change_type_address(this.value)">
                                    <option value="0">--Pilih Tipe Alamat--</option>
                                    <option value="sistem">Sistem</option>
                                    <option value="manual">Manual</option>
                                  </select>
                                
                                <div id="map_sistem">
                                  <div class="form-find">
                                    <p id="full_add"></p>
                                    <input type="hidden" name="alamat_sistem" id="alamat_sistem" value="">
                                    <input type="hidden" name="long_sistem" id="long_sistem" value="">
                                    <input type="hidden" name="lat_sistem" id="lat_sistem" value="">
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <div id="mapid"></div>
                                    </div>
                                  </div>
                                </div>

                                <div id="map_manual">
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label>Provinsi</label>
                                      <select class="form-control" id="provinsi" onchange="change_prov(this.value)">
                                        @foreach($prov as $key => $value)
                                          <option value="{{$value->id_prov}}"> {{$value->nama}} </option>
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label>Kota / Kabupaten</label>
                                      <select class="form-control" id="kabupaten" onchange="change_kab(this.value)">
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-row">
                                    <div class="form-group col-md-6">
                                      <label>Kecamatan</label>
                                      <select class="form-control" id="kecamatan" onchange="change_kec(this.value)">
                                      </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                      <label>Kelurahan</label>
                                      <select class="form-control" id="kelurahan">
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                  
                            </div>
                            <hr/>
                           
                        </div>
                    </fieldset>

                    <h3>Unggah Data</h3>
                    <fieldset>
                        <h2>Informasi Pelapor</h2>
                        <p class="desc">Mohon Isi data dengan jujur,valid, dan benar</p>
                        <div class="fieldset-content">
                            <div class="form-group">
                                <label for="find_bank" class="form-label">Upload Foto</label>
                                  <input type="file" name="foto_kebakaran" id="foto_kebakaran" class="form-control" onchange="get_foto(this)">
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="col-md-6">  
                                  <img id="prev_foto" src="#" alt="" style="width: 480px;height: 300px;" />
                                </div>
                                {{-- <div class="col-md-6"> --}}
                                <div id="deskripsi_foto"></div>

                                {{-- </div> --}}
                              </div>
                          </div>
                        </div>
                    </fieldset>

                   {{--  <h3>Final Your Data</h3>
                    <fieldset>
                        <h2>Set Financial Goals</h2>
                        <p class="desc">Set up your money limit to reach the future plan</p>
                        <div class="fieldset-content">
                        </div>
                    </fieldset> --}}

                </div>
            </form>
        </div>

    </div>

    <!-- JS -->
    <script src="{{ asset('wizard-form/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/minimalist-picker/dobpicker.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/nouislider/nouislider.min.js') }}"></script>
    <script src="{{ asset('wizard-form/vendor/wnumb/wNumb.js') }}"></script>
    <script src="{{ asset('wizard-form/js/main.js') }}"></script>
</body>

</html>