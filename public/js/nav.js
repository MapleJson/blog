window.onload = function () {
    var oH2 = document.getElementsByTagName("h2")[0];
    var oUl = document.getElementsByTagName("ul")[0];
    oH2.onclick = function () {
        var style = oUl.style;
        style.display = style.display === "block" ? "none" : "block";
        oH2.className = style.display === "block" ? "open" : ""
    }
};
var obj = null;
var As = document.getElementById('topnav').getElementsByTagName('a');
obj = As[0];
for (var i = 1; i < As.length; i++) {
    if (window.location.href.indexOf(As[i].href) >= 0)
        obj = As[i];
}
obj.id = 'topnav_current';