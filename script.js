function register(){
    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var pw1 = document.getElementById("pw1");
    var pw2 = document.getElementById("pw2");
    var mobile = document.getElementById("mobile");
    var gen = document.getElementById("gen");

    var f = new FormData();
    f.append("fn" , fname.value);
    f.append("ln" , lname.value);
    f.append("e" , email.value);
    f.append("pw1" , pw1.value);
    f.append("pw2" , pw2.value);
    f.append("m" , mobile.value);
    f.append("g" , gen.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if ( r.readyState == 4 && r.status == 200 ) {
            var text = r.responseText;
            if ( text == "done") {
                alert("You are successfully registered.Please login");
                window.location = "login.php";
            }else {
                alert(text); 
            }
            
        }
    }
    r.open( "POST" , "registrationProcess.php" , true );
    r.send( f );
}

function login() {
    var email = document.getElementById("email");
    var pw = document.getElementById("pw");
    var rem = document.getElementById("rme");

    var f = new FormData();
    f.append("e" , email.value);
    f.append("pw" , pw.value);
    f.append("rem" , rem.checked);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if ( r.readyState == 4 && r.status == 200 ) {
            var text = r.responseText;
            if ( text == "done") {
                
                window.location = "index.php";
            }else {
                alert(text);
            }   
        }
    }
    r.open( "POST" , "loginProcess.php" , true );
    r.send( f );
}

function goToLogin() {
    window.location = "login.php";
}

function regiter() {
    window.location = "register.php";
}

function ptod(){
    var proId = document.getElementById("provinc");
    var distric = document.getElementById("distric");
    var city = document.getElementById("city");

    proId.onchange = function(){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0" ){
                    distric.innerHTML="<option value='0'> Select District </option>";
                    city.innerHTML="<option value='0'> Select City </option>";
                    distric.setAttribute("ture");
                    city.setAttribute("ture");
                }else {
                    distric.innerHTML = text;
                }
            }
        }
        r.open( "GET" , "proToDic.php?proid="+proId.value , true );
        r.send();
    }
}

function newProToDis() {
    var proId = document.getElementById("newProvinc");
    var distric = document.getElementById("newDistric");
    var city = document.getElementById("newCity");

    proId.onchange = function(){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0" ){
                    distric.innerHTML="<option value='0'> Select District </option>";
                    city.innerHTML="<option value='0'> Select City </option>";
                    distric.setAttribute("ture");
                    city.setAttribute("ture");
                }else {
                    distric.innerHTML = text;
                }
            }
        }
        r.open( "GET" , "proToDic.php?proid="+proId.value , true );
        r.send();
    }
}

function dtoc() {
    var distric = document.getElementById("distric");
    var city = document.getElementById("city");
    
    distric.onchange =  function(){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0" ){
                    city.innerHTML="<option value='0'> Select City </option>";
                    distric.setAttribute("ture");
                }else {
                    city.innerHTML = text;
                }
            }
        }
        r.open( "GET" , "dicToCity.php?disId="+distric.value , true );
        r.send(  );
    }
}

function newDisToCity() {
    var distric = document.getElementById("newDistric");
    var city = document.getElementById("newCity");
    
    distric.onchange =  function(){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0" ){
                    city.innerHTML="<option value='0'> Select City </option>";
                    distric.setAttribute("ture");
                }else {
                    city.innerHTML = text;
                }
            }
        }
        r.open( "GET" , "dicToCity.php?disId="+distric.value , true );
        r.send(  );
    }
}

function updateProfileImg() {
    var img = document.getElementById("profileimageInput");
    var request = new XMLHttpRequest();

    img.onchange = function () {
        var file = img.files[0];
        var form = new FormData();
        form.append("i0", file);

        request.onreadystatechange = function () {
            if (request.status === 200 && request.readyState === 4) {
                var response = request.responseText;
                if (response == "valid") {
                    var url = window.URL.createObjectURL(file);
                    document.getElementById("userImg").src = url;

                    var f = new FormData();
                    f.append("i", img.files[0]);

                    var r = new XMLHttpRequest();
                    r.onreadystatechange = function(){

                    }
                    r.open("POST", "addUserProfileProcess.php" , true );
                    r.send(f);

                } else {
                    alert(response);
                    window.location.reload();
                    
                }
            }
        };

        request.open("POST", "validImgProcess.php", true);
        request.send(form);
    };
}

