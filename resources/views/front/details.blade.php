@extends('layouts.front')

@section('title', __('front.product_details'))

@section('content')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-3 d-block">
                            <img src="{{ Storage::url($product->thumbnail) }}" alt=""
                            class="mb-3 img-thumbnail zoom-thumbnail"
                                    style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;">
                            @forelse ($productImages as $item)
                                <img src="{{ Storage::url($item->photo) }}" alt=""
                                    class="mb-3 img-thumbnail zoom-thumbnail"
                                    style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;">
                            @empty
                            @endforelse
                        </div>
                        <div class="col-9">
                            <img id="mainImage" src="{{ Storage::url($product->thumbnail) }}" alt=""
                                style="width: 100%; height: 600px; object-fit: cover;" data-bs-toggle="modal"
                                data-bs-target="#previewModal">
                        </div>
                    </div>
                </div>
                <!-- Modal untuk Preview Gambar -->
                <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body p-0">
                                <img id="previewImage" src="" class="img-fluid w-100" alt="Preview">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="{{ route('front.index') }}"
                                class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('front.home') }}</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <p
                                class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('front.detail_product') }}</p>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        </div><!-- /.shop-acs -->
                    </div>
                    <h1 class="product-single__name">{{ $product->name }}</h1>
                    <div class="product-single__rating">
                        <div class="reviews-group d-flex">
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="product-single__price">
                        <span
                            class="current-price">{{ __('front.format_price') }}{{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $product->about }}</p>
                    </div>
                    <form id="addtocart-form" method="POST" action="{{ route('front.save_order', $product->slug) }}">
                        @csrf
                        <input type="hidden" name="products_id" value="{{ $product->id }}">
                        <div class="product-single__addtocart">
                            <!-- SIZE SELECT -->
                            <div class="qty-control position-relative mb-2">
                                <select name="size_id" required class="form-control ">
                                    <option value="">-- {{ __('front.select_size') }} --</option>
                                    @forelse ($product->sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @empty
                                        <option disabled>{{ __('front.no_sizes_available') }}</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- QUANTITY CONTROL -->
                            <div class="qty-control position-relative mt-3" data-product-id="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1"
                                    max="{{ $product->stock }}" class="form-control text-center">
                                <small>{{ __('front.available_stock') }}: {{ $product->stock }}</small>
                            </div>

                            <!-- SUBMIT -->
                            <button type="submit"
                                class="btn btn-primary btn-addtocart mb-2">{{ __('front.add_to_cart') }}</button>
                        </div>
                    </form>

                    <div class="product-single__meta-info">
                        <div class="meta-item">
                            <label>{{ __('front.size') }}:</label>
                            @forelse($product->sizes as $size)
                                {{ $size->size }}{{ !$loop->last ? ', ' : '' }}
                            @empty
                                N/A
                            @endforelse
                        </div>

                        <div class="meta-item">
                            <label>{{ __('front.category') }}:</label>
                            <span>{{ $product->categories->name ?? 'N/A' }}</span>
                        </div>

                        <div class="meta-item">
                            <label>{{ __('front.brand') }}:</label>
                            <span>{{ $product->brands->name ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
