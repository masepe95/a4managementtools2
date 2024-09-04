// Session/Local Storage managing.
// Copyright Marco Cerulli Consulting ©
// Written by Neil Otupacca.


///////////////////
// Session Storage.

window.setSessionValue = function(key, value) {
    try {
        // Converte gli object e gli array in una stringa JSON.
        var data = (sessionStorage.getItem("a4data")) ? JSON.parse(sessionStorage.getItem("a4data")) : { };
        data[key] = (typeof(value) == "object") ? JSON.stringify(value) : value;
        sessionStorage.setItem("a4data", JSON.stringify(data));
    }
    catch (err) { }
};

window.getSessionValue = function(key) {
    var val = false;
    try {
        var data = (sessionStorage.getItem("a4data")) ? JSON.parse(sessionStorage.getItem("a4data")) : { };
        if (typeof(data[key]) != "undefined") {
            // Ritorna l'object/array rappresentato dalla stringa in formato JSON (se valido).
            var val = data[key];
            val = JSON.parse(val);
        }
    }
    catch (err) { }
    return val;
};

window.deleteSessionKey = function(key) {
    try {
        var data = (sessionStorage.getItem("a4data")) ? JSON.parse(sessionStorage.getItem("a4data")) : { };
        if (data[key] != "undefined") {
            delete data[key];
            sessionStorage.setItem("a4data", JSON.stringify(data));
        }
    }
    catch (err) { }
};

window.clearSessionData = function() {
    if (sessionStorage.getItem("a4data")) sessionStorage.removeItem("a4data");
};


/////////////////
// Local Storage.

window.setLocalValue = function(key, value) {
    try {
        // Converte gli object e gli array in una stringa JSON.
        var data = (localStorage.getItem("a4data")) ? JSON.parse(localStorage.getItem("a4data")) : { };
        data[key] = (typeof(value) == "object") ? JSON.stringify(value) : value;
        localStorage.setItem("a4data", JSON.stringify(data));
    }
    catch (err) { }
};

window.getLocalValue = function(key) {
    var val = false;
    try {
        var data = (localStorage.getItem("a4data")) ? JSON.parse(localStorage.getItem("a4data")) : { };
        if (typeof(data[key]) != "undefined") {
            // Ritorna l'object/array rappresentato dalla stringa in formato JSON (se valido).
            var val = data[key];
            val = JSON.parse(val);
        }
    }
    catch (err) { }
    return val;
};

window.deleteLocalKey = function(key) {
    try {
        var data = (localStorage.getItem("a4data")) ? JSON.parse(localStorage.getItem("a4data")) : { };
        if (data[key] != "undefined") {
            delete data[key];
            localStorage.setItem("a4data", JSON.stringify(data));
        }
    }
    catch (err) { }
};

window.clearLocalData = function() {
    if (localStorage.getItem("a4data")) localStorage.removeItem("a4data");
};