function show() {
    var pass = document.getElementById("myPassword");
    var btn = document.getElementById("myPasswordShowBtn");

    if ( pass.type == "password" ) {
        pass.type = "text";
        btn.innerHTML= "Hide";
    }else {
        pass.type = "password";
        btn.innerHTML= "Show";
    }
}

function addAddress() {
    var address1 = document.getElementById("address1");
    var address2 = document.getElementById("address2");
    var provinc = document.getElementById("provinc");
    var distric = document.getElementById("distric");
    var city = document.getElementById("city");
    
    var f = new FormData();
    f.append("address1",address1.value);
    f.append("address2",address2.value);
    f.append("provinc",provinc.value);
    f.append("distric",distric.value);
    f.append("city",city.value);
    
    var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "done"){
                    alert("Address Added Succsessfully");
                    window.location.reload();
                }else{
                    alert(text);
                }
            }
        }
        r.open( "POST" , "addAddressProcess.php" , true );
        r.send( f );
}

function changeAddressOpenModal() {
    var model = document.getElementById("model");
    var newModel = new bootstrap.Modal(model);
    newModel.show();
}

function changeAddress() {
    var address1 = document.getElementById("newAdd");
    var address2 = document.getElementById("newAdd2");
    var provinc = document.getElementById("newProvinc");
    var distric = document.getElementById("newDistric");
    var city = document.getElementById("newCity");

    var f = new FormData();
    f.append("address1",address1.value);
    f.append("address2",address2.value);
    f.append("provinc",provinc.value);
    f.append("distric",distric.value);
    f.append("city",city.value);

    var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "updated"){
                    alert("Address  Updated Succsessfully");
                    window.location.reload();
                }else{
                    alert(text);
                }
            }
        }
        r.open( "POST" , "addAddressProcess.php" , true );
        r.send( f );
}

function goToAddProduct() {
    window.location = "addProduct.php";
}

function changeBrand() {
    var cat = document.getElementById("categorie");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var color = document.getElementById("color");
    var f = new FormData();
    var r = new XMLHttpRequest();
    cat.onchange = function () {
        f.append("catId", cat.value);

        r.onreadystatechange = function() {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0") {
                    brand.innerHTML= "<option value='0'> Select Brand </option>";
                    model.innerHTML= "<option value='0'> Select Model </option>";
                    color.innerHTML= "<option value='0'> Select Model </option>";
                    brand.setAttribute("true");
                    model.setAttribute("true");
                    color.setAttribute("true");
                }else {
                    brand.innerHTML = text;
                }
                
            }
        }
        r.open("POST","changeBrand.php",true);
        r.send(f);
    }
}

function changeModel() {
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");

    var f = new FormData();
    var r = new XMLHttpRequest();
    brand.onchange = function () {
        f.append("brandId", brand.value);

        r.onreadystatechange = function() {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0") {
                    model.innerHTML= "<option value='0'> Select Model </option>";
                    model.setAttribute("true");
                }else {
                    model.innerHTML = text;
                }
                
            }
        }
        r.open("POST","changeModel.php",true);
        r.send(f);
    }   
}

function changeColor() {
    var model = document.getElementById("model");
    var color = document.getElementById("color");

    var f = new FormData();
    var r = new XMLHttpRequest();
    model.onchange = function() {
        f.append("modelId", model.value);

        r.onreadystatechange = function() {
            if ( r.readyState == 4 && r.status == 200 ) {
                var text = r.responseText;
                if ( text == "0") {
                    color.innerHTML= "<option value='0'> Select Color </option>";
                    color.setAttribute("ture");
                }else {
                    color.innerHTML = text;
                }
            }
        }
        r.open("POST","changeColor.php",true);
        r.send(f);
    }
}

function addproductImg() {
    var img = document.getElementById("addImg");
    var f = new FormData();
    var r = new XMLHttpRequest();

    img.onchange = function () {
        var file_count = img.files.length;

        for (var x = 0; x < file_count; x++) {
            f.append("i" + x, img.files[x]);
        }

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var text = r.responseText;
                if (text == "valid") {
                    for (let x = 0; x < img.files.length; x++) {
                        var file = img.files[x];
                        var url = window.URL.createObjectURL(file);
                        document.getElementById("i" + x).src = url;
                    }
                } else {
                    alert(text);
                    window.location.reload();
                }
            }
        };
        r.open("POST", "validImgProcess.php", true);
        r.send(f);
    };
}

