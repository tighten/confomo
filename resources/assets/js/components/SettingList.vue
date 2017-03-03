<template>
	<!-- Settings Listing -->
	<div class="panel, panel-primary">
		<div class="panel-heading">User Settings</div>

		<div class="panel-body">
			<form-errors :form="userSettingsForm"></form-errors>

			<form class="form-horizontal">
				<div class="form-group">
					<label class="col-md-3 control-label">Do you want to be searchable?</label>
					<div class="input-group">
						<div class="col-md-1">
							<input type="radio" id="userIsSearchableYes" value="1" v-model="userSettingsForm.userIsSearchable">
							<label for="userIsSearchableYes">Yes</label>
						</div>
						<div class="col-md-1 col-md-offset-1">
							<input type="radio" id="userIsSearchableNo" value="0" v-model="userSettingsForm.userIsSearchable">
							<label for="userIsSearchableNo">No</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Do you want your conference list to be public?</label>
					<div class="input-group">
						<div class="col-md-1">
							<input type="radio" id="conferenceListIsPublicYes" value="1" v-model="userSettingsForm.conferenceListIsPublic">
							<label for="conferenceListIsPublicYes">Yes</label>
						</div>
						<div class="col-md-1 col-md-offset-1">
							<input type="radio" id="conferenceListIsPublicNo" value="0" v-model="userSettingsForm.conferenceListIsPublic">
							<label for="conferenceListIsPublicNo">No</label>
						</div>
				</div>
				<div class="form-group">
					<div class="col-md-6 col-md-offset-3">
						<button type="submit" class="btn btn-primary"
						        @click.prevent="submitSettings"
						        :disabled="userSettingsForm.submitting">

                                    <span v-if="userSettingsForm.submitting">
                                        <i class="fa fa-btn fa-spinner fa-spin"></i>Submitting
                                    </span>

							<span v-else>
                                        <i class="fa fa-btn fa-plus"></i>Submit Changes
                                    </span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
    export default {

        data: function () {
            return {
                userSettingsForm: {
                    errors: [],
                    submitting: false,
                    userIsSearchable: false,
                    conferenceListIsPublic: false,
                },
            };
        },

        ready: function() {
            this.getUserSettings();
        },

        methods: {
            getUserSettings: function () {
                this.$http.get('/api/settings')
                    .then(settings => {
                        console.log(settings);
                        this.userSettingsForm.userIsSearchable = settings.data.userIsSearchable;
                        this.userSettingsForm.conferenceListIsPublic = settings.data.conferenceListIsPublic;
                    });
            },

            submitSettings: function () {
                // @todo: Do validation in a more VueJS-y way?

                this.userSettingsForm.errors = [];
                this.userSettingsForm.submitting = true;

                this.$http.post('/api/settings', this.userSettingsForm)
                    .then(settings => {
                        this.userSettingsForm.submitting = false;
                    }, response => {
                        this.setErrorsOnForm(this.userSettingsForm, response.data);
                        this.userSettingsForm.submitting = false;
                    });
            },
        }
    }
</script>
