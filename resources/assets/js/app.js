// Core Application Dependencies...
require('./core/dependencies');

/** Bootstrapp copied wholesale from Taylor's Zendcon talk */
// Flatten errors and set them on the given form
var setErrorsOnForm = function (form, errors) {
    if (typeof errors === 'object') {
        form.errors = _.flatten(_.toArray(errors));
    } else {
        form.errors.push('Something went wrong. Please try again.');
    }
};

Vue.config.debug = true;

import Dashboard from './components/Dashboard.vue';
import FriendsList from './components/FriendsList.vue';
import Conference from './components/Conference.vue';

// Global Errors Component...
Vue.component('form-errors', require('./components/FormErrors.vue'));

if ($("#confomo-app").length) {
    new Vue({
        el: '#confomo-app',

        components: {
            Dashboard,
            Conference
        }
    });
}
