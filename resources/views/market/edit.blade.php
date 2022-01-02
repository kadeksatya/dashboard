@extends('layouts.app')

@section('title','Market')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-6">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    Edit Data
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('market.update', $market->id)}}" method="post">
                @csrf

                @method('PUT')

                <div class="form-group">
                    <label for="">Market Name</label>
                    <input type="text" name="name" id="" value="{{$market->name}}" autocomplete="off" class="form-control">
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