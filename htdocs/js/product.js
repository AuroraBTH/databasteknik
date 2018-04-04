generateURL = () => {
    let url = window.location.protocol + "//" + window.location.host;
    let pathArray = window.location.pathname.split( '/' );
    let newPathname = "";
        for (i = 0; i < pathArray.length - 2; i++) {
          newPathname += pathArray[i];
          newPathname += "/";
    }
    let newURL = url + newPathname;

    return newURL;
}

addToCart = (productData) => {
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "ajax",
        dataType: 'text',
        data: {data: productData},
        success: function() {
            document.getElementById("addToCartComplete").innerHTML = "Produkten finns nu i din kundvagn";
            setTimeout(function(){
                $("#cart").load(location.href + " #cart");
                document.getElementById("addToCartComplete").innerHTML = "";
            }, 1000);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}



removeProduct = (productID) => {
    console.log(productID);
    let url = generateURL();
    $.ajax({
        type: 'POST',
        url: url + "ajax/removeProduct",
        dataType: 'text',
        data: {data: productID},
        success: function() {
            $("#products").load(location.href + " #products");
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            alert("Status: " + textStatus); alert("Error: " + errorThrown);
        }
    });
}

redirectToLogin = () => {
    let url = generateURL();
    window.location.replace(url + "user/login");
}
