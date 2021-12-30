@extends('layouts.app')

@section('title','Analisa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-five-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('chart') ? 'active':''}}" id="custom-tabs-five-normal-tab" data-toggle="pill"
                            href="/analisa/{{request()->segment(count(request()->segments()))}}/chart" role="tab" aria-controls="custom-tabs-five-normal"
                            aria-selected="false">Detail Analisa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('list') ? 'active':''}}" id="custom-tabs-five-normal-tab" data-toggle="pill"
                            href="/analisa/{{request()->segment(count(request()->segments()))}}/list" role="tab" aria-controls="custom-tabs-five-normal"
                            aria-selected="false">List History Harga</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="{{url('chart')}}">
                    <div class="tab-pane fade show active" id="custom-tabs-five-normal" role="tabpanel"
                        aria-labelledby="custom-tabs-five-normal-tab">
                        Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut
                        ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing
                        elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                        Maecenas sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus
                        ligula eu lectus. Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc
                        euismod pellentesque diam.
                    </div>
                    <div class="tab-pane fade" id="{{url('list')}}" role="tabpanel"
                        aria-labelledby="custom-tabs-five-normal-tab">
                        <a href="/analisa/create/{{request()->segment(count(request()->segments()))}}" class="btn btn-primary mb-3">Tambah Dataset</a>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Pada Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $i =0;
                              @endphp
                                @foreach ($analisa as $item)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$item->product->name}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td>{{\Carbon\Carbon::parse($item->created_at)->format(Y-m-d)}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection