<style type="text/css">
	.form-control{
		border-radius: 0 !important;
	}
	.btn{
		border-radius: 0 !important;	
	}
  .card-header{
    background-color: #17A2B8 !important;
  }
  .a-white{
    color: #ffffff !important;
  }
  .a-black{
    color: #000000 !important;
  }
  .nav-tabs {
    border-bottom: 1px solid #000000 !important;
  }
  #mapid { 
    height: 350px;
    width: 380px; 
  }
  /*Example 1, all the CSS is defined here and not in JS*/            
  #markerWithExternalCss {
      background-image: url("{{ asset('img/marker50px.png') }}"); 
      background-size: cover;
      width: 100px;
      height: 100px;
      cursor: pointer;
  }
  
  /*Example 2, most of the CSS is set by JS*/
  .marker {
      display: block;
      border: none;
      cursor: pointer;
      padding: 0;
  }

</style>
<form method="POST" id="signup-form" class="signup-form" action="#">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<input type="hidden" name="alamat_sistem" id="alamat_sistem" value="">
<input type="hidden" name="jarak" id="jarak">
{{-- <input type="hidden" name="long_sistem" id="long_sistem" value="">
<input type="hidden" name="lat_sistem" id="lat_sistem" value=""> --}}
<div class="modal-header">
<h5 class="modal-title" id="wizard-title">Campaign Wizard</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active a-black" data-toggle="tab" href="#infoPanel" id="info-tab" role="tab">Info</a>
  <li>
  <li class="nav-item">
    <a class="nav-link a-black" data-toggle="tab" href="#ads" role="tab" id="ads-tab">Upload Foto</a>
  <li>
  <li class="nav-item">
    <a class="nav-link a-black" data-toggle="tab" href="#placementPanel" role="tab" id="placement-tab">Validasi Lokasi Foto</a>
  <li>
  {{-- <li class="nav-item">
    <a class="nav-link a-black" data-toggle="tab" href="#schedulePanel" role="tab">Schedule</a>
  <li> --}}
  {{-- <li class="nav-item">
    <a class="nav-link a-black" data-toggle="tab" href="#reviewPanel" role="tab">Review</a>
  <li> --}}
