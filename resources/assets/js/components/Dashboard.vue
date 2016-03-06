<template>
    <div class="dashboard">
        <!-- Conference Listing -->
        <h2>Conferences</h2>
        <div v-if="conferences.length > 0">
            <div class="row" v-for="conference in conferences">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default"
                        @click="viewConference(conference)"
                        style="cursor: pointer">
                        <div class="panel-heading conference-button">
                            <div class="pull-left" style="padding-top: 6px;">
                                {{ conference.name }}
                            </div>

                            <div class="pull-right">
                                <button class="btn btn-danger" style="font-size: 18px; margin-right: 10px;"
                                    @click="deleteConference(conference)">

                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Conference Form -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Add Conference</div>

                    <div class="panel-body">
                        <form-errors :form="addConferenceForm"></form-errors>

                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" v-model="addConferenceForm.name">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary"
                                        @click.prevent="addConference"
                                        :disabled="addConferenceForm.adding">

                                        <span v-if="addConferenceForm.adding">
                                            <i class="fa fa-btn fa-spinner fa-spin"></i>Adding
                                        </span>

                                        <span v-else>
                                            <i class="fa fa-btn fa-plus"></i>Add Conference
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
                        this.conferences.push(conference);
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
    }
</script>
