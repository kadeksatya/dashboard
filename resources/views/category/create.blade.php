@extends('layouts.app')

@section('title','Category')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-6">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    Tambah Data
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('category.store')}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="">Category Name</label>
                    <input type="text" name="name" id="" autocomplete="off" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection