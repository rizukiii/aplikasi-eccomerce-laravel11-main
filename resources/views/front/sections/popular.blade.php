<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

<section class="hot-deals container" id="popular">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">{{ __('front.attractive_offer') }}</h2>
    <div class="row">
        <div
            class="col-md-6 col-lg-4 col-xl-20per d-flex align-items-center flex-column justify-content-center py-4 align-items-md-start">
            <h2>{{ __('front.popular_sell') }}</h2>
            <h2 class="fw-bold">{{ __('front.popular_sell_desc') }}</h2>

            {{-- <div class="position-relative d-flex align-items-center text-center pt-xxl-4 js-countdown mb-3"
                data-date="18-3-2024" data-time="06:50">
                <div class="day countdown-unit">
                    <span class="countdown-num d-block"></span>
                    <span class="countdown-word text-uppercase text-secondary">Days</span>
                </div>

                <div class="hour countdown-unit">
                    <span class="countdown-num d-block"></span>
                    <span class="countdown-word text-uppercase text-secondary">Hours</span>
                </div>

                <div class="min countdown-unit">
                    <span class="countdown-num d-block"></span>
                    <span class="countdown-word text-uppercase text-secondary">Mins</span>
                </div>

                <div class="sec countdown-unit">
                    <span class="countdown-num d-block"></span>
                    <span class="countdown-word text-uppercase text-secondary">Sec</span>
                </div>
            </div> --}}

            <p
                class="btn-link default-underline text-uppercase fw-medium mt-3">Ayo Pesan Sekarang juga!!!!!!!!!!</p>
        </div>
        <div class="col-md-6 col-lg-8 col-xl-80per">
            <div class="position-relative">
                <div class="swiper-container js-swiper-slider"
                    data-settings='{
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": 4,
              "slidesPerGroup": 4,
              "effect": "none",
              "loop": false,
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 2,
                  "spaceBetween": 14
                },
                "768": {
                  "slidesPerView": 2,
                  "slidesPerGroup": 3,
                  "spaceBetween": 24
                },
                "992": {
                  "slidesPerView": 3,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                },
                "1200": {
                  "slidesPerView": 4,
                  "slidesPerGroup": 1,
                  "spaceBetween": 30,
                  "pagination": false
                }
              }
            }'>
                    <div class="swiper-wrapper">
                        @forelse ($popularProducts as $product)
                            <div class="swiper-slide product-card product-card_style3">
                                <div class="pc__img-wrapper">
                                    <a href="{{ route('front.details', $product->slug) }}">
                                        @forelse ($product->photos->take(2) as $photo)
                                            <img loading="lazy" src="{{ Storage::url($photo->photo) }}" width="258"
                                                height="313" alt="{{ $product->name }}"
                                                class="pc__img {{ $loop->last ? 'pc__img-second' : '' }}">
                                        @empty
                                            <p>{{ __('front.no_photos_found') }}</p>
                                        @endforelse
                                    </a>
                                </div>

                                <div class="pc__info position-relative">
                                    <h6 class="pc__title"><a
                                            href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a>
                                    </h6>
                                    <div class="product-card__price d-flex">
                                        <span class="money price text-secondary">Rp.
                                            {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>{{ __('front.no_popular_products_found') }}</p>
                        @endforelse


                    </div><!-- /.swiper-wrapper -->
                </div><!-- /.swiper-container js-swiper-slider -->
            </div><!-- /.position-relative -->
        </div>
    </div>
</section>
