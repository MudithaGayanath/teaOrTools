var date = new Date();
var monthNumber = date.getMonth() + 1; // Adding 1 to get the 1-based month number
console.log(monthNumber);

function register() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var pw1 = document.getElementById("pw1");
  var pw2 = document.getElementById("pw2");
  var mobile = document.getElementById("mobile");
  var gen = document.getElementById("gen");

  var f = new FormData();
  f.append("fn", fname.value);
  f.append("ln", lname.value);
  f.append("e", email.value);
  f.append("pw1", pw1.value);
  f.append("pw2", pw2.value);
  f.append("m", mobile.value);
  f.append("g", gen.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        alert("You are successfully registered.Please login");
        loader.className = "d-none";
        window.location = "login.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "registrationProcess.php", true);
  r.send(f);
}

function login() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var email = document.getElementById("email");
  var pw = document.getElementById("pw");
  var rem = document.getElementById("rme");

  var f = new FormData();
  f.append("e", email.value);
  f.append("pw", pw.value);
  f.append("rem", rem.checked);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        loader.className = "d-none";
        window.location = "index.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "loginProcess.php", true);
  r.send(f);
}

function goToLogin() {
  window.location = "login.php";
}

function regiter() {
  window.location = "register.php";
}

function ptod() {
  var proId = document.getElementById("provinc");
  var distric = document.getElementById("distric");
  var city = document.getElementById("city");

  proId.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          distric.innerHTML = "<option value='0'> Select District </option>";
          city.innerHTML = "<option value='0'> Select City </option>";
          distric.setAttribute("ture");
          city.setAttribute("ture");
        } else {
          distric.innerHTML = text;
        }
      }
    };
    r.open("GET", "proToDic.php?proid=" + proId.value, true);
    r.send();
  };
}

function newProToDis() {
  var proId = document.getElementById("newProvinc");
  var distric = document.getElementById("newDistric");
  var city = document.getElementById("newCity");

  proId.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          distric.innerHTML = "<option value='0'> Select District </option>";
          city.innerHTML = "<option value='0'> Select City </option>";
          distric.setAttribute("ture");
          city.setAttribute("ture");
        } else {
          distric.innerHTML = text;
        }
      }
    };
    r.open("GET", "proToDic.php?proid=" + proId.value, true);
    r.send();
  };
}

function dtoc() {
  var distric = document.getElementById("distric");
  var city = document.getElementById("city");

  distric.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          city.innerHTML = "<option value='0'> Select City </option>";
          distric.setAttribute("ture");
        } else {
          city.innerHTML = text;
        }
      }
    };
    r.open("GET", "dicToCity.php?disId=" + distric.value, true);
    r.send();
  };
}

function newDisToCity() {
  var distric = document.getElementById("newDistric");
  var city = document.getElementById("newCity");

  distric.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          city.innerHTML = "<option value='0'> Select City </option>";
          distric.setAttribute("ture");
        } else {
          city.innerHTML = text;
        }
      }
    };
    r.open("GET", "dicToCity.php?disId=" + distric.value, true);
    r.send();
  };
}

function updateProfileImg() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
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
          r.onreadystatechange = function () {};
          r.open("POST", "addUserProfileProcess.php", true);
          r.send(f);
          loader.className = "d-none";
        } else {
          alert(response);
          loader.className = "d-none";
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

  if (pass.type == "password") {
    pass.type = "text";
    btn.innerHTML = "Hide";
  } else {
    pass.type = "password";
    btn.innerHTML = "Show";
  }
}

function addAddress() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var address1 = document.getElementById("address1");
  var address2 = document.getElementById("address2");
  var provinc = document.getElementById("provinc");
  var distric = document.getElementById("distric");
  var city = document.getElementById("city");

  var f = new FormData();
  f.append("address1", address1.value);
  f.append("address2", address2.value);
  f.append("provinc", provinc.value);
  f.append("distric", distric.value);
  f.append("city", city.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        alert("Address Added Succsessfully");

        window.location.reload();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "addAddressProcess.php", true);
  r.send(f);
}

function changeAddressOpenModal() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var model = document.getElementById("model");
  var newModel = new bootstrap.Modal(model);
  loader.className = "d-none";
  newModel.show();
}

function changeAddress() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var address1 = document.getElementById("newAdd");
  var address2 = document.getElementById("newAdd2");
  var provinc = document.getElementById("newProvinc");
  var distric = document.getElementById("newDistric");
  var city = document.getElementById("newCity");

  var f = new FormData();
  f.append("address1", address1.value);
  f.append("address2", address2.value);
  f.append("provinc", provinc.value);
  f.append("distric", distric.value);
  f.append("city", city.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "updated") {
        alert("Address  Updated Succsessfully");
        window.location.reload();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "addAddressProcess.php", true);
  r.send(f);
}

