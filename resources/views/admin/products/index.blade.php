@extends('admin.layouts.master')

@section('page')
   View Products
@endsection

@section('content')
   <div class="row">
       <div class="col-md-12">
           @include('admin.layouts.message')

           <div class="card">
               <div class="header">
                   <h4 class="title">Products</h4>
                   <p class="category">List of all products</p>
               </div>
               <div class="content table-responsive table-full-width">
                   <table class="table table-striped">
                       <thead>
                       <tr>
                           <th>ID</th>
                           <th>Name</th>
                           <th>Price</th>
                           <th>Desc</th>
                           <th>Image</th>
                           <th>Actions</th>
                       </tr>
                       </thead>
                       <tbody>
                       @foreach ($products as $product)
                           <tr>
                               <td>{{ $product->id }}</td>
                               <td>{{ $product->name }}</td>
                               <td>{{ $product->price }}</td>
                               <td>{{ $product->description }}</td>
                               <td><img src="{{ url('uploads').'/'. $product->image }}" alt="{{ $product->image }}" style="width:50px;" class="img-thumbnail"></td>
                               <td>
                                   <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')">
                                           <span class="fa fa-trash"></span>
                                       </button>
                                       <a href="{{ route('products.edit', $product->id) }}" class="btn btn-info btn-sm ti-pencil"></a>
                                       <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-sm ti-list"></a>
                                   </form>
                               </td>
                           </tr>
                       @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
@endsection