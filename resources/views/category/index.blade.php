@extends('layouts.app')

@section('title','Category')

@section('content')
<div class="row">
    <!-- /.col-md-6 -->
    <div class="col-lg-12">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="m-0">
                    <a href="{{route('category.create')}}" class="btn btn-primary">Tambah Data</a>
                </h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th width="20%">Action</th>
                        <th>Category Name</th>
                    </thead>
                    <tbody>
                        @foreach ($category as $item)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info">Action</button>
                                        <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                          <a class="dropdown-item" href="{{route('category.edit', $item->id)}}">Edit</a>
                                          <a class="dropdown-item delete" href="#" data-url="{{route('category.destroy', $item->id)}}" data-label="category">Delete</a>
                                        </div>
                                      </div>
                                </td>
                                <td>
                                    {{$item->name}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
@endsection