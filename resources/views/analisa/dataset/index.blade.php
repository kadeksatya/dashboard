@extends('layouts.app')

@section('title','Dataset')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-12">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    <a href="{{route('dataset.create')}}" class="btn btn-primary">Tambah Dataset</a>
                </h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th width="10%">Action</th>
                        <th width="60%">Product Name</th>
                        <th>Harga Barang</th>
                        <th>Pada Tanggal</th>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($dataset as $item)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Action</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" href="{{route('dataset.edit', $item->id)}}">Edit</a>
                                          <a class="dropdown-item delete" href="#" data-url="{{route('dataset.destroy', $item->id)}}" data-label="dataset">Delete</a>
                                        </div>
                                      </div>
                                </td>
                                <td>
                                    {{$item->product->name}}
                                </td>
                                <td>
                                    {{$item->amount}}
                                </td>
                                <td>
                                    {{\Carbon\Carbon::parse($item->date)->format('Y-m-d')}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$dataset->links()}}
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection