<template>
    <div class="dashboard">
        <!-- Conference Listing -->
        <h2>Conferences</h2>
        <div v-if="conferences.length > 0">
            <div class="row" v-for="conference in conferences">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading conference-button">
                            <h3 class="panel-title pull-left" style="cursor: pointer; padding-top: 6px;" @click="viewConference(conference)">{{ conference.name }}</h3>

                            <div class="pull-right">
                                <button class="btn btn-danger"
                                        style="font-size: 18px; margin-right: 10px;"
                                        @click.prevent="deleteConference(conference)"
                                >
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
                                <label class="col-md-3 control-label">Start Date</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="start_date" v-model="addConferenceForm.start_date">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">End Date</label>

                                <div class="col-md-6">
                                    <input type="date" class="form-control" name="end_date" v-model="addConferenceForm.end_date">
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
                conferences: [],

                addConferenceForm: {
                    name: '',
                    start_date: '',
                    end_date: '',
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
                if (! this.validInput()) {
                    this.addConferenceForm.adding = false;

                    return;
                }


                this.addConferenceForm.errors = [];
                this.addConferenceForm.adding = true;

                this.$http.post('/api/conferences', this.addConferenceForm)
                    .success(function (conference) {
                        this.addConferenceForm.name = '';
                        this.addConferenceForm.start_date = '';
                        this.addConferenceForm.end_date = '';
                        this.addConferenceForm.adding = false;
                        this.conferences.push(conference);
                    })
                    .error(function (errors) {
                        setErrorsOnForm(this.addConferenceForm, errors);
                        this.addConferenceForm.adding = false;
                    });
            },

            deleteConference: function (conference, $e) {
                var vm = this;

                swal({
                    title: 'Are you sure?',
                    text: 'This will delete ' + conference.name + ' and any associated friends',
                    type: 'warning',
                    showCancelButton: true
                }, function () {
                    vm.$http.delete('/api/conferences/' + conference.id)
                        .then(function () {
                            vm.conferences.$remove(conference);
                        });
                });
            },

            viewConference: function (conference) {
                document.location.href = '/conferences/' + conference.id;
            },

            validInput: function () {
                this.addConferenceForm.errors = [];
                
                if (this.addConferenceForm.name == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the name.');
                }

                if (this.addConferenceForm.start_date == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the start date.');
                }

                if (this.addConferenceForm.end_date == '') {
                    this.addConferenceForm.errors.push('You need to actually type something for the end date.');
                }

                if (this.addConferenceForm.errors.length > 0) {
                    this.addConferenceForm.adding = false;

                    return;
                }

                return true;
            },
        }
    }
</script>
