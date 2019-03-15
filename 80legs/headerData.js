// This 80app returns the header data from each URL crawled

var EightyApp = function() {
        this.processDocument = function(html, url, headers, status, jQuery) {
                var app = this;
                var $ = jQuery;
                var $html = app.parseHtml(html, $);
                var object = {};

                if(typeof headers == 'string' || headers instanceof String) {
                        var headersArray = headers.split("\r\n");
                        for (var i = 0; i < headersArray.length; i++) {
                                var keyvalArray = headersArray[i].split(": ");
                                var key = keyvalArray[0];
                                var value = keyvalArray[1];
                                object[key] = value;
                        }

                        return JSON.stringify(object);
                }

                return JSON.stringify(headers);
        }        
}

module.exports = function (EightyAppBase) {
        EightyApp.prototype = new EightyAppBase();
        return new EightyApp();
}