<template>
	<!-- Conferences Listing -->
	<h2><a href="http://twitter.com/{{ twitterNickname }}">@{{ twitterNickname }}</a>'s Conferences</h2>
	<div v-show="futureList.length == 0">
		<p style="font-size: 1.5em; text-align: center;">This user doesn't have any upcoming conferences!</p><br>
	</div>
	<div v-show="futureList.length > 0">
		<h4>Future</h4>
		<div class="row conferences">
			<div class="col-xs-12 col-sm-6 col-md-4" v-for="conference in futureList">
				<div class="conference clearfix">
					<div class="conference__body">
						<h3>{{ conference.name }}</h3>
						<div class="conference__actions">
							<span class="label label-success">Starts {{ formatDate(conference.start_date) }}</span>
							<span>
								<button class="btn btn-info btn-inverse btn-xs" onclick="location.href='/conferences/{{ conference.slug }}/introduce'">Introduce Yourself!</button>
							<span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div v-show="pastList.length > 0">
		<h4>Past</h4>
		<div class="row conferences">
			<div class="col-xs-12 col-sm-6 col-md-4" v-for="conference in pastList">
				<div class="conference clearfix">
					<div class="conference__body">
						<h3>{{ conference.name }}</h3>
						<div class="conference__actions">
							<span class="label label-warning">Started {{ formatDate(conference.start_date) }}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        props: ['future-list', 'past-list', 'twitter-nickname'],

        ready: function() {
            this.getUserConferences();
        },

        methods: {
            getUserConferences: function () {
                this.$http.get('/api/users/' + this.twitterNickname + '/conferences')
                    .then(conferences => {
                        if ('future' in conferences.data) {
                            this.futureList = conferences.data.future;
                        }
                        if ('past' in conferences.data) {
                            this.pastList = conferences.data.past;
                        }
                    }, response => {

                    });
            },

            formatDate: function (date) {
                date = new Date(date);
                return date.toLocaleDateString();
            }
        }
    }
</script>
