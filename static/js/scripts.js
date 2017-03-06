/**
 * List of methods
 * @type {{contentLoaded: Function}}
 */
var MethodsForContentLoaded = {
    /**
     * Method for show json as pretty
     */
    jsonPretty: function ($jsonStringId, jsonAppendId) {
        var json = document.getElementById($jsonStringId).innerText;
        if (json != undefined && json != '') {
            json = JSON.parse(json);
            if (json != undefined && json != '') {
                json = JSON.stringify(json, null, " ");
                document.getElementById(jsonAppendId).innerHTML = json.replace(/(?:\r\n|\r|\n)/g, '<br/>').replace(/(?:\s)/g, '&nbsp;');
            }
        }
    }
};
/**
 * Event for all html loaded
 */
document.addEventListener("DOMContentLoaded", function () {
    MethodsForContentLoaded.jsonPretty('resultJson', 'prettyResultJson');
});