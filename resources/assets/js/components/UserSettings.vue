<template>
	<div class="user-settings">
		<setting-list></setting-list>
	</div>
</template>

<script>
	import SettingList from './SettingList.vue';

    export default {
        data: function() {
            return {
                currentUserId: Confomo.userId,
                twitterNickname: Confomo.twitter_nickname,

            };
        },

        components: { SettingList }
    }
</script>
