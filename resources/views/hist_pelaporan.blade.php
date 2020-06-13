@extends('admin/admin')      

@section('content')

<style type="text/css">

.my-custom-scrollbar {
  position: relative;
  height: 500px;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}

.form-control{
  border-radius: 0px !important;
}
.a-white{
  color: #ffffff !important;
}
.a-black{
  color: #000000 !important;
}
</style>

{{-- 
<span class="badge badge-primary">Primary</span>
<span class="badge badge-secondary">Secondary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-info">Info</span>
<span class="badge badge-light">Light</span>
<span class="badge badge-dark">Dark</span>
--}}

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Data Riwayat Pelaporan {{ Auth::user()->name }}</h3>
          </div>
          <div class="card-body">
            
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              {{-- <caption><code>Tinggat Confidence</code></caption> --}}
              <table id="example1" class="table table-bordered table-striped">
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
                  <th>Foto</th>
                  <th>Jarak</th>
                  <th>Jumlah Confident</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($detail as $key => $value)
                  @php
                    if($value->jarak > $max_pelaporan->nilai){
                      $status = '<span class="badge badge-danger">Jarak Anda Dengan Lokasi Foto Terlalu Jauh</span>';
                    }elseif ($value->status == 7) {
                      $status = '<span class="badge badge-secondary">Pelaporan Di Batalkan</span><code>'.$value->alasan_batal.'</code>';
                    }else{
                      $status = '<span class="badge badge-success">Diterima</span>';
                    }

                  @endphp
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$value->alamat}}</td>
                  <td>{{$value->tgl_pelaporan}}</td>
                  <td>{{$value->kebakaran_lat}}</td>
                  <td>{{$value->kebakaran_lng}}</td>
                  <td>{{$value->kebakaran_desc}}</td>
                  <td>{{$value->keterangan}}</td>
                  <td><img src="{{ asset($value->path_foto) }}" width="100" height="100"></td>
                  <td>{{$value->jarak}} Km</td>
                  <td>{{$value->jml_conf}} Orang</td>
                  <td><?=$status?></td>
                  <td><a href="#" onclick="batal_lapor({{$value->id_pelaporan}})" class="a-black"><span class="fa fa-trash"></span> Batal Lapor</a></td>
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
        <div class="form-group">
            <label>Alasan<code>*</code></label>
              <textarea name="alasan_batal" id="alasan_batal" cols="50" rows="5"></textarea>
              <input type="hidden" name="id_pelaporan" id="id_pelaporan" value="">
            </div>
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="sumbit_batal()" id="btn-act" class="btn btn-primary">Submit</button>
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

function batal_lapor(id)
{
  //open modal
  $('#modal_form').modal('show');
  $('.modal-title').text('Batal Lapor User'); 
  $('#id_pelaporan').val(id);
}

function sumbit_batal()
{
  var alasan_batal = $('#alasan_batal').val();
  var id_pelaporan = $('#id_pelaporan').val();

  var url = location.origin+'/sumbit_batal/'+id_pelaporan+'/'+alasan_batal;
  $.ajax(
   {
      type: "GET",
      url: url,
      success: function(ress) 
      { 
        alert('sukses');
        window.location.reload();
      },
      error: function(error)
      {
        alert(error);
      }
   });
}



</script>

@endsection
