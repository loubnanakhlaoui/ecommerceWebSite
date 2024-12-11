<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
   <label for="product_name">Product Name</label>
   <input type="text" name="name" value="{{ $product->name }}" class="form-control border-input" placeholder="Macbook pro">
   <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
   <label for="price">Price</label>
   <input type="text" name="price" value="{{ $product->price }}" class="form-control border-input" placeholder="$2500">
   <span class="text-danger">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
   <label for="description">Description</label>
   <textarea name="description" class="form-control border-input" placeholder="Description">{{ $product->description }}</textarea>
   <span class="text-danger">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
   <label for="image">File</label>
   <input type="file" name="image" class="form-control border-input" id="image">
   <div id="thumb-output"></div>
   <span class="text-danger">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
</div>