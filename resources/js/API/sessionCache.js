export const sessionCache = {
    load: function (key) {
        let json = window.sessionStorage.getItem(key)
        return JSON.parse(json)
    },
    save: function (key, content) {
        window.sessionStorage.setItem(key, JSON.stringify(content))
    },
    clearAll: function() {
        window.sessionStorage.clear();
    },
    clear: function(key) {
        window.sessionStorage.removeItem(key);
    },
    has: function(key) {
        return this.load(key) !== null;
    }
}
