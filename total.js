
var attempt = 3; // Variable to count number of attempts.
// Below function Executes on click of login button.


var userpass = {};
userpass["user01"] = "pass01";
userpass["user02"] = "pass02";

var all = [1,2,3,4,5,6,7,8,9,10,11,12];
var priceChart = [20, 30, 20, 20, 10, 20, 50, 20, 20, 10, 40, 1000];
//ref:https://www.cnblogs.com/fishtreeyu/archive/2011/10/06/2200280.html
function setCookie(name, value) {
    document.cookie = name + "=" + value+("; path=/");
}

setCookie("user03", "pass03");
setCookie("user04", "pass04");
// function listCookies() {
//     var result = document.cookie;
//     document.getElementById("temp").innerHTML=result;
//     console.log(result)
// }

function update() {
    var result = document.cookie;
    var multiple = result.split(";");
    for (var i = 0; i < multiple.length; i++) {
        var key = multiple[i].split("=");
        //console.log(key[0], key[1]);
        if (key[0].trim() in userpass || key[0].trim() >= 13 ) {

        } else {
            userpass[key[0].trim()] = key[1];
        }
    }
    //console.log(userpass);
}
function removeCookies(togo) {
    var res = document.cookie;
    var multiple = res.split(";");
    for(var i=0;i<multiple.length;i++) {
       var key = multiple[i].split("=");
       if (key[0] == togo){
        document.cookie=key[0]+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
    }
    }
 }

update();
//console.log(userpass);
function validate() {
    update();
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    if (username in userpass && password == userpass[username]) {
        alert("Login successfully");
        console.log("success");
        update();
        attempt = 3
        setCookie("in",true);
        window.location = "Cart.html"; // Redirecting to other page.
        return false;
    }
    else {
        attempt--;// Decrementing by one.
        alert("You have left " + attempt + " attempt;");
        console.log(userpass[username]);
        // Disabling fields after 3 attempts.
        if (attempt == 0) {
            document.getElementById("username").disabled = true;
            document.getElementById("password").disabled = true;
            document.getElementById("submit").disabled = true;
            return false;
        }
    }
}

function addUser() {

    var username = document.getElementById("addusername").value;
    var password = document.getElementById("addpassword").value;
    if (username in userpass) {
        alert("Username already exsits.");
        window.location = "sign_in.html"; // Redirecting to other page.
        return false;
    } else {
        setCookie(username, password)
        alert("Username added.");
        update();
        window.location = "sign_in.html"; // Redirecting to other page.
        return false;
    }
}

function signout(){
    setCookie("in", false);
    

    //clear cookies for cart info

    update();
    alert("Signed out");
    window.location = "sign_in.html";
    return false;
}












//from here product page
// ************************************************
// Shopping Cart API
// ************************************************








var all = [1,2,3,4,5,6,7,8,9,10,11,12];
//ref:https://www.cnblogs.com/fishtreeyu/archive/2011/10/06/2200280.html











//from here product page
// ************************************************
// Shopping Cart API
// ************************************************
function addProduct(type){

    var result = document.cookie;
    var multiple = result.split(";");
    for (var i = 0; i < multiple.length; i++) {
        var key = multiple[i].split("=");
        //console.log(key[0], key[1]);
        if (key[0].trim() == type) {
            console.log(key[1]);
            setCookie(key[0].trim(), Number(key[1])+1);


            return false;
        } else {}
    }
    setCookie(type, 1);

}

function load(){

    var ct = 0;
    var result = document.cookie;
    console.log(result);
    var multiple = result.split(";");
    var cartThings = [];
    var output = [];
    var totalPrice = 0;
    output.push("<table style=\"width: 95%\">");
    for (var i = 0; i < multiple.length; i++) {
        var key = multiple[i].split("=");
        //console.log(key[0], key[1]);
        key[0] = Number(key[0].trim());
        //console.log(multiple.length, i, key[0]);

        if ( all.includes( key[0] ) ) {
            ct ++;
            totalPrice += Number(priceChart[key[0]-1]) * Number(key[1]);
            console.log(totalPrice);
            cartThings.push([key[0],key[1]]);
            output.push("<tr>");

            output.push("<td> <img src=\"./resources/product"+key[0]+".jpg\" style=\"width:600px;height:400px;>\" </td>");//jpg
            output.push("<td >" + "Item hash key: "+ makeid(8) +  "</td>")//id
            output.push("<td >" + "Unit Price: "+ Number(priceChart[key[0]-1]) +  "</td>" );  
            output.push("<td >" + "Amount: "+ key[1] +  "</td>" )//name
            output.push("<td> <button class=\"button2\" type = \"button\" onclick = \"remove(" + key[0]+ ")\"> REMOVE </button> </td>");




            output.push("</tr>");
            //later
        } else {}
    }
    output.push("</table>   ");
    console.log(cartThings);
    output.push("<div class=\"form-container2\">");
    output.push("<form class=\"form\">");
    //output.push("<div >" + "total price is "+ totalPrice +  "</div>" );
    output.push("<button type=\"button\" class=\"form-button\" id = \"tocheckoutpage\" onclick=\"paynow()\">Checkout<br>Total Price: "+totalPrice +"</button>");
    output.push("</form>");
    output.push("</div>");
    content = output.join(" ");
    if (ct == 0){
        //console.log("here");
        content = '<div>  <div class="a-column a-span8 a-span-last"> <div class="a-row sc-your-cart-is-empty"> <h2> Your cart is empty </h2>        </div>        <div class="a-row sc-shop-todays-deals-link">          <a class="a-link-normal" href="productspage.html">            Shop deals now         </a>        </div>      </div> </div>';
    }
    var el = document.getElementById('display');
    //el.insertAdjacentHTML('display', content);
    document.getElementById("display").innerHTML = content;
}

function remove(item){
    console.log("remove this object",item);

    removeCookies(item);
    load();
}


function paynow(){
    window.location = "checkout.html"; // Redirecting to other page.
    return false;
}

function checked(){

    var a = document.getElementById("receiverEmail");
    var b = document.getElementById("creditCardNum");
    var c = document.getElementById("CVV");
    var d = document.getElementById("expDate");
    var e = document.getElementById("zipCode");

    console.log(a.value);
    if (a.value == "" || b.value == ""|| c.value == ""|| d.value == ""|| e.value == ""){
        alert("Please double check you payment and shipping information.");
        return false;
    }else{

    alert("Thanks for the donation. Time to report replace your credit card now.");
    window.location = "./productspage.html"; // Redirecting to other page.
    return false;
}
}


function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
       result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
 }
 
 console.log(makeid(5));