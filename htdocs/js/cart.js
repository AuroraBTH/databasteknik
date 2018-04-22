removeFromCart = (productID) => {
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "htdocs/ajax/remove",
        dataType: 'text',
        data: {data: productID},
        success: function() {
            $("#cartView").load(location.href + " #cartView");
            $("#cart").load(location.href + " #cart");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}



removeAllFromCart = () => {
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "htdocs/ajax/removeall",
        dataType: 'text',
        data: {data: "remove"},
        success: function() {
            $("#cartView").load(location.href + " #cartView");
            $("#cart").load(location.href + " #cart");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}



plusProduct = (productID) => {
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "htdocs/ajax/plusProduct",
        dataType: 'text',
        data: {data: productID},
        success: function() {
            $("#cartView").load(location.href + " #cartView");
            $("#cart").load(location.href + " #cart");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}



minusProduct = (productID) => {
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "htdocs/ajax/minusProduct",
        dataType: 'text',
        data: {data: productID},
        success: function() {
            $("#cartView").load(location.href + " #cartView");
            $("#cart").load(location.href + " #cart");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}

$(document).ready(function() {
    var url = window.location.pathname;
    var filename = url.substring(url.lastIndexOf("/") + 1);

    if (filename === "checkout" || filename === "checkout.php") {
        validateCoupon();
    }
});

validateCoupon = () => {
    let url = generateURL();
    $('#coupon').on('input', function() {
        let coupon = document.getElementById("coupon").value;
        let check = document.getElementById("check");

        check.classList.add("d-none");

        $.ajax({
            type: 'POST',
            url: url + "/ajax/validateCoupon",
            dataType: 'text',
            data: {data: coupon},
            success: function(answer) {
                if (answer == "true") {
                    check.classList.remove("d-none");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(url + "/ajax/validateCoupon");
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
            }
        })
    });
}
