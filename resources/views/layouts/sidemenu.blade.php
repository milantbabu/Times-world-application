@php
    $current_route = Request::route()->getName();
    // echo $current_route;
@endphp
<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('products')}}">
        <div class="sidebar-brand-icon">
            <img class="logoicon" src="{{ asset('assets/img/logo.jpeg') }}">
        </div>
        <div class="sidebar-brand-logo">
            <img class="logoicon" src="{{ asset('assets/img/logo.jpeg') }}">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider d-md-block">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{in_array($current_route, ['products', 'createProduct', 'editProduct', 'showProduct'])? 'active' : ''}}">
        <a class="nav-link" href="{{ route('products') }}">
            <i class="fab fa-product-hunt" data-toggle="tooltip" data-placement="right" title="Dashboard"></i>
            <span>Product</span>
        </a>
    </li>

       <!--  <li class="nav-item {{in_array($current_route, ['products', 'createProduct', 'editProduct'])? 'active' : ''}}">
          <a class="nav-link {{!in_array($current_route, ['products', 'createProduct', 'editProduct'])? 'collapsed' : ''}}"
               href="#" data-toggle="collapse" data-target="#collapseLead"
               aria-expanded="{{in_array($current_route,['products', 'createProduct', 'editProduct'])? 'true' : 'false'}}"
               aria-controls="collapseLead">
                <i class="fab fa-product-hunt" data-toggle="tooltip" data-placement="right" title="Product Management"></i>
                <span>Product</span>
            </a>
            <div id="collapseLead"
                 class="collapse {{in_array($current_route,['products', 'createProduct', 'editProduct'])? 'show' : ''}}"
                 aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner">

                  <h6 class="collapse-header">Manage Product:</h6>

                      <a class="collapse-item {{in_array($current_route, ['products', 'createProduct', 'editProduct'])? 'active' : ''}}"
                         href="{{ route('products') }}">Products 
                       </a>

                </div>
            </div>
        </li>
 -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">


</ul>
<!-- End of Sidebar -->
