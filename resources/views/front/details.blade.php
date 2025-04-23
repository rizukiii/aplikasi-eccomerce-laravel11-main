@extends('layouts.front')

@section('title', 'Detail Produk')
{{-- @dd($prod) --}}
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
                                    @foreach ($prod->photos as $photo)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto" src="{{ Storage::url($photo->photo) }}"
                                                width="674" height="674" alt="{{ $prod->name }}" />
                                            <a data-fancybox="gallery" href="{{ Storage::url($photo->photo) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endforeach
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
                                    @foreach ($prod->photos as $photo)
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto" src="{{ Storage::url($photo->photo) }}"
                                                width="104" height="104" alt="{{ $prod->name }}" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex justify-content-between mb-4 pb-md-2">
                        <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
                            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                            <a href="#" class="menu-link menu-link_us-s text-uppercase fw-medium">The Shop</a>
                        </div><!-- /.breadcrumb -->

                        <div
                            class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        </div><!-- /.shop-acs -->
                    </div>
                    <h1 class="product-single__name">{{ $prod->name }}</h1>
                    <div class="product-single__rating">
                        <div class="reviews-group d-flex">
                        </div>
                    </div>
                    <div class="product-single__price">
                        <span
                            class="current-price">{{ __('front.format_price') }}{{ number_format($prod->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="product-single__short-desc">
                        <p>{{ $prod->about }}</p>
                    </div>
                    <form name="addtocart-form" method="POST" action="{{ route('front.save_order', $prod->slug) }}">
                        @csrf
                        <div class="product-single__addtocart">
                            <!-- Size Select -->
                            <div class="qty-control position-relative mb-2">
                                <select name="size_id" class="form-control" required>
                                    <option value="">-- Pilih Size --</option>
                                    @foreach($prod->sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity Selector -->
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-addtocart js-open-aside" data-aside="cartDrawer">
                                Add to Cart
                            </button>
                        </div>
                    </form>

                    <!-- Cart Drawer HTML (wajib ada) -->
                    <div id="cartDrawer" class="aside cart-drawer" style="display: none;">
                        <div class="aside-header">Your Cart</div>
                        <div class="cart-drawer-items-list">
                            <!-- Item cart akan ditampilkan di sini -->
                        </div>
                        <div class="cart-drawer-actions">
                            <!-- Contoh: tombol Checkout -->
                            <button class="btn btn-success">Checkout</button>
                        </div>
                    </div>

                    <!-- JS Functionality -->
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                      // Quantity control
                      const qtyControl = document.querySelector('.qty-control');
                      if (qtyControl) {
                        const input = qtyControl.querySelector('input[name="quantity"]');
                        const btnMinus = qtyControl.querySelector('.qty-control__reduce');
                        const btnPlus = qtyControl.querySelector('.qty-control__increase');

                        btnPlus.addEventListener('click', function () {
                          let val = parseInt(input.value);
                          input.value = val + 1;
                        });

                        btnMinus.addEventListener('click', function () {
                          let val = parseInt(input.value);
                          if (val > 1) {
                            input.value = val - 1;
                          }
                        });
                      }

                      // Inisialisasi aside drawer
                      if (typeof UomoElements !== 'undefined' && UomoElements.Aside) {
                        new UomoElements.Aside();
                      }

                      // Inisialisasi cart drawer (jika ada)
                      if (typeof UomoSections !== 'undefined' && UomoSections.CartDrawer) {
                        new UomoSections.CartDrawer();
                      }
                    });
                    </script>



                    <div class="product-single__meta-info">
                        <div class="meta-item">
                            <label>Size:</label>
                            @forelse($prod->sizes as $size)
                                {{ $size->size }}{{ !$loop->last ? ', ' : '' }}
                            @empty
                                N/A
                            @endforelse
                        </div>

                        <div class="meta-item">
                            <label>Category:</label>
                            <span>{{ $prod->categories->name ?? 'N/A' }}</span>
                        </div>

                        <div class="meta-item">
                            <label>Brand:</label>
                            <span>{{ $prod->brands->name ?? 'N/A' }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <br>
        <br>
        <br>
        <section class="products-carousel container">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Related <strong>Products</strong></h2>

            <div id="related_products" class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
            "autoplay": false,
            "slidesPerView": 4,
            "slidesPerGroup": 4,
            "effect": "none",
            "loop": true,
            "pagination": {
              "el": "#related_products .products-pagination",
              "type": "bullets",
              "clickable": true
            },
            "navigation": {
              "nextEl": "#related_products .products-carousel__next",
              "prevEl": "#related_products .products-carousel__prev"
            },
            "breakpoints": {
              "320": {
                "slidesPerView": 2,
                "slidesPerGroup": 2,
                "spaceBetween": 14
              },
              "768": {
                "slidesPerView": 3,
                "slidesPerGroup": 3,
                "spaceBetween": 24
              },
              "992": {
                "slidesPerView": 4,
                "slidesPerGroup": 4,
                "spaceBetween": 30
              }
            }
          }'>
                    <div class="swiper-wrapper">
                        @foreach ($allProduct as $product)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    @foreach ($product->photos->take(2) as $photo)
                                        <img loading="lazy" src="{{ Storage::url($photo->photo) }}" width="258"
                                            height="313" alt="{{ $product->name }}"
                                            class="pc__img {{ $loop->last ? 'pc__img-second' : '' }}">
                                    @endforeach
                                    <button
                                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium js-add-cart js-open-aside"
                                        data-aside="cartDrawer" title="Add To Cart">Add To Cart</button>
                                </div>

                                <div class="pc__info position-relative">
                                    <p class="pc__category">{{ $product->categories->name }}</p>
                                    <h6 class="pc__title"><a
                                            href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span
                                            class="money price">{{ __('front.format_price') }}{{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>

                                    <button
                                        class="pc__btn-wl position-absolute top-0 end-0 bg-transparent border-0 js-add-wishlist"
                                        title="Add To Wishlist">
                                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_heart" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach


                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->

                <div
                    class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_prev_md" />
                    </svg>
                </div><!-- /.products-carousel__prev -->
                <div
                    class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                    <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_next_md" />
                    </svg>
                </div><!-- /.products-carousel__next -->

                <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
                <!-- /.products-pagination -->
            </div><!-- /.position-relative -->

        </section><!-- /.products-carousel container -->
    </main>
@endsection
