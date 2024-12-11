@extends('admin.layouts.master')

@section('page')
    Edit Product
@endsection

@section('content')

    @include('admin.layouts.message')

    <form action="{{ url('admin/products/' . $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.products._fields')

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>

@endsection