function goToAddProduct() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "addProduct.php";
}

function changeBrand() {
  var loader = document.getElementById("loader-2");

  var cat = document.getElementById("categorie");
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var color = document.getElementById("color");
  var f = new FormData();
  var r = new XMLHttpRequest();
  cat.onchange = function () {
    loader.className = "loader";
    f.append("catId", cat.value);

    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          brand.innerHTML = "<option value='0'> Select Brand </option>";
          model.innerHTML = "<option value='0'> Select Model </option>";
          color.innerHTML = "<option value='0'> Select Model </option>";
          brand.setAttribute("true");
          model.setAttribute("true");
          color.setAttribute("true");
          loader.className = "d-none";
        } else {
          brand.innerHTML = text;
          loader.className = "d-none";
        }
      }
    };
    r.open("POST", "changeBrand.php", true);
    r.send(f);
  };
}

function changeModel() {
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");

  var f = new FormData();
  var r = new XMLHttpRequest();
  brand.onchange = function () {
    var loader = document.getElementById("loader-2");
    loader.className = "loader";
    f.append("brandId", brand.value);

    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          model.innerHTML = "<option value='0'> Select Model </option>";
          model.setAttribute("true");
          loader.className = "d-none";
        } else {
          model.innerHTML = text;
          loader.className = "d-none";
        }
      }
    };
    r.open("POST", "changeModel.php", true);
    r.send(f);
  };
}

function changeColor() {
  var model = document.getElementById("model");
  var color = document.getElementById("color");

  var f = new FormData();
  var r = new XMLHttpRequest();
  model.onchange = function () {
    var loader = document.getElementById("loader-2");
    loader.className = "loader";
    f.append("modelId", model.value);

    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          color.innerHTML = "<option value='0'> Select Color </option>";
          color.setAttribute("ture");
          loader.className = "d-none";
        } else {
          color.innerHTML = text;
          loader.className = "d-none";
        }
      }
    };
    r.open("POST", "changeColor.php", true);
    r.send(f);
  };
}

function addproductImg() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
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
          loader.className = "d-none";
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
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var category = document.getElementById("categorie");
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var title = document.getElementById("title");
  var condition = document.getElementById("condition");
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

  for (var x = 0; x < images.files.length; x++) {
    form.append("i" + x, images.files[x]);
  }

  var request = new XMLHttpRequest();
  request.onreadystatechange = function () {
    if ((request.status == 200) & (request.readyState == 4)) {
      var text = request.responseText;
      if (text == "add") {
        loader.className = "d-none";
        alert("Product Added Successfully");
        window.location = "myProducts.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  request.open("POST", "addProductProcess.php", true);
  request.send(form);
}

function myProductSearch() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var row = document.getElementById("sortRow");
  var serch = document.getElementById("text");

  var f = new FormData();
  f.append("text", serch.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "empty") {
        loader.className = "d-none";
        alert("Enter Product Title");
      } else {
        row.innerHTML = text;
        loader.className = "d-none";
      }
    }
  };
  r.open("POST", "myProductSearchProcess.php", true);
  r.send(f);
}

function stor() {
  var storId = document.getElementById("stor");
  var row = document.getElementById("sortRow");
  var f = new FormData();
  var r = new XMLHttpRequest();

  storId.onchange = function () {
    var loader = document.getElementById("loader-2");
    loader.className = "loader";
    f.append("sId", storId.value);
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var text = r.responseText;
        row.innerHTML = text;
        loader.className = "d-none";
      }
    };
    r.open("POST", "myProductStorProcess.php", true);
    r.send(f);
  };
}

function active(id) {
  var home = document.getElementById("h");
  var profile = document.getElementById("p");
  var product = document.getElementById("mp");
  var selling = document.getElementById("s");
  var cart = document.getElementById("c");
  var wish = document.getElementById("wish");
  var history = document.getElementById("his");
  var help = document.getElementById("hel");
  var login = document.getElementById("log");

  if (id == 1) {
    home.className = "nav-link active";
  } else if (id == 2) {
    profile.className = "nav-link active";
  } else if (id == 3) {
    product.className = "nav-link active";
  } else if (id == 4) {
    login.className = "nav-link text-success active";
  } else if (id == 5) {
    cart.className = "nav-link  active";
  } else if (id == 6) {
    wish.className = "nav-link  active";
  } else if (id == 7) {
    history.className = "nav-link  active";
  } else if (id == 8) {
    selling.className = "nav-link  active";
  } else if (id == 9) {
    help.className = "nav-link  active";
  }
}

function logOut() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "done") {
        loader.className = "d-none";
        window.location = "index.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("GET", "logOutProcess.php", true);
  r.send();
}

