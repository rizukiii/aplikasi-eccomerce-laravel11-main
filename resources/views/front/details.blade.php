@extends('layouts.front')

@section('title', __('front.product_details'))

@section('content')
    <main class="pt-90">
        <div class="mb-md-1 pb-md-3"></div>
        <section class="product-single container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="product-single__media" data-media-type="vertical-thumbnail">
                        <div class="product-single__image">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product->photos as $photo)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto" src="{{ Storage::url($photo->photo) }}"
                                                width="674" height="674" alt="{{ $product->name }}" />
                                            <a data-fancybox="gallery" href="{{ Storage::url($photo->photo) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="{{ __('front.zoom') }}">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @empty
                                        <p>{{ __('front.no_photos_available') }}</p>
                                    @endforelse
                                </div>
                                <div class="swiper-button-prev"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_prev_sm" />
                                    </svg></div>
                                <div class="swiper-button-next"><svg width="7" height="11" viewBox="0 0 7 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_next_sm" />
                                    </svg></div>
                            </div>
                        </div>
                        <div class="product-single__thumbnail">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @forelse ($product->photos as $photo)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto" src="{{ Storage::url($photo->photo) }}"
                                                width="104" height="104" alt="{{ $product->name }}" />
                                        </div>
                                    @empty
                                        <p>{{ __('front.no_photos_available') }}</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('front.home') }}</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">{{ __('front.the_shop') }}</a>
                        </div><!-- /.breadcrumb -->

                        <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
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
                        <div class="product-single__addtocart">
                            <!-- SIZE SELECT -->
                            <div class="qty-control position-relative mb-2">
                                <select name="size_id" required class="form-control">
                                    <option value="">{{ __('front.select_size') }}</option>
                                    @forelse ($product->sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                                @empty
                                    <option disabled>{{ __('front.no_sizes_available') }}</option>
                                @endforelse
                                </select>
                            </div>

                            <!-- QUANTITY CONTROL -->
                            <div class="qty-control" data-product-id="{{ $product->id }}">
                                <input type="number" name="quantity" value="1" min="1"
                                    max="{{ $product->stock }}" class="qty-control__number text-center">
                                <small>{{ __('front.available_stock') }}: {{ $product->stock }}</small>
                            </div>

                            <!-- SUBMIT -->
                            <button type="submit" class="btn btn-primary btn-addtocart">{{ __('front.add_to_cart') }}</button>
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
