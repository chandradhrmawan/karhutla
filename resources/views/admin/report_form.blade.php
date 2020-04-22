@extends('admin/admin')      

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">

      <div class="card card-primary">

          <div class="card-header">
              <h3 class="card-title">Form</h3>
          </div>
          <div class="card-body">
            {{-- start --}}
            <form role="form" id="form">
               @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Data yang saya input di sistem adalah data yang valid.</label>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
          </div>
      </div>
    </div>
  </div>
</div>


@endsection
