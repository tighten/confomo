// Core Application Dependencies...
require('./core/dependencies')

// Flatten errors and set them on the given form
var setErrorsOnForm = function (form, errors) {
    if (typeof errors === 'object') {
        form.errors = _.flatten(_.toArray(errors));
    } else {
        form.errors.push('Something went wrong. Please try again.');
    }
};

// Errors Component...
Vue.component('form-errors', {
    props: ['form'],

    template: `
    <div class="alert alert-danger" v-if="form.errors.length > 0">
        <strong>Whoops!</strong> Looks like something went wrong!

        <br><br>

        <ul>
            <li v-for="error in form.errors">
                {{ error }}
            </li>
        </ul>
    </div>
    `
})

// Vue Application
var app = new Vue({
    el: '#confomo-app',

    data: {
        currentUserId: Confomo.userId,

        conferences: [],

        addConferenceForm: {
            conference: '',
            errors: [],
            adding: false
        },
    },

    ready: function () {
        this.getAllConferences();
    },

    computed: {
    },

    methods: {
        getAllConferences: function () {
            this.$http.get('/api/conferences')
                .success(function (conferences) {
                    this.conferences = conferences;
                });
        },

        addConference: function () {
            // @todo: Do validation in a more VueJS-y way?
            if (this.addConferenceForm.name == '') {
                this.addConferenceForm.errors = [
                    'You need to actually type something for the name.'
                ];
                this.addConferenceForm.adding = false;

                return;
            }

            this.addConferenceForm.errors = [];
            this.addConferenceForm.adding = true;

            this.$http.post('/api/conferences', this.addConferenceForm)
                .success(function (conference) {
                    this.addConferenceForm.name = '';
                    this.addConferenceForm.adding = false;
                    // @todo: Add new conference to the list more cleanly
                    this.getAllConferences();
                })
                .error(function (errors) {
                    setErrorsOnForm(this.addConferenceForm, errors);
                    this.addConferenceForm.adding = false;
                });
        },

        deleteConference: function (conference) {
            // @todo: Use a more VueJS-y confirm?
            if (! confirm('are you sure?')) {
                return;
            }

            this.conferences = _.reject(this.conferences, function (c) {
                return c.id === conference.id;
            });

            this.$http.delete('/api/conferences/' + conference.id);
        },
    }
})