function addProduct() {
    var category = document.getElementById("categorie");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");
    var condition = document.getElementById("condition") ;
    var clr = document.getElementById("color");
    var qty = document.getElementById("qty");
    var cost = document.getElementById("ppi");
    var deleveryInuserCity = document.getElementById("diuc");
    var deleveryOutOfuserCity = document.getElementById("dofuc");
    var desc = document.getElementById("discription");
    var images = document.getElementById("addImg");

    var form = new FormData();
    form.append("ca", category.value);
    form.append("b", brand.value);
    form.append("m", model.value);
    form.append("t", title.value);
    form.append("con", condition.value);
    form.append("col", clr.value);
    form.append("q", qty.value);
    form.append("co", cost.value);
    form.append("diuc", deleveryInuserCity.value);
    form.append("dofuc", deleveryOutOfuserCity.value);
    form.append("de", desc.value);

    for (var x=0;x < images.files.length;x++){
        form.append("i"+x , images.files[x]);
    }

    var request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (request.status == 200 & request.readyState == 4) {
            var text = request.responseText;
            if ( text == "add") {
                alert("Product Added Successfully");
                window.location = "myProducts.php";
            }else {
                alert(text);
            }
            
        }
    }
    request.open("POST", "addProductProcess.php", true);
    request.send(form);    
}

function myProductSearch() {
    var row = document.getElementById("sortRow");
    var serch = document.getElementById("text");

    var f = new FormData();
    f.append("text" , serch.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.status == 200 & r.readyState == 4) {
            var text = r.responseText;
            if ( text == "empty" ){
                alert("Enter Product Title");
            }else {
                row.innerHTML = text;
            }
        }
    }
    r.open("POST", "myProductSearchProcess.php", true);
    r.send(f);
}

function stor() {
    var storId = document.getElementById("stor");
    var row = document.getElementById("sortRow");
    var f = new FormData();
    var r = new XMLHttpRequest();

    storId.onchange = function (){
       f.append("sId", storId.value);
       r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var text = r.responseText;
            row.innerHTML = text;   
        }
    }
    r.open("POST", "myProductStorProcess.php", true);
    r.send(f);
    }
}

function active(id){
    var home = document.getElementById("h");
    var profile = document.getElementById("p");
    var product = document.getElementById("mp");
    var selling = document.getElementById("s");
    var cart = document.getElementById("c");
    var wish = document.getElementById("wish");
    var history = document.getElementById("his");
    var help = document.getElementById("hel");
    var login = document.getElementById("log");

    if ( id == 1 ){
        home.className = ("nav-link active");
    }else if ( id == 2 ){
        profile.className = ("nav-link active"); 
    }else if ( id == 3 ){
        product.className = ("nav-link active");
    }else if ( id == 4 ){
        login.className = ("nav-link text-success active");
    }else if ( id == 5 ){
        cart.className = ("nav-link  active");
    }else if ( id == 6 ){
        wish.className = ("nav-link  active");
    }else if ( id == 7 ){
        history.className = ("nav-link  active");
    }
}

function logOut() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var text = r.responseText;
            if ( text == "done") {
                
                window.location = "index.php";
            }else {
                alert(text);
            } 
        }
    }
    r.open("GET", "logOutProcess.php", true);
    r.send();
}

function postalcode() {
    var pc = document.getElementById("newPCode");
    var city = document.getElementById("newCity");

    city.onchange = function (){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var text = r.responseText;
                pc.value = text;
            }
        }
        r.open("GET", "postalCodeProcess.php?cId="+city.value, true);
        r.send();
    }

   
}
function postalcode2() {
    var pc = document.getElementById("pCode");
    var city = document.getElementById("city");

    city.onchange = function (){
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var text = r.responseText;
                pc.value = text;
            }
        }
        r.open("GET", "postalCodeProcess.php?cId="+city.value, true);
        r.send();
    }
}

function wish(id){
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
        var text = r.responseText;
        if ( text == "a" ){
            alert("Added to Wish List");
            window.location.reload();
        }else if ( text == "r" ){
            alert("Removed From Wish List");
            window.location.reload();
        }else if (text == "l"){
            window.location = "login.php";
        }
                
    }
    }
    r.open("GET", "wishListProcess.php?pId="+id, true);
    r.send(); 
}

