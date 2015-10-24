@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <script>
            Confomo.conferenceId = {{ $conference->id }};
        </script>
        <conference inline-template>
            <a href="/dashboard">&lt;- Back to dashboard</a>

            <!-- New Friend Listing -->
            <h2>New Friends</h2>
            <div v-if="newFriends.length > 0">
                <div class="row" v-for="friend in newFriends">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default"
                            style="cursor: pointer">
                            <div class="panel-heading">
                                <div class="pull-left" style="padding-top: 6px;">
                                    @@{{ friend.username }}
                                </div>

                                <div class="pull-right">
                                    <button class="btn btn-danger" style="font-size: 18px; margin-right: 10px;"
                                        @click="deleteNewFriend(friend)">

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
                        <div class="panel-heading">Add New Friend</div>

                        <div class="panel-body">
                            <form-errors :form="addNewFriendForm"></form-errors>

                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="username" v-model="addNewFriendForm.username">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary"
                                            @click.prevent="addNewFriend"
                                            :disabled="addNewFriendForm.adding">

                                            <span v-if="addNewFriendForm.adding">
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
        </dashboard>
    </div>
@endsection
