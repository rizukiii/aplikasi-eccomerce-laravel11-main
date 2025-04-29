<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

<section class="products-grid container" id="all-product">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">{{ __('front.featured_products') }}</h2>

    <div class="row">
        @forelse ($products->take(8) as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
                    <div class="pc__img-wrapper">
                        <a href="{{ route('front.details', $product->slug) }}">
                            <img loading="lazy" src="{{ Storage::url($product->thumbnail) }}" width="330"
                                height="400" alt="Cropped Faux leather Jacket" class="pc__img">
                        </a>
                    </div>

                    <div class="pc__info position-relative">
                        <h6 class="pc__title"><a
                                href="{{ route('front.details', $product->slug) }}">{{ $product->name }}</a></h6>
                        <div class="product-card__price d-flex align-items-center">
                            <span
                                class="money price text-secondary">{{ __('front.format_price') }}{{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>

                        {{-- <div
                            class="anim_appear-bottom position-absolute bottom-0 start-0 d-none d-sm-flex align-items-center bg-body">
                            <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-add-cart js-open-aside"
                                data-aside="cartDrawer" title="Add To Cart">{{ __('front.add_to_cart') }}</button>
                            <button class="btn-link btn-link_lg me-4 text-uppercase fw-medium js-quick-view"
                                data-bs-toggle="modal" data-bs-target="#quickView" title="Quick view">
                                <span class="d-none d-xxl-block">{{ __('front.quick_view') }}</span>
                                <span class="d-block d-xxl-none"><svg width="18" height="18" viewBox="0 0 18 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_view" />
                                    </svg></span>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('front.no_products_found') }}</p>
        @endforelse

        <div class="text-center mt-2">
            <a class="btn-link btn-link_lg default-underline text-uppercase fw-medium" href="{{ route('front.allProduct') }}">Semua Produk</a>
          </div>
    </div><!-- /.row -->
</section>

</div>

<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
