<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

<section class="category-banner container" id="banner">
    <h2 class="section-title text-center mb-3 pb-xl-2 mb-xl-4">{{ __('front.you_might_like') }}</h2>
    <div class="row">
        @forelse ($bannerProducts as $product)
            <div class="col-md-6">
                <div class="category-banner__item border-radius-10 mb-5">
                    <a href="{{ route('front.details', $product->slug) }}">
                        <img loading="lazy" class="h-auto" src="{{ Storage::url($product->thumbnail) }}" width="690"
                            height="665" alt="{{ $product->name }}" />
                    </a>
                    <div class="category-banner__item-mark">
                        {{ __('front.starting_at') }}{{ __('front.format_price') }}{{ number_format($product->price, 0, ',', '.') }}{{ __('front.format_price_decimal') }}
                    </div>
                    <div class="category-banner__item-content">
                        <a href="{{ route('front.details', $product->slug) }}">
                            <h3 class="mb-0">{{ $product->name }}</h3>
                        </a>
                        <a href="{{ route('front.details', $product->slug) }}"
                            class="btn-link default-underline text-uppercase fw-medium">{{ __('front.shop_now') }}</a>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('front.no_products_found') }}</p>
        @endforelse

    </div>
</section>
