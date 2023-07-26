@extends('client.layout.master')

@section('content')
    < <!-- Hero Section Begin -->
        <section class="hero hero-normal">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="hero__categories">
                            <div class="hero__categories__all">
                                <i class="fa fa-bars"></i>
                                <span>All departments</span>
                            </div>
                            <ul>
                                <li><a href="#">Fresh Meat</a></li>
                                <li><a href="#">Vegetables</a></li>
                                <li><a href="#">Fruit & Nut Gifts</a></li>
                                <li><a href="#">Fresh Berries</a></li>
                                <li><a href="#">Ocean Foods</a></li>
                                <li><a href="#">Butter & Eggs</a></li>
                                <li><a href="#">Fastfood</a></li>
                                <li><a href="#">Fresh Onion</a></li>
                                <li><a href="#">Papayaya & Crisps</a></li>
                                <li><a href="#">Oatmeal</a></li>
                                <li><a href="#">Fresh Bananas</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="hero__search">
                            <div class="hero__search__form">
                                <form action="#">
                                    <div class="hero__search__categories">
                                        All Categories
                                        <span class="arrow_carrot-down"></span>
                                    </div>
                                    <input type="text" placeholder="What do yo u need?">
                                    <button type="submit" class="site-btn">SEARCH</button>
                                </form>
                            </div>
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5>+65 11.188.888</h5>
                                    <span>support 24/7 time</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero Section End -->

        <!-- Breadcrumb Section Begin -->
        <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="breadcrumb__text">
                            <h2>Shopping Cart</h2>
                            <div class="breadcrumb__option">
                                <a href="./index.html">Home</a>
                                <span>Shopping Cart</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- Shoping Cart Section Begin -->
        <section class="shoping-cart spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="table-product">
                                    @php $totalPrice = 0; @endphp
                                    @foreach ($cart as $productId => $item)
                                        {{-- neu la Object {} thi dung $item->name --}}
                                        {{-- neu la array [] thi dung $item['name'] --}}
                                        <tr id="product{{ $productId }}">
                                            <td class="shoping__cart__item">
                                                <img src="{{ $item['image_url'] }}" alt="">
                                                <h5>{{ $item['name'] }}</h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                ${{ number_format($item['price'], 2) }}
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity">
                                                    <div class="pro-qty">
                                                        <input data-id="{{ $productId }}"
                                                            data-url="{{ route('cart.update-product-in-cart', ['productId' => $productId]) }}"
                                                            type="text" value="{{ $item['qty'] }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                <span>${{ number_format($item['price'] * $item['qty'], 2) }}</span>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <span
                                                    data-url="{{ route('cart.delete-product-in-cart', ['productId' => $productId]) }}"
                                                    data-id="{{ $productId }}" class="icon_close" id="product">
                                                </span>
                                            </td>
                                        </tr>
                                        @php
                                            $totalPrice += $item['qty'] * $item['price'];
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__btns">
                            <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                            <a href="#" class="primary-btn cart-btn cart-btn-right btn-delete-cart"
                                data-url="{{ route('cart.delete-cart') }}"><span class="icon_closed"></span>
                                Delete Cart</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__continue">
                            <div class="shoping__discount">
                                <h5>Discount Codes</h5>
                                <form action="#">
                                    <input type="text" placeholder="Enter your coupon code">
                                    <button type="submit" class="site-btn">APPLY COUPON</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li>Subtotal <div class="subtotal"> <span>{{ number_format($totalPrice, 2) }}</span></div>
                                </li>
                                <li>Total <div class="total"> <span>{{ number_format($totalPrice, 2) }}</span></div>
                                </li>
                            </ul>
                            <a href="{{ route('check-out') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Shoping Cart Section End -->
    @endsection

    @section('js-custom')
        <script type="text/javascript">
            $(document).ready(function() {
                $('.icon_close').on('click', function() {
                    var productId = $(this).data('id');
                    var url = $(this).data('url');
                    $.ajax({
                        method: 'GET',
                        url: url, // action of form
                        success: function(res) {
                            Swal.fire({
                                icon: "Success",
                                text: res.message,
                            });
                            var total_price = res.total_price;
                            var total_product = res.total_product;

                            $('#total_product').html(total_product);
                            $('#total_price').html('$' + total_price);
                            $('#product' + productId).empty();
                        },
                    });
                });

                $('span.qtybtn').on('click', function() {
                    var button = $(this);
                    var oldValue = button.siblings('input').val();

                    var plus = button.hasClass('des') ? 'tru' : 'cong';

                    if (button.hasClass('inc')) {
                        oldValue = 1 + parseFloat(oldValue);
                    } else {
                        oldValue = parseFloat(oldValue) - 1;
                        oldValue = oldValue >= 0 ? oldValue : 0;
                    }

                    var url = button.siblings('input').data('url') + "/" + oldValue;

                    $.ajax({
                        method: 'GET', //methos of form
                        url: url, //action of form
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                text: res.message,
                            });

                            var urlCart = "{{ route('cart.index') }}";
                            var id = button.siblings('input').data('id');

                            var selector = "#product" + id + ".shoping__cart__total span";
                            var urlUpdate = urlCart + " " + selector;
                            $(selector).load(urlUpdate)

                            reloadView(res);

                            if (!total_product) {
                                $('#product' + id).empty();
                            }
                        }
                    });
                })
                $('.btn-delete-cart').on('click', function() {
                    var url = $(this).data('url');
                    $.ajax({
                        method: 'GET', //methos of form
                        url: url, //action of form
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                text: res.message,
                            });

                            reloadView(res);
                            $('#table-product').empty();
                        }
                    })

                    function reloadView(res) {
                        var totalPrice = res.totalPrice;
                        var totalProduct = res.totalProduct;
                        $('#total_product span').html(totalProduct);
                        $('#total_price span').html('$' + totalPrice);

                        var selectorSubtotal = '.shoping__checkout .subtotal';
                        var selectorTotal = '.shoping__checkout .total';

                        var urlUpdateSubtotal = urlCart + " " + selectorSubtotal;
                        var urlUpdateTotal = urlCart + " " + selectorTotal;
                        $(selectorSubtotal).load(urlUpdateSubtotal);
                        $(selectorTotal).load(urlUpdateTotal);
                    }
                });
            });
        </script>
    @endsection
