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
    <div class="col-md-6">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Master Data</h3>
          </div>
          <div class="card-body">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              {{-- <caption><code>Tinggat Confidence</code></caption> --}}
              <table class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Nilai</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($detail as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->nama}}</td>
                  <td>{{$value->nilai}}</td>
                  <td style="text-align: center;"><a href="#" onclick="edit_data({{$value->id}})"><span class="fa fa-edit"></span></a></td>
                </tr>
                @endforeach
                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
{{-- </div>
      <div class="row"> --}}
        <div class="col-md-6">
          <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Master Presentase</h3>
          </div>
          <div class="card-body">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
              {{-- <caption><code>Tinggat Confidence</code></caption> --}}
              <table class="table table-bordered table-striped example1">
                <thead>
                <tr>
                  <th>Persen</th>
                  <th>Nilai</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($detail2 as $key => $value)
                <tr>
                  <td>{{$value->persen}} % </td>
                  <td>{{$value->nilai}} - Orang</td>
                  <td style="text-align: center;"><a href="#" onclick="edit_data_persen({{$value->id}})"><span class="fa fa-edit"></span></a></td>
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
        <h5 class="modal-title" id="wizard-title">Modal Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="container">
            
            <div class="form-group">
              <label>Nilai<code>*</code></label>
              <input type="number" name="nilai" class="form-control" id="nilai" value="">
              <input type="hidden" name="id" id="id" value="">
            </div>


        </div>
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn-act" class="btn btn-primary" onclick="update_data()" value="">Submit</button>
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
  $('.example1').DataTable({
  "paging": true,
  "lengthChange": true,
  "searching": true,
  "ordering": true,
  "info": true,
  "autoWidth": true,
  "responsive": true,
  });
});


function edit_data(id)
{
  $('#modal_form').modal('show');
  $('.modal-title').text('Master Data'); 

  var url = location.origin+'/get_master_data/'+id;
  $.ajax(
  {
    type: "GET",
      url: url,
      dataType:"json",
      success: function(ress) 
      { 
        console.log(ress);
        $('#id').val(ress[0].id);
        $('#nilai').val(ress[0].nilai);
        $('#btn-act').val('master');
      },
      error: function(error)
      {
        alert(error);
      }
  });
}

function update_data()
{
  var id    = $('#id').val();
  var nilai = $('#nilai').val();
  var act   = $('#btn-act').val();
  if(act == 'master'){
    var url = location.origin+'/update_master_data/'+id+'/'+nilai;
  }else{
    var url = location.origin+'/update_master_presentase/'+id+'/'+nilai;
  } 
  $.ajax(
  {
    type: "GET",
      url: url,
      dataType:"json",
      success: function(ress) 
      { 
        alert('update sukses');
        window.location.reload();
      },
      error: function(error)
      {
        alert(error);
      }
  });
}

function edit_data_persen(id)
{
  $('#modal_form').modal('show');
  $('.modal-title').text('Master Presentase'); 
  var url = location.origin+'/get_master_presentase/'+id;
  $.ajax(
  {
    type: "GET",
      url: url,
      dataType:"json",
      success: function(ress) 
      { 
        console.log(ress);
        $('#id').val(ress[0].id);
        $('#nilai').val(ress[0].nilai);
        $('#btn-act').val('presentase');
      },
      error: function(error)
      {
        alert(error);
      }
  });
}


</script>

@endsection