</ul>
{{-- START TAB 1 --}}
<div class="tab-content mt-2">
  <div class="tab-pane fade show active" id="infoPanel" role="tabpanel">
    <h4>Informasi Karhutla</h4>
    <code>pastikan alamat anda yg dideteksi sistem sesuai dengan tempat kejadian Karhutla</code>
  <div class="form-row">
  	<div class="form-group col-md-6">
      <label>Nama<code>*</code></label>
      <input type="text" name="name" class="form-control" id="name" value="{{ $user_detail->name }}">
    </div>
    <div class="form-group col-md-6">
      <label>Email<code>*</code></label>
      <input type="text" name="email" class="form-control" id="email" value="{{ $user_detail->email }}">
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Longitude<code>*</code></label>
      <input type="text" name="longitude_user" class="form-control" id="longitude_user" value="">
    </div>
    <div class="form-group col-md-6">
      <label>Latitude<code>*</code></label>
      <input type="text" name="latitude_user" class="form-control" id="latitude_user" value="">
    </div>
  </div>
  <div class="form-group">
    <label>No Telp<code>*</code></label>
    <input type="number" name="no_telp" class="form-control" id="no_telp" value="{{ $user_detail->no_telp }}">
  </div>
  <div class="form-group">
    <label>Alamat<code>*</code></label>
    <textarea class="form-control" id="alamat" name="alamat" cols="10" rows="5"></textarea>
  </div>
  <div class="form-group">
  	<button type="button" class="btn btn-info" id="infoContinue">Next</button>
  </div>
  </div>
  {{-- END TAB 1 --}}

  {{--START TAB 2 --}}

  <div class="tab-pane fade" id="ads" role="tabpanel">
    <h4>Upload Foto</h4>
    <div class="form-group">
      <label>Unggah Data</label>
      <br/><code>koordinat foto dengan informasi pelapor max radius 2 km</code>
      <input type="file" class="form-control-file" name="foto_kebakaran" id="foto_kebakaran" onchange="get_foto(this)" aria-describedby="fileHelp">
      <small id="fileHelp" class="form-text text-muted">Pilih foto, direkomendasikan saat mengambil foto aktifkan fitur location pada ponsel / kamera anda.
      </small>
    </div>
    <div class="form-group">
      <img id="prev_foto" src="#" alt="" style="width: 480px;height: 300px;" />
    </div>
    <div class="form-group">
      <div id="deskripsi_foto"></div>
    </div>
    <div class="form-group">
      <button class="btn btn-info" id="adsContinue">Next</button>
    </div>
  </div>
  {{--END TAB 2 --}}

  {{--START TAB 3 --}}
  <div class="tab-pane fade" id="placementPanel" role="tabpanel">
    <h4>Validasi Lokasi Foto kebakaran</h4>
    <div id="accordion" class="mb-3" role="tablist" aria-multiselectable="true">
      <div class="card">
        <div class="card-header" role="tab" id="headingOne">
          <h5 class="mb-0">
            <a data-toggle="collapse" class="a-white" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Lokasi Sistem
            </a>
          </h5>
        </div>

        <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="card-block">
            
            <div class="form-group">
               <div id="mapid"></div>
            </div>

            <div class="form-group">
              <div class="container">
               <p id="full_add"></p>
              </div>
            </div>
            
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header" role="tab" id="headingTwo">
          <h5 class="mb-0">
            <a class="collapsed a-white" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Verifikasi Lokasi <code>(Opsional Jika Lokasi Foto Tidak Akurat Silahkah Isi Lokasi)</code>
            </a>
          </h5>
        </div>
        <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">

          <div id="map_manual">
            <div class="container">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Provinsi<code>*</code></label>
                <select class="form-control" name="provinsi" id="provinsi" onchange="change_prov(this.value)">
                  @foreach($prov as $key => $value)
                    <option value="{{$value->id_prov}}"> {{$value->nama}} </option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Kota / Kabupaten<code>*</code></label>
                <select class="form-control" name="kabupaten" id="kabupaten" onchange="change_kab(this.value)">
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Kecamatan<code>*</code></label>
                <select class="form-control" name="kecamatan" id="kecamatan" onchange="change_kec(this.value)">
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Kelurahan<code>*</code></label>
                <select class="form-control" name="kelurahan" id="kelurahan" onchange="get_desc_foto(this)">
                </select>
                <input type="hidden" name="geometry_lat" id="geometry_lat">
                <input type="hidden" name="geometry_lng" id="geometry_lng">
                <input type="hidden" name="geometry_desc" id="geometry_desc">
              </div>
              <div class="form-group col-md-12">
                <label>Alamat Lengkap<code>*</code></label>
                <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control" rows="5" cols="10"></textarea>
              </div>
            </div>
          </div>
          </div>
          
        </div>
      </div>

    </div>
    {{-- <button class="btn btn-info" id="placementContinue">Next</button> --}}
  </div>
  {{--END TAB 3 --}}

{{--   <div class="tab-pane fade" id="reviewPanel" role="tabpanel">
    <h4>Review</h4>
    <button class="btn btn-primary btn-block" id="activate">Activate this Campaign!</button>
  </div> --}}


</div>
<div class="progress mt-5">
  <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
<button type="button" id="btn-act" class="btn btn-primary">Submit</button>
</div>

</form>