function postalcode() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var pc = document.getElementById("newPCode");
  var city = document.getElementById("newCity");

  city.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var text = r.responseText;
        pc.value = text;
        loader.className = "d-none";
      }
    };
    r.open("GET", "postalCodeProcess.php?cId=" + city.value, true);
    r.send();
  };
}

function postalcode2() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var pc = document.getElementById("pCode");
  var city = document.getElementById("city");

  city.onchange = function () {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var text = r.responseText;
        pc.value = text;
        loader.className = "d-none";
      }
    };
    r.open("GET", "postalCodeProcess.php?cId=" + city.value, true);
    r.send();
  };
}

function wish(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "a") {
        alert("Added to Wish List");
        window.location.reload();
      } else if (text == "r") {
        alert("Removed From Wish List");
        window.location.reload();
      } else if (text == "l") {
        window.location = "login.php";
      }
    }
  };
  r.open("GET", "wishListProcess.php?pId=" + id, true);
  r.send();
}

var cid;
var cartModal;
function addToCartModal(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  cid = id;
  var cm = document.getElementById("cartModal");
  cartModal = new bootstrap.Modal(cm);
  loader.className = "d-none";
  cartModal.show();
}

function addToCartFormIndex() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";

  var cartQty = document.getElementById("cartQty");

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "Added To Cart") {
        alert("Added To Cart");
        window.location = "cart.php";
      } else if (text == "Self Items Can't Add To Cart") {
        loader.className = "d-none";
        alert(text);
        cartModal.hide();
      } else if (text == "Invalid Number") {
        alert(text);
        cartQty.value = 1;
        loader.className = "d-none";
      } else if (text == "Over Limit") {
        alert(text);
        cartQty.value = 1;
        loader.className = "d-none";
      } else {
        alert("Please Login");
        window.location = "login.php";
      }
    }
  };
  r.open(
    "GET",
    "addToCartProcess.php?pId=" + cid + "&qty=" + cartQty.value,
    true
  );
  r.send();
}

function addToCart(pid) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var cartQty = document.getElementById("qty");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "Added To Cart") {
        alert("Added To Cart");
        window.location = "cart.php";
      } else if (text == "Self Items Can't Add To Cart") {
        alert(text);
        window.location.reload();
      } else if (text == "Invalid Number") {
        alert(text);
        cartQty.value = 1;
        loader.className = "d-none";
      } else if (text == "Over Limit") {
        alert(text);
        cartQty.value = 1;
      } else if (text == "Please Enter QTY") {
        loader.className = "d-none";
        alert(text);
      } else if (text == "log") {
        window.location = "login.php";
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open(
    "GET",
    "addToCartProcess.php?pId=" + pid + "&qty=" + cartQty.value,
    true
  );
  r.send();
}

function removeFromCart(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "r") {
        alert("Removed From Cart");
        window.location.reload();
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("GET", "removeFromCartProcess.php?cId=" + id, true);
  r.send();
}

function goToSingaleProductView(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "singalProductView.php?pid=" + id;
}

function singalProudctTotal(price, items) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var deliveryFee = document.getElementById("deliveryFee");
  var qty = document.getElementById("qty");
  var tot = document.getElementById("tot");

  var f = new FormData();
  f.append("deliveryFee", deliveryFee.value);
  f.append("qty", qty.value);
  f.append("price", price);
  f.append("item", items);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "get") {
        window.location = "index.php";
      } else if (text == "0") {
        tot.value = "0.00";
        loader.className = "d-none";
      } else if (text == "invalid") {
        loader.className = "d-none";
        alert("Invalid QTY");
        window.location.reload();
      } else if (text == "over") {
        alert("Over Limite");
        var newdf = parseInt(deliveryFee.value);
        var itot = price * items + newdf;
        qty.value = items;
        tot.value = itot + ".00";
        loader.className = "d-none";
      } else {
        tot.value = text + ".00";
        loader.className = "d-none";
      }
    }
  };
  r.open("POST", "singalProductTotalProcess.php", true);
  r.send(f);
}

