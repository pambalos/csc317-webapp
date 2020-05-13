var all = [1,2,3,4,5,6,7,8,9,10,11,12];
var priceChart = [20, 30, 20, 20, 10, 20, 50, 20, 20, 10, 40, 1000];


function remove(item){
    console.log("remove this object",item);

    removeCookies(item);
    load();
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

            output.push("<td> <img src=\"resources/static/product"+key[0]+".jpg\" style=\"width:600px;height:400px;>\" </td>");//jpg
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
    if (ct === 0){
        //console.log("here");
        content = '<div>  <div class="a-column a-span8 a-span-last"> <div class="a-row sc-your-cart-is-empty"> <h2> Your cart is empty </h2>        </div>        <div class="a-row sc-shop-todays-deals-link">          <a class="a-link-normal" href="productspage.html">            Shop deals now         </a>        </div>      </div> </div>';
    }
    var el = document.getElementById('display');
    //el.insertAdjacentHTML('display', content);
    document.getElementById("display").innerHTML = content;
}

function paynow(){
    window.location = "checkout.php"; // Redirecting to other page.
    return false;
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
