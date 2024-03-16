@extends('layouts.app')
@section('title')
    Edit Product
@endsection

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4">Edit Product</h1>

    <div class="row">

      <div class="col-lg-12">

        <!-- Circle Buttons -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product | Edit</h6>
          </div>
          <div class="card-header-button">
              {{-- Buttons here --}}
          </div>
          <div class="card-body">

            <form action="#" method="post" id="product_form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="title">Title <i class="asterisk">*</i></label>
                        <input type="text" value="{{ $product->title }}" class="form-control" id="title" name="title" placeholder="Product Title">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="image">Upload Image </label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/png, image/jpeg, image/jpg">
                        <span><small>Supports .jpeg, .jpg, .png | Max 2 MB</small></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description <i class="asterisk">*</i></label>
                        <textarea name="description" id="description" class="form-control" rows="5" placeholder="Description">{{ $product->description }}</textarea>
                    </div>
                    <div class="form-group col-md-12 repeat-from">
                        <label>Variants </label>
                        @foreach ($product->variants as $variant)
                            <div class="row" id="appended-form{{$counter}}">
                                <div class="form-group col-md-6">
                                    <label for="size_title"> Size</label>
                                    <input type="text" value="{{ $variant->size }}" class="form-control" id="size_title" name="size_title[]"
                                    aria-describedby="basic-addon1" placeholder="Size" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="color_title">Color</label>
                                    <input type="text" value="{{ $variant->color }}" class="form-control" id="color_title"
                                    name="color_title[]" aria-describedby="basic-addon1"
                                    placeholder="Color">
                                </div>
                            </div>
                        @php $counter++; @endphp
                        @endforeach
                    </div>
                    <div class="form-group col-md-6">
                        <button type="button" class="btn btn-primary add-more">Add More</button>
                    </div>
                    <div class="form-group  col-md-6">
                        <button type="button" class="btn btn-danger remove" @if($counter <=1) style="display: none" @endif> Remove</button>
                    </div>
                    <input value="{{ $product->id }}" type="hidden" name="id" id="id">

                    <div class="form-group col-md-12">
                      <button type="submit" id="form_submit" class="btn btn-success btn-icon-split float-right">
                          <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                          </span>
                          <span class="text">Save</span>
                      </button>
                    </div>
                </div>
            </form>
          </div>
        </div>

      </div>

    </div>

</div>

<div class="row from-content" style="display: none">
    <div class="form-group col-md-6">
        <label for="size_title"> Size </label>
        <input type="text" class="form-control" id="size_title" name="size_title[]"
        aria-describedby="basic-addon1" placeholder="Size">
    </div>

    <div class="form-group col-md-6">
        <label for="color_title">Color</label>
        <input type="text" class="form-control" id="color_title"
            name="color_title[]" aria-describedby="basic-addon1"
            placeholder="Color">
    </div>
</div>

@endsection

@section('scripts')
    <script>
        let page = 'edit';
        let formCounter = "{{ $counter }}";
        let storeURL = "{{ route('storeProduct') }}";
    </script>
     <script src="{{asset('assets/js/jquery-validation-1.19.1/dist/jquery.validate.min.js')}}"></script>
    <script src="{{ asset('assets/js/product.js') }}"></script>
@endsection