function buyNow(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var tot = document.getElementById("tot");
  var qty = document.getElementById("qty");
  var deliveryFee = document.getElementById("deliveryFee");

  var f = new FormData();
  f.append("pid", id);
  f.append("tot", tot.value);
  f.append("qty", qty.value);
  f.append("deliveryFee", deliveryFee.value);
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;

      if (text == "log") {
        alert("Please Login");
        window.location = "login.php";
      } else if (text == "iqty") {
        alert("Invalid QTY");
        qty.value = 1;
        loader.className = "d-none";
      } else if (text == "address") {
        alert("Add Your Addrss");
        window.location = "userProfile.php";
      } else if (text == "noQt") {
        alert("Please Enter QTY");
        loader.className = "d-none";
      } else if (text == "worng") {
        alert("Something Went Worng");
        window.location = "index.php";
      } else if (text == "self") {
        alert("Self Items Can't Buy");
        loader.className = "d-none";
      } else if (text == "over") {
        alert("Over Limit");
        qty.value = 1;
        loader.className = "d-none";
      } else {
        loader.className = "d-none";
        var obj = JSON.parse(text);
        var amount = obj["total"];
        var email = obj["email"];
        var orderId = obj["orderId"];

        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted(orderId) {
          console.log("Payment completed. OrderID:" + orderId);
          // Note: validate the payment and show success or failure page to the customer
          updateQty(id, qty.value);
          invoice(orderId, id, qty.value, tot.value, deliveryFee.value);
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          console.log("Payment dismissed" + error);
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          console.log("Error:" + error);
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: obj["mid"], // Replace your Merchant ID
          return_url:
            "http://localhost/teaOrTools/singalProductView.php?pid=" + id, // Important
          cancel_url:
            "http://localhost/teaOrTools/singalProductView.php?pid=" + id, // Important
          notify_url: "http://sample.com/notify",
          order_id: obj["orderId"],
          items: obj["productTitle"],
          amount: amount,
          currency: obj["currency"],
          hash: obj["hash"], // *Replace with generated hash retrieved from backend
          first_name: obj["fname"],
          last_name: obj["lanme"],
          email: email,
          phone: obj["mobile"],
          address: obj["address"],
          city: obj["city"],
          country: "Sri Lanka",
          delivery_address: obj["address"],
          delivery_city: obj["city"],
          delivery_country: "Sri Lanka",
          custom_1: "",
          custom_2: "",
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked
        // document.getElementById('payhere-payment').onclick = function (e) {

        payhere.startPayment(payment);

        //  };
      }
    }
  };
  r.open("POST", "buyNowProcess.php", true);
  r.send(f);
}

function updateQty(id, qty) {
  var f = new FormData();
  f.append("pId", id);
  f.append("qty", qty);
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
    }
  };
  r.open("POST", "updateQtyProcess.php", true);
  r.send(f);
}

function invoice(orderId, pid, qty, total, deleveryFee) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location =
    "invoice.php?orderId=" +
    orderId +
    "&pId=" +
    pid +
    "&qty=" +
    qty +
    "&tot=" +
    total +
    "&fee=" +
    deleveryFee;
}

function printInvoice() {
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

var newpM;
function forget() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var email = document.getElementById("email");
  var f = new FormData();
  f.append("e", email.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "send") {
        newpM = document.getElementById("npm");
        var mod = new bootstrap.Modal(newpM);
        loader.className = "d-none";
        mod.show();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "forgetPasswordProcess.php", true);
  r.send(f);
}

function chnagePassword() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var np = document.getElementById("np");
  var rnp = document.getElementById("rnp");
  var vc = document.getElementById("vc");
  var email = document.getElementById("email");

  var f = new FormData();
  f.append("em", email.value);
  f.append("np", np.value);
  f.append("rnp", rnp.value);
  f.append("vc", vc.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        alert("Password Changed");
        window.location.reload();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "changePasswordProcess.php", true);
  r.send(f);
}

function changeMenu() {
  var cat = document.getElementById("cat");
  var searchRs = document.getElementById("searchRs");
  var main = document.getElementById("main");
  var f = new FormData();

  cat.onchange = function () {
    var loader = document.getElementById("loader-2");
    loader.className = "loader";
    f.append("cat", cat.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "0") {
          main.className = "row mt-2 justify-content-center text-center  ";
          searchRs.className =
            "row mt-2 justify-content-center text-center d-none";
          loader.className = "d-none";
        } else {
          main.className = "row mt-2 justify-content-center text-center d-none";
          searchRs.innerHTML = text;
          searchRs.className = "row mt-2 justify-content-center text-center";
          loader.className = "d-none";
        }
      }
    };
    r.open("POST", "ChangeMune.php", true);
    r.send(f);
  };
}

function searchText() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var cat = document.getElementById("cat");
  var searchRs = document.getElementById("searchRs");
  var main = document.getElementById("main");
  var text = document.getElementById("searchText");

  var f = new FormData();
  f.append("cat", cat.value);
  f.append("text", text.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Please Enter Product Title");
        loader.className = "d-none";
      } else {
        main.className = "row mt-2 justify-content-center text-center d-none";
        searchRs.innerHTML = text;
        searchRs.className = "row mt-2 justify-content-center text-center";
        loader.className = "d-none";
      }
    }
  };
  r.open("POST", "homeSearchProcess.php", true);
  r.send(f);
}

function viewMore() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var too = document.getElementById("tooltip");
  var tooltip = new bootstrap.Tooltip(too);
  loader.className = "d-none";
  tooltip.show();
}

