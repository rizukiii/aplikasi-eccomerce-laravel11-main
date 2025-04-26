@extends('layouts.front')

@section('title', 'Kategori')

@section('content')
    <main class="pt-90">
        <section class="products-carousel container mt-5">
            <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">Kategori<strong></strong></h2>

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
                        @foreach ($cat->product as $product)
                            <div class="swiper-slide product-card">
                                <div class="pc__img-wrapper">
                                    <img loading="lazy" src="{{ Storage::url($product->thumbnail) }}" width="258"
                                        height="313" alt="{{ $product->name }}" class="pc__img">
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
