let loggedIn = false;

window.onclick = function (event) {
    var modal = document.getElementById("myModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

function showModal(product) {
    var modal = document.getElementById("myModal");
    modal.style.display = "block";
    document.getElementsByClassName("modal-text")[0].innerHTML = "Looks like you are not logged in. If you would like to download " + product + ", please login and try again.";
}

function dismissModal() {
    document.getElementById("myModal").style.display = "none";
}

function fetchFile(product) {
    //this will fetch the file in the future.

}

function downloadFile(param) {
    var ref = param.parentElement.children[0].href;
    var pattern = /.*\/(\w*)\.html/;
    var product = pattern.exec(ref)[1];
    if (!loggedIn) {
        showModal(product);
    } else {
        fetchFile(product);
    }
}