function goToAdminLogin() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "adminLogin.php";
}

function adminLoginModel() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var email = document.getElementById("adminEmail");
  var password = document.getElementById("adminPassword");
  var f = new FormData();
  f.append("e", email.value);
  f.append("pw", password.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        var adminModel = document.getElementById("adminModal");
        var newModel = new bootstrap.Modal(adminModel);
        loader.className = "d-none";
        newModel.show();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "adminLoginProcess1.php", true);
  r.send(f);
}

function adminLogin() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var vCode = document.getElementById("adminVericode");
  var f = new FormData();
  f.append("vc", vCode.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        window.location = "adminPanale.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "adminLoginProcess2.php", true);
  r.send(f);
}

function goToUpadteProduct(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "updateProduct.php?pId=" + id;
}

function updateProduct(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var price = document.getElementById("price");
  var status = document.getElementById("status");
  var qty = document.getElementById("qty");
  var inCity = document.getElementById("diuc");
  var outCity = document.getElementById("dofuc");

  var f = new FormData();
  f.append("pId", id);
  f.append("status", status.value);
  f.append("qty", qty.value);
  f.append("inCity", inCity.value);
  f.append("outCity", outCity.value);
  f.append("price", price.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        alert("Product Updated Succsessfully");
        window.location = "myProducts.php";
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "updateProductProcess.php", true);
  r.send(f);
}

const MONTHS = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
function income() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  const ctx = document.getElementById("myChart");

  function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = 0; i < count; ++i) {
      value = MONTHS[Math.ceil(i) % 12];
      values.push(value.substring(0, section));
    }
    return values;
  }
  const labels = months({ count: monthNumber });

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      loader.className = "d-none";
      var obj = JSON.parse(text);
      var length = Object.keys(obj).length;
      const labels = months({ count: length });

      new Chart(ctx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "income",
              data: [
                obj[0],
                obj[1],
                obj[2],
                obj[3],
                obj[4],
                obj[5],
                obj[6],
                obj[7],
                obj[8],
                obj[9],
                obj[10],
                obj[11],
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    }
  };
  r.open("POST", "MonthlySalesProcess.php", true);
  r.send();
}
var viwe = 0;
function salesAlert() {
  var newOrder = document.getElementById("newOrder");
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text > 0) {
        viwe = 1;

        newOrder.innerHTML = text;
        newOrder.className =
          "position-absolute top-0 me-5 start-100 translate-middle badge rounded-pill bg-danger";
      }
      // }else {
      //     viwe = 0;
      // newOrder.className = "position-absolute top-0 me-5 start-100 translate-middle badge rounded-pill bg-danger d-none";
      // }
    }
  };
  r.open("POST", "salesAlertProcess.php", true);
  r.send();
}

if (viwe == 0) {
  setInterval(() => {
    salesAlert();
  }, 3000);
}

function sellerMonthlyIncome() {
  const div = document.getElementById("myChart");

  function months(config) {
    var cfg = config || {};
    var count = cfg.count || 12;
    var section = cfg.section;
    var values = [];
    var i, value;

    for (i = 0; i < count; ++i) {
      value = MONTHS[Math.ceil(i) % 12];
      values.push(value.substring(0, section));
    }
    return values;
  }

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      var obj = JSON.parse(text);
      var length = Object.keys(obj).length;
      const labels = months({ count: monthNumber });

      new Chart(div, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "income",
              data: [
                obj[0],
                obj[1],
                obj[2],
                obj[3],
                obj[4],
                obj[5],
                obj[6],
                obj[7],
                obj[8],
                obj[9],
                obj[10],
                obj[11],
                obj[12],
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    }
  };
  r.open("POST", "sellerMonthlyIncomeProcess.php", true);
  r.send();
}

function adminLogout() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        alert("LogOut Successfully");
        window.location = "index.php";
      }
    }
  };
  r.open("POST", "adninLogoutProcess.php", true);
  r.send();
}

function unviewToViwe(inId) {
  var f = new FormData();
  f.append("inId", inId);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        goToSoldProduct(inId);
      } else {
        alert("Something Went Wrong");
      }
    }
  };
  r.open("POST", "unviewToViweProcess.php", true);
  r.send(f);
}

function goToSoldProduct(inId) {
  window.location = "soldProductView.php?inId=" + inId;
}

function changeOrderStatus(id) {
  var select = document.getElementById("orderStatus");

  select.onchange = function () {
    var f = new FormData();
    f.append("inId", id);
    f.append("sValue", select.value);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.readyState == 4 && r.status == 200) {
        var text = r.responseText;
        if (text == "done") {
          alert("Order Status Updated");
        } else {
          alert(text);
        }
        window.location.reload();
      }
    };
    r.open("POST", "changeOrderStatusProcess.php", true);
    r.send(f);
  };
}

