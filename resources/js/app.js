/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('currency-converter', require('./components/CurrencyConverter.vue').default);
Vue.component('history', require('./components/History.vue').default);
Vue.component('favourites', require('./components/Favourites.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

window.test = app;

let counter = 1;

app.$on('addAlert', function(){
    console.log("here");
    $(document).ready(function() {
        $(".messages").append("<div class=\"alert alert-success alert-dismissible fade show alert-margin item-"+counter+"\" role=\"alert\">\n" +
            "               Favourites updated successfully.\n" +
            "               <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
            "                   <span aria-hidden=\"true\">&times;</span>\n" +
            "               </button>\n" +
            "           </div>");
        $(".messages .item-"+counter).fadeTo(1500, 250).slideUp(350, function() {
            $(".messages .item-"+counter).slideUp(350, function(){
                $(".messages .item-"+counter).remove();
            });
        });
    });
});

$('li.nav-item').on('click', function(event) {
    app.$children.forEach(function(child) {
        if(child.db !== null) {
            child.db = JSON.parse(window.localStorage.getItem("favourites")).reverse() || [];
        }
    
        if(child.historyDb !== null) {
            child.historyDb = JSON.parse(window.localStorage.getItem("history")).reverse() || [];
        }
    });
});