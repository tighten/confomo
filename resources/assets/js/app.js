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
});

Vue.component('friends-list', {
    props: ['list', 'key', 'conferenceId', 'descriptor'],

    data: function () {
        return {
            addFriendForm: {
                errors: [],
                adding: false,
                username: ''
            },
        };
    },

    ready: function() {
        this.getAllFriends();
    },

    methods: {
        getAllFriends: function () {
            this.$http.get('/api/conferences/' + this.conferenceId + '/' + this.key)
                .success(function (friends) {
                    this.list = friends;
                });
        },

        addFriend: function () {
            // @todo: Do validation in a more VueJS-y way?
            if (this.addFriendForm.username == '') {
                this.addFriendForm.errors = [
                    'You need to actually type something for the name.'
                ];
                this.addFriendForm.adding = false;

                return;
            }

            this.addFriendForm.errors = [];
            this.addFriendForm.adding = true;

            this.$http.post('/api/conferences/' + this.conferenceId + '/' + this.key, this.addFriendForm)
                .success(function (friend) {
                    this.addFriendForm.username = '';
                    this.addFriendForm.adding = false;
                    // @todo: Add friend to the list more cleanly
                    this.getAllFriends();
                })
                .error(function (errors) {
                    setErrorsOnForm(this.addFriendForm, errors);
                    this.addFriendForm.adding = false;
                });
        },

        deleteFriend: function (friend) {
            // @todo: Use a more VueJS-y confirm?
            if (! confirm('are you sure?')) {
                return;
            }

            this.list = _.reject(this.list, function (c) {
                return c.id === friend.id;
            });

            this.$http.delete('/api/conferences/' + this.conferenceId + '/' + this.key + '/' + friend.id);
        },
    },

    template: `
            <!-- Friend Listing -->
            <h2>{{ descriptor }} Friends</h2>
            <div v-if="list.length > 0">
                <div class="row" v-for="friend in list">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-left" style="padding-top: 6px;">
                                    @{{ friend.username }}
                                </div>

                                <div class="pull-right">
                                    <button class="btn btn-danger btn-xs" style="font-size: 16px; margin-right: 10px;"
                                        @click="deleteFriend(friend)">

                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Friend Form -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Add Friend</div>

                        <div class="panel-body">
                            <form-errors :form="addFriendForm"></form-errors>

                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="username" v-model="addFriendForm.username">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary"
                                            @click.prevent="addFriend"
                                            :disabled="addFriendForm.adding">

                                            <span v-if="addFriendForm.adding">
                                                <i class="fa fa-btn fa-spinner fa-spin"></i>Adding
                                            </span>

                                            <span v-else>
                                                <i class="fa fa-btn fa-plus"></i>Add Friend
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    `
});

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
        };
    },

    ready: function () {
    },

    methods: {
    }
});

if ($("#confomo-app").length) {
    new Vue({ el: '#confomo-app' });
}
