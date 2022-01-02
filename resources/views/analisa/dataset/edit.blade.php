@extends('layouts.app')

@section('title','Dataset')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-6">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    Ubah Dataset
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('dataset.update', $dataset->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Product Name</label>
                    <select name="product_id" id="" class="form-control">
                        @foreach ($product as $i)
                            <option value="{{$i->id}}" {{$i->id == $dataset->product_id ? 'selected':''}}>{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Marketing Name</label>
                    <select name="market_id" id="" class="form-control">
                        @foreach ($market as $i)
                            <option value="{{$i->id}}" {{$i->id == $dataset->market_id ? 'selected':''}}>{{$i->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="">Harga Barang</label>
                    <input type="number" class="form-control" name="amount" value="{{$dataset->amount}}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="">Pada Tanggal</label>
                    <input type="date" class="form-control" name="date" autocomplete="off" value="{{$dataset->date}}" required>
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