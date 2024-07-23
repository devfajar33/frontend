<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <div class="col-lg-12 mt-5">
            <h3>CRUD</h3>
            <form action="{{ route($action) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ $param == 1 ? $response_edit['name'] : '' }}">
                </div>
                <div class="input-group mb-3">                    
                    <input type="numeric" class="form-control" id="noktp" name="noktp" placeholder="Nomor KTP" value="{{ $param == 1 ? $response_edit['identityNumber'] : '' }}">
                </div>
                <div class="input-group mb-3">
                    <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">{{ $param == 1 ? $response_edit['address'] : '' }}</textarea>
                </div>
                <div class="input-group mb-3">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <span> SUBMIT </span>
                    </button>
                    &nbsp;
                    <a href="{{ route('logout') }}" class="btn btn-warning">LOGOUT</a>
                    <input type="hidden" id="id_hdn" name="id_hdn" value="{{ $param == 1 ? $response_edit['id'] : '' }}">
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Address</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($response as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['address'] }}</td>
                        <td>
                            <a href="{{ route('edit.employee', $item['id']) }}">Edit</a>
                            <a href="{{ route('delete.employee', $item['id']) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @include('sweetalert::alert')
    </body>
</html>
