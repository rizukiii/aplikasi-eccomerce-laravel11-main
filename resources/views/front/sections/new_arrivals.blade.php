<section class="swiper-container js-swiper-slider swiper-number-pagination slideshow"
    data-settings='{
    "autoplay": {
      "delay": 5000
    },
    "slidesPerView": 1,
    "effect": "fade",
    "loop": true
  }'
    id="new-arrival">
    <div class="swiper-wrapper">
        @forelse ($latestProducts as $product)
            <div class="swiper-slide">
                <div class="overflow-hidden position-relative h-100">
                    <div class="slideshow-character position-absolute bottom-0 pos_right-center">
                        <a href="{{ route('front.details', $product->slug) }}">
                            <img loading="lazy" src="{{ Storage::url($product->thumbnail) }}" width="542"
                                height="733" alt="Woman Fashion 1"
                                class="slideshow-character__img animate animate_fade animate_btt animate_delay-9"
                                style="object-fit: cover" />
                        </a>
                        <div class="character_markup type2">
                            <a href="{{ route('front.details', $product->slug) }}">
                                <p
                                    class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                                    {{ $product->categories->name }}</p>
                            </a>
                        </div>
                    </div>
                    <div class="slideshow-text container position-absolute start-50 top-50 translate-middle">
                        <a href="{{ route('front.details', $product->slug) }}">
                            <h6
                                class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                                {{ __('front.new_arrivals') }}</h6>
                            <h2 class="h1 fw-normal mb-0 animate animate_fade animate_btt animate_delay-5">
                                {{ $product->name }}
                            </h2>
                            <h2 class="h1 fw-bold animate animate_fade animate_btt animate_delay-5">
                                {{ $product->categories->name }}</h2>
                        </a>
                        <a href="{{ route('front.details', $product->slug) }}"
                            class="btn-link btn-link_lg default-underline fw-medium animate animate_fade animate_btt animate_delay-7">
                            {{ __('front.shop_now') }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('front.no_latest_products_found') }}</p>
        @endforelse

    </div>

    <div class="container">
        <div
            class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5">
        </div>
    </div>
</section>

<div class="container mw-1620 bg-white border-radius-10">
