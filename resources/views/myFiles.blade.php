@extends('theme.default')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
</div>
    @if (Session::has('message'))
        <div class="alert alert-success">{{ Session::get('message') }}</div>
    @endif
<div class="row justify-content-center">
<div class="container">
    <div class="row justify-content-center">
        <button id="upload" class="btn btn-success">Upload</button>    
    </div>
</div>
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>
                <div class="col-md-6">
                    <input id="csv_file" type="file" class="form-control" name="csv_file" required>
                    @if ($errors->has('csv_file'))
                        <span class="help-block">
                        <strong>{{ $errors->first('csv_file') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="header" checked> File contains header row?
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Upload
                    </button>
                </div>
            </div>
        </form> 
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
        <table id="table"  class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">credit</th>
                    <th scope="col">debit</th>
                    <th scope="col">description</th>
                    <th scope="col">reference</th>
                    <th scope="col">date</th>
                </tr>
            </thead>
            <tbody id="myTable">
                @foreach($banks->files as $bank)
                <tr>
                   <td>{{ $bank->id }}</td>
                   <td>{{ $bank->credit }}</td>
                   <td>{{ $bank->debit }}</td>
                   <td>{{ $bank->description }}</td>
                   <td>{{ $bank->reference }}</td>
                   <td>{{ $bank->date }}</td>
                   
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection