@extends('layouts.app')

@section('title','Dataset')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-6">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    Tambah Dataset
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('dataset.store')}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="">Product Name</label>
                    <select name="product_id" id="" class="form-control">
                        @foreach ($product as $i)
                            <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="">Harga Barang</label>
                    <input type="number" class="form-control" name="amount" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="">Pada Tanggal</label>
                    <input type="date" class="form-control" name="date" autocomplete="off" required>
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