var cid ;
var cartModal;
function addToCartModal(id) {
    cid = id;
    var cm = document.getElementById("cartModal");
    cartModal = new bootstrap.Modal(cm);
    cartModal.show();   
}

function addToCartFormIndex() {
    var cartQty  = document.getElementById("cartQty");
    
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var text = r.responseText;   
            if ( text == "Added To Cart"){
                alert("Added To Cart");
                window.location = "cart.php";  
            }else if (text == "Self Items Can't Add To Cart"){
                alert(text);
                cartModal.hide();
            }
            else if ( text == "Invalid Number"){
                alert(text);
                cartQty.value = 1;
            }
            else if ( text == "Over Limit"){
                alert(text);
                cartQty.value = 1;
            }
            else {
                alert("Please Login");
                window.location = "login.php";
            }
            
              
        }
        }
        r.open("GET", "addToCartProcess.php?pId="+cid+"&qty="+cartQty.value, true);
        r.send(); 
    
}

function addToCart(pid) {
    var cartQty  = document.getElementById("qty");
    
    
        var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var text = r.responseText;   
            if ( text == "Added To Cart"){
                alert("Added To Cart");
               window.location = "cart.php";  
            }else if (text == "Self Items Can't Add To Cart"){
                alert(text);
                window.location.reload();
            }
            else if ( text == "Invalid Number"){
                alert(text);
                cartQty.value = 1;
            }
            else if ( text == "Over Limit"){
                alert(text);
                cartQty.value = 1;
            }
            else if( text == "Please Enter QTY") {
                alert(text);
            }
            else if ( text == "log" ) {
                
                window.location = "login.php";
            }else {
                alert(text);
                window.location.reload();
            }
            
              
        }
        }
        r.open("GET", "addToCartProcess.php?pId="+pid+"&qty="+cartQty.value, true);
        r.send(); 
    
}

function removeFromCart(id){
    var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var text = r.responseText;
                if ( text == "r") {
                    alert("Removed From Cart");
                    window.location.reload();
                }else {
                    alert(text);
                    window.location.reload();
                }
            }
        }
        r.open("GET", "removeFromCartProcess.php?cId="+id, true);
        r.send();
}

function goToSingaleProductView(id){
    window.location = "singalProductView.php?pid="+id;
}

function singalProudctTotal(price , items){
    var deliveryFee = document.getElementById("deliveryFee");
    var qty = document.getElementById("qty");
    var tot = document.getElementById("tot");
    
    var f = new FormData();
    f.append("deliveryFee" , deliveryFee.value);
    f.append("qty" , qty.value);
    f.append("price" , price);
    f.append("item" , items);

    // qty.onchange = function(){
    //     var r = new XMLHttpRequest();
    //     r.onreadystatechange = function () {
    //         if (r.status == 200 && r.readyState == 4) {
    //             var text = r.responseText;
    //             if ( text == "get") {
    //                 window.location = "index.php";
    //             }
    //             else if( text == "invalid") {
    //                 alert("Invalid QTY");
    //                 window.location.reload();
    //             }
    //             else{
    //                 tot.value = text+".00";
    //             }
    //         }
    //     }
    //     r.open("POST", "singalProductTotalProcess.php", true);
    //     r.send(f);
    // }

    var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var text = r.responseText;
                if ( text == "get") {
                    window.location = "index.php";
                }else if ( text == "0"){
                    tot.value = "0.00";
                }
                else if( text == "invalid") {
                    alert("Invalid QTY");
                    window.location.reload();
                }else if ( text == "over"){
                    alert("Over Limite");
                    var newdf = parseInt(deliveryFee.value);
                    var itot = (price * items) + newdf;
                    qty.value = items;
                    tot.value = itot+".00";
                }
                else{
                    tot.value = text+".00";
                }
            }
        }
        r.open("POST", "singalProductTotalProcess.php", true);
        r.send(f);
}

