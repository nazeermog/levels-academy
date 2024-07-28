@extends("student.layouts.dashboard")

@section('content')
@if(session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
  {{ session('error') }}
</div>
@endif

<div class="container py-5">
  @foreach($categories as $category)
  @php
  $categoryProducts = $products->filter(function($product) use ($category) {
  return $product->category_product_id == $category->id;
  });
  @endphp

  @if($categoryProducts->isNotEmpty())
  <div class="page-separator">
    <div class="page-separator__text">{{ $category->title }}</div>
  </div>

  <div class="row">
    @foreach($categoryProducts as $product)
    <div class="col-lg-3 mb-24pt">
      <div class="card card-sm card--elevated p-relative o-hidden overlay overlay--primary-dodger-blue js-overlay card-group-row__card">

        <!-- Product Image -->
        <a href="#" class="card-img-top js-image" data-position="" data-height="140">
          <img src="{{ asset($product->photo) }}" alt="{{ $product->name }}" style="width: 100%;">
        </a>

        <div class="card-body flex">
          <div class="d-flex">
            <div class="flex">
              <a href="#" class="card-title">{{ $product->name }}</a>
              <small class="text-50 font-weight-bold mb-4pt">{{ $product->brand }}</small>
            </div>
            <a href="#" data-toggle="tooltip" data-title="Add Favorite" data-placement="top" data-boundary="window" class="ml-4pt material-icons text-20 card-course__icon-favorite">favorite_border</a>
          </div>


          <div class="d-flex align-items-center">
            <span class="material-icons icon-24pt text-90 mr-4pt">{{ $product->unit }}</span>
            <p class="flex text-90 lh-1 mb-0" style="font-size: 1.2rem;"><strong>{{ $product->price }}</strong></p>
          </div>
        </div>
        <div class="card-footer">
          <a href="" class="btn btn-primary btn-block">Order</a>
        </div>
      </div>
      <div class="popoverContainer d-none">
        <!-- Product Details Popover Content -->
      </div>
    </div>
    @endforeach
  </div>
  @endif
  @endforeach
</div>
@endsection