function sold() {
  const div2 = document.getElementById("myChart2");
  var r2 = new XMLHttpRequest();

  r2.onreadystatechange = function () {
    if (r2.readyState == 4 && r2.status == 200) {
      var text2 = r2.responseText;
      var obg2 = JSON.parse(text2);
      new Chart(div2, {
        type: "bar",
        data: {
          labels: ["Tea Plant", "Tea Fertilizer", "Machine"],
          datasets: [
            {
              label: "",
              data: [obg2[0], obg2[1], obg2[2]],
              backgroundColor: [
                "rgba(144,238,144)",
                "rgba(196, 164, 132)",
                "rgba(178,190,181)",
              ],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
            },
          },
        },
      });
    }
  };
  r2.open("POST", "mostSoldCatProcess.php", true);
  r2.send();
}

function goToAdvancedSearch() {
  window.location = "advancedSearch.php";
}

function advancedSearchProcess() {
  var main = document.getElementById("main");
  var text = document.getElementById("searchText");
  var categorie = document.getElementById("categorie");
  var brand = document.getElementById("brand");
  var model = document.getElementById("model");
  var color = document.getElementById("color");
  var condition = document.getElementById("condition");
  if ( categorie.value == 0 && text.value == ""){
    alert("Select categorie or enter prodct title ");
  } else{
    var f = new FormData();
    f.append("categorie", categorie.value);
    f.append("brand", brand.value);
    f.append("model", model.value);
    f.append("color", color.value);
    f.append("condition", condition.value);
    f.append("text", text.value);
    
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var rText = r.responseText;
        
  
          main.innerHTML = rText;
        
      }
    };
    r.open("POST", "advancedSearchProcess.php", true);
    r.send(f);
  }
 
}

function changeUserStatus(i) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var email = document.getElementById(i).value;
  var f = new FormData();
  f.append("e", email);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "done") {
        window.location.reload();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "changeUserStatusProcess.php", true);
  r.send(f);
}

function userFilter() {
  var a = document.getElementById("filter");
  var filterRow = document.getElementById("filterResultRow");
  var main = document.getElementById("mainRow");
  a.onchange = function () {
    if (a.value == 1) {
      window.location = "manageUser.php?orderBy=DESC";
    } else if (a.value == 2) {
      window.location = "manageUser.php?orderBy=ASC";
    } else {
      var f = new FormData();
      f.append("a", a.value);

      var r = new XMLHttpRequest();
      r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
          var text = r.responseText;
          main.className = "d-none";
          filterRow.innerHTML = text;
          filterRow.className =
            "row justify-content-center justify-content-lg-around d-flex";
        }
      };
      r.open("POST", "userFilterProcess.php", true);
      r.send(f);
    }
  };
}

function searchUser() {
  var cat = document.getElementById("cat");
  var name = document.getElementById("searchText");

  var filterRow = document.getElementById("filterResultRow");
  var main = document.getElementById("mainRow");

  var f = new FormData();
  f.append("cat", cat.value);
  f.append("text", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Enter user name or email");
      } else if (text == "invalid") {
        alert("Invalid email");
      } else {
        main.className = "d-none";
        filterRow.innerHTML = text;
        filterRow.className =
          "row justify-content-center justify-content-lg-around d-flex";
      }
    }
  };
  r.open("POST", "searchUserProcess.php", true);
  r.send(f);
}

function productFilter() {
  var p = document.getElementById("productFilter");
  var rr = document.getElementById("filterResultRowPro");
  var mr = document.getElementById("mainRowPro");
  p.onchange = function () {
    var f = new FormData();
    f.append("p", p.value);
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
      if (r.status == 200 && r.readyState == 4) {
        var text = r.responseText;
        mr.className = "d-none";
        rr.innerHTML = text;
        rr.className =
          " row justify-content-center justify-content-lg-around d-flex";
      }
    };
    r.open("POST", "productFilterProcess.php", true);
    r.send(f);
  };
}

function changeProductStatusByAdmin(pid) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var f = new FormData();
  f.append("pid", pid);
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "done") {
        window.location.reload();
      } else {
        loader.className = "d-none";
        alert(text);
      }
    }
  };
  r.open("POST", "changeProductStatusByAdmin.php", true);
  r.send(f);
}

