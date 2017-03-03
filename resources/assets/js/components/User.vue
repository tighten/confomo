<template>
	<div class="user">
		<conferences-list :future-list="futureList" :past-list="pastList" :twitter-nickname="twitterNickname"></conferences-list>
	</div>
</template>

<script>
	import ConferencesList from './ConferencesList.vue';

    export default {
        data: function() {
            return {
                currentUserId: Confomo.userId,
                twitterNickname: Confomo.twitter_nickname,

                futureList: [],
                pastList: [],
            };
        },

        components: { ConferencesList }
    }
</script>