function buyNow(id){
    var tot = document.getElementById("tot");
    var qty = document.getElementById("qty");
    var deliveryFee = document.getElementById("deliveryFee");
    
    var f = new FormData();
    f.append("pid" , id );
    f.append("tot" , tot.value );
    f.append("qty" , qty.value );
    f.append("deliveryFee" , deliveryFee.value );
    var r = new XMLHttpRequest();
        r.onreadystatechange = function () {
            if (r.status == 200 && r.readyState == 4) {
                var text = r.responseText;
                
                if( text == "log") {
                  
                    alert("Please Login");
                    window.location = "login.php";
                }
                else if ( text == "iqty") {
                    
                    alert("Invalid QTY");
                    qty.value = 1;
                }
                else if ( text == "address"){
                   
                    alert("Add Your Addrss");
                    window.location = "userProfile.php";
                }
                else if ( text == "noQt"){
                  
                    alert("Please Enter QTY");
                }
                else if ( text == "worng" ){
                    
                    alert("Something Went Worng");
                    window.location = "index.php";
                } 
                else if ( text == "self"){
                   
                    alert("Self Items Can't Buy");
                    
                    
                }
                else if ( text == "over" ){
                    alert("Over Limit");
                    qty.value = 1;
                }
                else {
                    var obj = JSON.parse(text);
                    var amount = obj["total"];
                    var email = obj["email"];
                    var orderId = obj["orderId"];
                    
                     
                    
                    
                    // Payment completed. It can be a successful failure.
                    payhere.onCompleted = function onCompleted(orderId) {
                        console.log("Payment completed. OrderID:" + orderId);
                        // Note: validate the payment and show success or failure page to the customer
                        updateQty(id,qty.value);
                        invoice(orderId,id,qty.value,tot.value,deliveryFee.value);
                        
                    };

                    // Payment window closed
                    payhere.onDismissed = function onDismissed() {
                        // Note: Prompt user to pay again or show an error page
                        console.log("Payment dismissed" + error);
                    };

                    // Error occurred
                    payhere.onError = function onError(error) {
                        // Note: show an error page
                        console.log("Error:"  + error);
                    };

                    // Put the payment variables here
                    var payment = {
                        
                        "sandbox": true,
                        "merchant_id": obj["mid"],    // Replace your Merchant ID
                        "return_url": "http://localhost/teaOrTools/singalProductView.php?pid="+id,     // Important
                        "cancel_url": "http://localhost/teaOrTools/singalProductView.php?pid="+id,     // Important
                        "notify_url": "http://sample.com/notify",
                        "order_id": obj["orderId"],
                        "items": obj["productTitle"],
                        "amount": amount,
                        "currency": obj["currency"],
                        "hash": obj["hash"], // *Replace with generated hash retrieved from backend
                        "first_name": obj["fname"],
                        "last_name": obj["lanme"],
                        "email": email,
                        "phone": obj["mobile"],
                        "address": obj["address"],
                        "city": obj["city"],
                        "country": "Sri Lanka",
                        "delivery_address": obj["address"],
                        "delivery_city": obj["city"],
                        "delivery_country": "Sri Lanka",
                        "custom_1": "",
                        "custom_2": ""
                    };

                    // Show the payhere.js popup, when "PayHere Pay" is clicked
                  // document.getElementById('payhere-payment').onclick = function (e) {
                    
                        payhere.startPayment(payment);
                        
                  //  };
                }
                
            }
        }
        r.open("POST", "buyNowProcess.php", true);
        r.send(f);
       
        
}

function updateQty(id,qty){
    var f = new FormData();
    f.append("pId" , id);
    f.append("qty" , qty);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
            var text = r.responseText;
           
        }
    }
    r.open("POST", "updateQtyProcess.php", true);
    r.send(f);
}

function invoice(orderId,pid,qty,total,deleveryFee){
    // var f = new FormData();
    // f.append("orderId" , orderId);
    // f.append("pId" , pid);
    // f.append("qty" , qty);
    // f.append("tot" , total);
    // f.append("fee" , deleveryFee);
    // var r = new XMLHttpRequest();
    // r.onreadystatechange = function () {
    //     if (r.status == 200 && r.readyState == 4) {
    //         var text = r.responseText;
           
    //     }
    // }
    // r.open("POST", "invoice.php", true);
    // r.send(f);
    window.location = "invoice.php?orderId="+orderId+"&pId="+pid+"&qty="+qty+"&tot="+total+"&fee="+deleveryFee;
}

function printInvoice(){
    var page = document.body.innerHTML;
    var restor = page;
    var invoice = document.getElementById("main");
    var btn = document.getElementById("printBtn");

    btn.classList.toggle("d-none");
    document.body.innerHTML = invoice.innerHTML;
    window.print();
    document.body.innerHTML = restor;
    btn.classList.toggle("d-none");
    
}



