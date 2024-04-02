$(document).ready(function () {

    loadcart();
    loadwish();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadcart()
    {
        $.ajax({
            type: "GET",
            url: "/load-cart-data",
            success: function (response) {
                $('.cart-count-pill').html('');
                $('.cart-count-pill').html(response.count);
            }
        });
    }

    function loadwish()
    {
        $.ajax({
            type: "GET",
            url: "/load-wish-data",
            success: function (response) {
                $('.wish-count').html('');
                $('.wish-count').html(response.count);
            }
        });
    }

    $('.addToCartBtn').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest('.product_data').find('.prod_id').val();
        var product_qty = $(this).closest('.product_data').find('.qty-input').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "/add-to-cart",
            data: {
                'product_id': product_id,
                'product_qty': product_qty,
            },
            success: function (response) {
                loadcart();
                loadwish();
                swal(response.status)
                .then((value) => {
                    window.location.reload();
                  });



            }
        });
    });

    $('.addToWishlist').click(function (e) {
        e.preventDefault();

        var product_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            type: "POST",
            url: "/add-to-wishlist",
            data: {
                'product_id': product_id,
            },
            success: function (response) {
                swal(response.status);
                loadwish();
                // window.location.reload();

            }
        });
    });

    $('.delete-cart-item').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            type: "POST",
            url: "delete-cart-item",
            data: {
                'prod_id':prod_id,
            },
            success: function (response) {
                loadcart();

                swal(response.status)
                .then((value) => {
                    window.location.reload();
                  });
            }
        });
    });

    $('.remove-wishlist-item').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();

        $.ajax({
            type: "POST",
            url: "delete-wishlist-item",
            data: {
                'prod_id':prod_id,
            },
            success: function (response) {
                loadwish();
                //swal("Good job!", response.status, "success");
                swal(response.status)
                .then((value) => {
                    window.location.reload();
                  });
            }
        });
    });



    $('.changeQuantitymas').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();
        var prod_qty = $(this).closest('.product_data').find('.qty-input').val();
        prod_qty++;

        data = {
            'prod_id' : prod_id,
            'prod_qty' : prod_qty,
        },

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function (response) {

                swal(response.status)
                .then((value) => {
                    window.location.reload();
                  });
            }
        });
    });

    $('.changeQuantitymenos').click(function (e) {
        e.preventDefault();

        var prod_id = $(this).closest('.product_data').find('.prod_id').val();
        var prod_qty = $(this).closest('.product_data').find('.qty-input').val();
        prod_qty--;

        data = {
            'prod_id' : prod_id,
            'prod_qty' : prod_qty,
        },

        $.ajax({
            method: "POST",
            url: "update-cart",
            data: data,
            success: function (response) {
                swal(response.status)
                .then((value) => {
                    window.location.reload();
                  });
            }
        });
    });

    $('.increment-btn').click(function (e) {
        e.preventDefault();

        var inc_value = $(this).closest('.product_data').find('.qty-input').val();
        var value = parseInt(inc_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10)
        {
            value++;
            $(this).closest('.product_data').find('.qty-input').val(value);
        }

    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();

        var dec_value = $(this).closest('.product_data').find('.qty-input').val();
        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10)
        {
            value--;
            $(this).closest('.product_data').find('.qty-input').val(value);
        }

    });



});
