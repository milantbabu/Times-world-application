@extends('layouts.app')
@section('title')
 Products
@endsection

@section('styles')
    @include('layouts.data_table_styles')
@endsection


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4">Products</h1>

    <div class="row">

        <div class="col-lg-12">

            <!-- Circle Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Products | List</h6>
                </div>
                <div class="card-header-button">
                
                    <a href="{{ route('createProduct') }}" class="{!!config('buttons.add-class')!!}" title="Add">
                        {!!config('buttons.add-icon')!!}
                    </a>
                    
                </div>
                <div class="card-body">
                    <div class="table-list">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="product_table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>SL No</th>
                                        <th>Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
@section('scripts')
    <script>
        let page = 'list';
        let tableURL = "{{ route('products') }}";
        let deleteURL = "{{ route('deleteProduct') }}";
    </script>
    @include('layouts.data_table_scripts')
    <script src="{{ asset('assets/js/product.js') }}"></script>
@endsection