function printChart() {
  // var body = document.body.innerHTML;
  // var btn = document.getElementById("pBtn");
  // var chart = document.getElementById("chart");
  // document.body.innerHTML = chart.innerHTML;
  // window.print();
  // window.location.reload();

  var dataUrl = document.getElementById("myChart").toDataURL();

  var windowContent = "<!DOCTYPE html>";
  windowContent += "<html>";
  windowContent += "<head><title>Print Canvas</title></head>";
  windowContent += "<body>";
  windowContent += '<img src="' + dataUrl + '">';
  windowContent += "</body>";
  windowContent += "</html>";

  var printWin = window.open("", "", "width=800,height=600");
  printWin.document.open();
  printWin.document.write(windowContent);
  printWin.document.close();
  printWin.focus();
  printWin.print();
  printWin.close();
}

function searchProduct() {
  var cat = document.getElementById("pCat");
  var name = document.getElementById("searchText");

  var filterRow = document.getElementById("filterResultRowPro");
  var main = document.getElementById("mainRowPro");

  var f = new FormData();
  f.append("cat", cat.value);
  f.append("text", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Enter owner name or product name");
      } else if (text == "invalid") {
        alert("Invalid email");
      } else {
        main.className = "d-none";
        filterRow.innerHTML = text;
        filterRow.className =
          "row justify-content-center justify-content-lg-around d-flex";
      }
    }
  };
  r.open("POST", "searchProductProcess.php", true);
  r.send(f);
}

function goToCat() {
  window.location = "cat.php";
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
}
function addCatMode() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var m = new bootstrap.Modal(document.getElementById("addCat"));
  loader.className = "d-none";
  m.show();
}

function addCat() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var name = document.getElementById("name");
  var f = new FormData();
  f.append("name", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        loader.className = "d-none";
        alert("Enter categorie");
      } else if (text == "long") {
        loader.className = "d-none";
        alert("Categorie name too long ( Max : 45 characters )");
      } else if (text == "have") {
        loader.className = "d-none";
        alert("Categorie name is already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addCatProcess.php", true);
  r.send(f);
}
function addBrand() {
  var name = document.getElementById("name");
  var f = new FormData();
  f.append("name", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Enter brand");
      } else if (text == "long") {
        alert("Brand name too long ( Max : 45 characters )");
      } else if (text == "have") {
        alert("Brand name is already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addBrandProcess.php", true);
  r.send(f);
}

function goToPanel() {
  window.location = "adminPanale.php";
}

function goToBrand() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "brand.php";
}

function addBrandMode() {
  var m = new bootstrap.Modal(document.getElementById("addBrand"));
  m.show();
}

function goToModel() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "model.php";
}

function addModelode() {
  var m = new bootstrap.Modal(document.getElementById("addModel"));
  m.show();
}

function addModel() {
  var name = document.getElementById("name");
  var f = new FormData();
  f.append("name", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Enter Model");
      } else if (text == "long") {
        alert("Model name too long ( Max : 45 characters )");
      } else if (text == "have") {
        alert("Model name is already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addModelProcess.php", true);
  r.send(f);
}

function goToColor() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "color.php";
}

function addColorModel() {
  var m = new bootstrap.Modal(document.getElementById("addColor"));
  m.show();
}

function addColor() {
  var name = document.getElementById("name");
  var f = new FormData();
  f.append("name", name.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "empty") {
        alert("Enter Color");
      } else if (text == "long") {
        alert("Color name too long ( Max : 45 characters )");
      } else if (text == "have") {
        alert("Color name is already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addColorProcess.php", true);
  r.send(f);
}

function goToBandC() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "brandAndCat.php";
}

function addBandCModel() {
  var m = new bootstrap.Modal(document.getElementById("addBandC"));
  m.show();
}

function addBandC() {
  var bName = document.getElementById("brand");
  var cName = document.getElementById("categorie");
  var f = new FormData();
  f.append("bName", bName.value);
  f.append("cName", cName.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "have") {
        alert("Already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addBandCProcess.php", true);
  r.send(f);
}

function goToMandB() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "modelAndBrand.php";
}

function addMandBModel() {
  var m = new bootstrap.Modal(document.getElementById("addMandB"));
  m.show();
}

function addMandB() {
  var mName = document.getElementById("model");
  var bName = document.getElementById("brand");
  var f = new FormData();
  f.append("mName", mName.value);
  f.append("bName", bName.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "have") {
        alert("Already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addMandBProcess.php", true);
  r.send(f);
}

function goToMandC() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "modelAndColor.php";
}

function addMandCModel() {
  var m = new bootstrap.Modal(document.getElementById("addMandC"));
  m.show();
}

function addMandC() {
  var mName = document.getElementById("model");
  var cName = document.getElementById("color");
  var f = new FormData();
  f.append("mName", mName.value);
  f.append("cName", cName.value);

  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.readyState == 4 && r.status == 200) {
      var text = r.responseText;
      if (text == "have") {
        alert("Already have");
      } else {
        alert(text);
        window.location.reload();
      }
    }
  };
  r.open("POST", "addMandCProcess.php", true);
  r.send(f);
}

