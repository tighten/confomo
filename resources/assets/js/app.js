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

/** Custom code */
Vue.component('dashboard', {
    data: function() {
        return {
            currentUserId: Confomo.userId,

            conferences: [],

            addConferenceForm: {
                conference: '',
                errors: [],
                adding: false
            },
        };
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

        deleteConference: function (conference, $e) {
            $e.stopPropagation();

            // @todo: Use a more VueJS-y confirm?
            if (! confirm('are you sure?')) {
                return;
            }

            this.conferences = _.reject(this.conferences, function (c) {
                return c.id === conference.id;
            });

            this.$http.delete('/api/conferences/' + conference.id);
        },

        viewConference: function (conference) {
            console.log('Go to conference page');
            document.location.href = '/conferences/' + conference.id;
        },
    }
});

Vue.component('conference', {
    data: function() {
        return {
            currentUserId: Confomo.userId,
            conferenceId: Confomo.conferenceId,

            newFriends: [],

            addNewFriendForm: {
                errors: [],
                adding: false
            },
        };
    },

    ready: function () {
        this.getAllNewFriends();
    },

    methods: {
        getAllNewFriends: function () {
            this.$http.get('/api/conferences/' + this.conferenceId + '/new-friends')
                .success(function (friends) {
                    this.newFriends = friends;
                });
        },

        addNewFriend: function () {
            // @todo: Do validation in a more VueJS-y way?
            if (this.addNewFriendForm.username == '') {
                this.addNewFriendForm.errors = [
                    'You need to actually type something for the name.'
                ];
                this.addNewFriendForm.adding = false;

                return;
            }

            this.addNewFriendForm.errors = [];
            this.addNewFriendForm.adding = true;

            this.$http.post('/api/conferences/' + this.conferenceId + '/new-friends', this.addNewFriendForm)
                .success(function (friend) {
                    this.addNewFriendForm.username = '';
                    this.addNewFriendForm.adding = false;
                    // @todo: Add new friend to the list more cleanly
                    this.getAllNewFriends();
                })
                .error(function (errors) {
                    setErrorsOnForm(this.addNewFriendForm, errors);
                    this.addNewFriendForm.adding = false;
                });
        },

        deleteNewFriend: function (friend) {
            // @todo: Use a more VueJS-y confirm?
            if (! confirm('are you sure?')) {
                return;
            }

            this.newFriends = _.reject(this.newFriends, function (c) {
                return c.id === friend.id;
            });

            this.$http.delete('/api/conferences/' + this.conferenceId + '/new-friends/' + friend.id);
        },

        viewFriend: function (friend) {
            console.log('Go to friend page');
            document.location.href = '/conference/' + this.conferenceId + '/new-friends/' + friend.id;
        },
    }
});

if ($("#confomo-app").length) {
    new Vue({ el: '#confomo-app' });
}
