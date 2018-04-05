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