function historyFilter() {
  var p = document.getElementById("filter");
  var rr = document.getElementById("rs");
  var mr = document.getElementById("main");
  p.onchange = function () {
    if (p.value == 1) {
      window.location = "history.php?orderBy=DESC";
    } else if (p.value == 2) {
      window.location = "history.php?orderBy=ASC";
    } else {
      var f = new FormData();
      f.append("p", p.value);
      var r = new XMLHttpRequest();
      r.onreadystatechange = function () {
        if (r.status == 200 && r.readyState == 4) {
          var text = r.responseText;
          mr.className = "d-none";
          rr.innerHTML = text;
          rr.className =
            " row justify-content-center justify-content-lg-around d-flex";
        }
      };
      r.open("POST", "historyFilterProcess.php", true);
      r.send(f);
    }
  };
}

var toFeedPId;
function feedModel(id) {
  toFeedPId = id;
  var m = new bootstrap.Modal(document.getElementById("feedModel"));
  m.show();
}

function addFeedProcess() {
  var comment = document.getElementById("comment");
  var type = document.getElementById("type");
  var pid = toFeedPId;
  var f = new FormData();
  f.append("pid", pid);
  f.append("comment", comment.value);
  f.append("type", type.value);
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if (text == "have") {
        alert("You have already added feedback for this product");
      } else if (text == "empty") {
        alert("Enter your comment");
      } else if (text == "long") {
        alert("Comment is too long (Max:200 charactors)");
      } else if (text == "done") {
        alert("Comment added successfully");
        window.location.reload();
      } else {
        alert(text);
      }
    }
  };
  r.open("POST", "addFeedProcess.php", true);
  r.send(f);
}

function goToUserDetails(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var email = document.getElementById(id).innerHTML;
  var f = new FormData();
  f.append("email", email);
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;

      window.location = "userDetails.php?email=" + text;
    }
  };
  r.open("POST", "expoEmailProcess.php", true);
  r.send(f);
}

function pdf() {
  var body = document.body.innerHTML;
  var content = document.getElementById("conten");
  var row = document.getElementById("row");
  row.className = "d-none";
  document.body.innerHTML = content.innerHTML;
  window.print();
  document.body.innerHTML = body;
}

function productDetails(id) {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  window.location = "productDetails.php?pId=" + id;
}

function buyAll() {
  var loader = document.getElementById("loader-2");
  loader.className = "loader";
  var r = new XMLHttpRequest();
  r.onreadystatechange = function () {
    if (r.status == 200 && r.readyState == 4) {
      var text = r.responseText;
      if ( text == "noAddress"){
        alert("Add your address");
        window.location = "userProfile.php";
      }else{
        loader.className = "d-none";
        var obj = JSON.parse(text);
       
      
      // Payment completed. It can be a successful failure.
      payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        // Note: validate the payment and show success or failure page to the customer
       
        cartInvoice();
      };

      // Payment window closed
      payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed" + error);
      };

      // Error occurred
      payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:" + error);
      };

      // Put the payment variables here
      var payment = {
        sandbox: true,
        merchant_id: obj["mid"], // Replace your Merchant ID
        return_url: "http://localhost/teaOrTools/cart.php", // Important
        cancel_url: "http://localhost/teaOrTools/cart.php", // Important
        notify_url: "http://sample.com/notify",
        order_id: obj["orderId"],
        items: obj["productTitle"],
        amount: obj["total"],
        currency: obj["currency"],
        hash: obj["hash"], // *Replace with generated hash retrieved from backend
        first_name: obj["fname"],
        last_name: obj["lanme"],
        email: obj["email"],
        phone: obj["mobile"],
        address: obj["address"],
        city: obj["city"],
        country: "Sri Lanka",
        delivery_address: obj["address"],
        delivery_city: obj["city"],
        delivery_country: "Sri Lanka",
        custom_1: "",
        custom_2: "",
      };


      payhere.startPayment(payment);
    }
      
    }
  };
  r.open("POST", "buyAllProccess.php", true);
  r.send();
}

function cartInvoice(){
  window.location = "cartInvoice.php";
}
function cartPdf(){
  var body = document.body.innerHTML;
  var content = document.getElementById("invoice");
  var row = document.getElementById("btn");
  row.className = "d-none";
  document.body.innerHTML = content.innerHTML;
  window.print();

  document.body.innerHTML = body;
}

function r(){
  window.location.reload();
}

function adReoprt(){
  var text = "<h1>Panel Short Report</h1>";
  var r = document.getElementById("adReport").innerHTML;
  var btn = document.getElementById("save");
  text += r;
  var body = document.body.innerHTML;
  btn.classNam= "d-none";
  document.body.innerHTML = text;
  window.print();
  window.location.reload();

}