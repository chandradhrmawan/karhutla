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
    <div class="col-md-12">

      <div class="card card-info">

          <div class="card-header">
              <h3 class="card-title">Master Data User</h3>
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
                  <th>Username</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Email</th>
                  <th>No Telp</th>
                  <th>created_at</th>
                  <th>updated_at</th>
                  <th>created_loc</th>
                  <th>location</th>
                  <th>Status</th>
                  <th style="text-align: center;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($detail as $key => $value)
                	@php
                		if($value->role == '1'){
                			$role = "Admin";
                		}else{
                			$role = "User";
                		}

                		if($value->status == '1'){
                			$status = "<span class='badge badge-success'>Aktif</span>";
                		}else{
                			$status = "<span class='badge badge-secondary'>Non Aktif</span>";
                		}
                	@endphp
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->username}}</td>
                  <td>{{$value->name}}</td>
                  <td>{{$role}}</td>
                  <td>{{$value->email}}</td>
                  <td>{{$value->no_telp}}</td>
                  <td>{{$value->created_at}}</td>
                  <td>{{$value->updated_at}}</td>
                  <td>{{$value->created_loc}}</td>
                  <td>{{$value->location}}</td>
                  <td><?=$status?></td>
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
              <label>Status<code>*</code></label>
              <input type="hidden" name="id" id="id" value="">
              <select name="status" id="status" class="form-control">
              	<option value="1">Aktif</option>
              	<option value="0">Non Aktif</option>
              </select>
            </div>


        </div>
      </div>
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="btn-act" class="btn btn-primary" onclick="update_data()">Submit</button>
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


function edit_data(id)
{
  $('#modal_form').modal('show');
  $('.modal-title').text('Master Data User'); 

  var url = location.origin+'/get_master_data_user/'+id;
  $.ajax(
  {
    type: "GET",
      url: url,
      dataType:"json",
      success: function(ress) 
      { 
        console.log(ress);
        $('#id').val(ress[0].id);
        $('#status').val(ress[0].status);
      },
      error: function(error)
      {
        alert(error);
      }
  });
}

function update_data()
{
  var id     = $('#id').val();
  var status = $('#status').val();
  var url = location.origin+'/update_master_data_user/'+id+'/'+status;
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



</script>

@endsection
