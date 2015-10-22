@extends('layouts.app')

@section('content')
    <div id="confomo-app" class="container" v-cloak>
        <!-- Conference Listing -->
        <h2>Conferences</h2>
        <div v-if="conferences.length > 0">
            <div class="row" v-for="conference in conferences">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="pull-left" style="padding-top: 6px;">
                                @{{ conference.name }}
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
@endsection
