"use strict";
function load_script(url, callback) {
    
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;
    if (callback != null) {
        script.onload = function () {
            callback();
        };
    }
    document.getElementsByTagName("head")[0].appendChild(script);
}