// function feedback(){
//     var document
//     var r = new XMLHttpRequest();
//     r.onreadystatechange = function () {
//         if (r.status == 200 && r.readyState == 4) {
//             var text = r.responseText;
//            alert(text);
//         }
//     }
//     r.open("POST", "updateQtyProcess.php", true);
//     r.send(f);
// }


var newpM;
function forget() {
    var email = document.getElementById("email");
    var f = new FormData();
    f.append("e", email.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4 && r.status == 200 ){
            var text = r.responseText;
            if ( text == "send") {
                newpM = document.getElementById("npm");
                var mod = new bootstrap.Modal(newpM);
                mod.show();
            }else{
                alert(text)
            }
        }
    }
    r.open("POST" , "forgetPasswordProcess.php" , true );
    r.send(f);
}

function chnagePassword(){
    var np = document.getElementById("np");
    var rnp = document.getElementById("rnp");
    var vc = document.getElementById("vc");
    var email = document.getElementById("email");

    var f = new FormData();
    f.append("em" , email.value);
    f.append("np" , np.value);
    f.append("rnp" , rnp.value);
    f.append("vc" , vc.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4 && r.status == 200 ){
            var text = r.responseText;
            if ( text == "done" ){
                alert("Password Changed");
                window.location.reload();
            }else {
                alert(text);
            }
        }
    }
    r.open("POST" , "changePasswordProcess.php" , true );
    r.send(f);
}

function changeMenu(){
    var cat = document.getElementById("cat");
    var searchRs = document.getElementById("searchRs");
    var main = document.getElementById("main");
    var f = new FormData();

    cat.onchange = function (){
        f.append("cat" , cat.value);

        var r = new XMLHttpRequest();
        r.onreadystatechange = function() {
            if (r.readyState == 4 && r.status == 200 ){
                var text = r.responseText;
                if ( text == "0"){
                    main.className = "row mt-2 justify-content-center text-center  ";
                    searchRs.className = "row mt-2 justify-content-center text-center d-none";
                }else {
                    
                    main.className = "row mt-2 justify-content-center text-center d-none";
                    searchRs.innerHTML = text;
                    searchRs.className = "row mt-2 justify-content-center text-center";
                }
                

            }
        }
        r.open("POST" , "ChangeMune.php" , true );
        r.send(f);
    }
}

function searchText() {
    var cat = document.getElementById("cat");
    var searchRs = document.getElementById("searchRs");
    var main = document.getElementById("main");
    var text = document.getElementById("searchText");

    var f = new FormData();
    f.append("cat" , cat.value);
    f.append("text" , text.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4 && r.status == 200 ){
            var text = r.responseText;
            if ( text == "empty"){
                alert("Please Enter Product Title");
            }else{
                main.className = "row mt-2 justify-content-center text-center d-none";
                searchRs.innerHTML = text;
                searchRs.className = "row mt-2 justify-content-center text-center";
            }
           
         }
    }
    r.open("POST" , "homeSearchProcess.php" , true );
    r.send(f);
}


function viewMore(){
    var too = document.getElementById("tooltip");
    var tooltip = new bootstrap.Tooltip(too);
    tooltip.show();
    
}

function goToAdminLogin(){
    window.location = "adminLogin.php";
}

function adminLoginModel() {
    var email = document.getElementById("adminEmail");
    var password = document.getElementById("adminPassword");
    var f = new FormData();
    f.append("e" , email.value);
    f.append("pw" , password.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function(){
        if( r.readyState == 4 && r.status == 200 ){
            var text = r.responseText;
            if ( text == "done"){
                var adminModel = document.getElementById("adminModal");
                var newModel = new bootstrap.Modal(adminModel);
                newModel.show();
            }else {
                alert(text);
            }

        }
    }
    r.open("POST","adminLoginProcess1.php" , true);
    r.send(f);

   
}
function adminLogin() {
    var vCode = document.getElementById("adminVericode");
    var f = new FormData();
    f.append("vc" , vCode.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function(){
        if( r.readyState == 4 && r.status == 200 ){
            var text = r.responseText;
            if ( text == "done"){
                window.location="index.php";
            }else {
                alert(text);
            }

        }
    }
    r.open("POST","adminLoginProcess2.php" , true);
    r.send(f);
}