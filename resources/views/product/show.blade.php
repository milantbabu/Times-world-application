@extends('layouts.app')
@section('title')
  Show Product
@endsection

@section('content')

    <div class="container-fluid">
        <h1 class="h3 mb-4">Product Details</h1>
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Product Details | Preview</h6>
                    </div>
                    <div class="card-body">
                        <div class="product-detail-item">
                            <div class="product-detail-item_head">
                                <h5 class="title">
                                   {{ $product->title }}
                                </h5>
                            </div>
                            <div class="product-detail-item__content">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="product-images-wrap">
                                            <div class="product-images">
                                                <figure class="product-images_item">
                                                    <img src="{{ $product->image }}" alt="product_img" />
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="product-content">
                                            <p class="product-content-item">
                                               {{ $product->description }}
                                            </p>
                                            @if(count($product->variants) > 0)
                                                <p>Variants</p>
                                                <table class="table">
                                                    <tr>
                                                        <th>Size</th>
                                                        <th>Color</th>
                                                    </tr>
                                                    @foreach($product->variants as $variant)
                                                        <tr>
                                                            <td>{{ $variant->size }}</td>
                                                           <td>{{ $variant->color }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection