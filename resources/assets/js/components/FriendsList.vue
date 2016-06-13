<template>
    <!-- Friend Listing -->
    <h2>{{ descriptor }} Friends</h2>
    <div v-show="list.length > 0">
        <div class="row Friends">
            <div class="col-xs-12 col-sm-6 col-md-4" v-for="friend in list">
                <div class="Friend clearfix">
                    <div class="Friend__Avatar">
                        <img v-bind:src="friend.avatar_url" class="img-circle" width="60" />
                    </div>
                    <div class="Friend__Body">
                        <h4>@{{ friend.username }}</h4>

                        <div class="Friend__Actions">
                            <button class="btn btn-danger btn-inverse btn-xs" @click="deleteFriend(friend)">Delete</button>

                            <button v-if="key == 'online-friends'"
                                    @click="metFriend(friend)"
                                    :class="['btn', 'btn-inverse', 'btn-xs', friend.met ? 'btn-success' : 'btn-primary']"
                            >
                                <span v-if="friend.met">You've met!</span>
                                <span v-else>Mark as met</span>
                            </button>
                        </div>
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
                                <div class="input-group">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" name="username" v-model="addFriendForm.username">
                                </div>
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
</template>

<script>
    export default {
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
                    .then(friends => { this.list = friends.data; });
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
                    .then(friend => {
                        this.addFriendForm.username = '';
                        this.addFriendForm.adding = false;
                        this.list.push(friend.data);
                    }, errors => {
                        setErrorsOnForm(this.addFriendForm, errors);
                        this.addFriendForm.adding = false;
                    });
            },

            deleteFriend: function (friend) {
                var vm = this;

                swal({
                    title: 'Are you sure?',
                    text: 'This will delete @' + friend.username + ' from your list of friends',
                    type: 'warning',
                    showCancelButton: true
                }, () => {
                    vm.$http.delete('/api/conferences/' + vm.conferenceId + '/' + vm.key + '/' + friend.id)
                        .then(() => { vm.list.$remove(friend) });
                });
            },

            metFriend: function (friend) {
                this.$http.patch('/api/conferences/' + this.conferenceId + '/' + this.key + '/' + friend.id, { met: ! friend.met })
                    .then(() => { friend.met = ! friend.met; });
            },
        }
    }
</script>