<script type="text/javascript">
	// alert('open modal');
  $('#modal_form').modal('show');
  $('.modal-title').text('Form Laporan Kebakaran'); 
  $('#btn-act').hide();
  /*<div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Step 1 of 5</div>*/

  $(document).ready(function() {
    {{-- get user long lat --}}
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  });

  //click tab
  $('#info-tab').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '30%');
    $('.progress-bar').html('Step 1 of 3');
    $('#myTab a[href="#infoPanel"]').tab('show');
    $('#btn-act').hide();
  });

  $('#ads-tab').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '60%');
    $('.progress-bar').html('Step 2 of 3');
    $('#myTab a[href="#ads"]').tab('show');
    $('#btn-act').hide();
  });

  $('#placement-tab').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '100%');
    $('.progress-bar').html('Step 3 of 3');
    $('#myTab a[href="#placementPanel"]').tab('show');
    $('#btn-act').show();
  });




  //click button
  $('#infoContinue').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '60%');
    $('.progress-bar').html('Step 2 of 3');
    $('#myTab a[href="#ads"]').tab('show');
    $('#btn-act').hide();
  });

  $('#adsContinue').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '100%');
    $('.progress-bar').html('Step 3 of 3');
    $('#myTab a[href="#placementPanel"]').tab('show');
    $('#btn-act').show();
  });

  /*$('#placementContinue').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '80%');
    $('.progress-bar').html('Step 4 of 5');
    $('#myTab a[href="#reviewPanel"]').tab('show');
  });*/

  /*$('#scheduleContinue').click(function (e) {
    e.preventDefault();
    $('.progress-bar').css('width', '100%');
    $('.progress-bar').html('Step 5 of 5');
    $('#myTab a[href="#reviewPanel"]').tab('show');
  });*/

  $('#btn-act').click(function (e) {
    e.preventDefault();
    // alert('submit form');
    var data_form = $("#signup-form").serialize();

    var url = location.origin+'/submit_form';
       $.ajax({
          url:url,
          method:"POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:data_form,
          dataType:"json",
          beforeSend:function(){
           // code here
          },
          success:function(data)
          {
           alert(data);
           // window.location.replace(location.origin+'/home');
          }
       });
  });

  function readURL(input) 
  {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#prev_foto').attr('src', e.target.result);
        $('#prev_foto').show();
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  function get_foto(val)
  {
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
    var url_alamat = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+ lat +'&lon='+long;
    
    //get photo address
    $.ajax(
    {
      type: "GET",
      dataType: "json",
      url: url_alamat,
      success: function(ress) 
      { 
        $('#lokasi_foto').val(ress.display_name);
        $('#alamat_sistem').val(ress.display_name);
        $('#full_add').html(ress.display_name);
      },
      error: function(error)
      {
        alert(error);
      }
    });

    //draw map from image
    locationiqKey = 'pk.117b9918776737ca2eb077f1107dda05';
    var map = new mapboxgl.Map({
        container: 'mapid',
        attributionControl: false,
        style: 'https://tiles.locationiq.com/v2/streets/vector.json?key='+locationiqKey,
        zoom: 8,
        center: [long,lat]
    });
                
    var el2 = document.createElement('div');
    el2.className = 'marker';
    el2.style.backgroundImage = 'url("{{ asset('img/marker50px.png') }}")';
    el2.style.width = '50px';
    el2.style.height = '50px';

    new mapboxgl.Marker(el2)
        .setLngLat([long,lat])
        .addTo(map);
  }

  function showPosition(position) {
    var lat = position.coords.latitude;
    var long =  position.coords.longitude;

    $('#longitude_user').val(long);
    $('#latitude_user').val(lat);

    var url_alamat = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='+ lat +'&lon='+long;
    $.ajax(
     {
      type: "GET",
      dataType: "json",
      url: url_alamat,
      success: function(ress) 
      { 
         $('#alamat').val(ress.display_name);
      },
      error: function(error)
      {
        alert(error);
      }
    });
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

  function get_desc_foto(param){
    var kelurahan = $(param).children("option:selected").text();
    var url = 'https://api.opencagedata.com/geocode/v1/json?q='+kelurahan+'&key=52cf5f86415446a38994831d7bae1dae';
    $.ajax(
     {
        type: "GET",
        url: url,
        success: function(ress) 
        { 
          $('#geometry_lat').val(ress.results[0].geometry.lat);
          $('#geometry_lng').val(ress.results[0].geometry.lng);
          $('#geometry_desc').val(ress.results[0].formatted);
          distance();
        },
        error: function(error)
        {
          alert(error);
        }
     });
  }

  function distance() {

    var url         = location.origin+'/get_distance';
    var latitude1   = $('#latitude_user').val();
    var longitude1  = $('#longitude_user').val();
    var latitude2   = "";
    var longitude2  = "";
    var unit        = "Km";

    if($('#geometry_lat').val()=="" || $('#geometry_lng').val()==""){
      var latitude2   = $('#latitude_foto').val();
      var longitude2  = $('#longitude_foto').val();
    }else{
      var latitude2   = $('#geometry_lat').val();
      var longitude2  = $('#geometry_lng').val();
    }
    
    $.ajax({
          url:url,
          method:"POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data:{"latitude1":latitude1,"longitude1":longitude1,"latitude2":latitude2,"longitude2":longitude2,"unit":unit},
          dataType:"json",
          beforeSend:function(){
           //code here
          },
          success:function(data)
          {
           //console.log(data);
           $('#jarak').val(data);
          }
       });
    
  }


</script>