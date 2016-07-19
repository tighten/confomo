<template>
    <!-- Friend Listing -->
    <h2>{{ descriptor }} Friends</h2>
    <p v-show="descriptor == 'New'" style="text-align: center; font-style: italic; color: rgba(0, 0, 0, 0.5)">
        (New friends are people you met at this conference.)
    </p>
    <p v-show="descriptor == 'Online'" style="text-align: center; font-style: italic; color: rgba(0, 0, 0, 0.5)">
        (Online friends are people you know online prior to the conference and want to meet at the conference.)
    </p>
    <div v-show="list.length == 0">
        <p style="font-size: 1.5em;">You don't have any {{ descriptor }} Friends added yet.</p><br>
    </div>
    <div v-show="list.length > 0">
        <div class="row friends">
            <div class="col-xs-12 col-sm-6 col-md-4" v-for="friend in list">
                <div class="friend clearfix">
                    <div class="friend__avatar">
                        <img v-bind:src="friend.avatar_url" class="img-circle" height="60" />
                    </div>
                    <div class="friend__body">
                        <h4>@{{ friend.username }}</h4>

                        <div class="friend__actions">
                            <button class="btn btn-danger btn-inverse btn-xs" @click="deleteFriend(friend)">Delete</button>

                            <span v-if="key == 'online-friends'">
                                <button v-if="friend.met" @click="markFriendNotMet(friend)" class="btn btn-inverse btn-xs btn-success" >You've met!</button>
                                <button v-else @click="markFriendMet(friend)" class="btn btn-inverse btn-xs btn-primary">Mark as met</button>
                            </span>

                            <span v-if="friend.introduction" class="label label-warning">Introduced</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Friend Form -->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div v-bind:class="['panel', list.length > 0 ? 'panel-default' : 'panel-primary']">
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
                    }, response => {
                        this.setErrorsOnForm(this.addFriendForm, response.data);
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

            markFriendMet: function (friend) {
                this.toggleFriendMet(friend, true);
            },

            markFriendNotMet: function (friend) {
                this.toggleFriendMet(friend, false);
            },

            toggleFriendMet: function (friend, met) {
                this.$http.patch('/api/conferences/' + this.conferenceId + '/' + this.key + '/' + friend.id, { met: met })
                    .then(() => { friend.met = met; });
            },
        }
    }
</script>
