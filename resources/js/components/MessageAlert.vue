<template>

	<a class="nav-link " :href="(newmessages.length > 0) ?'/chat/'+newmessages :'/messages'" role="button">
        Messages 
		<span class="notification-alert" v-if="newmessages.length > 0">
	      {{newmessages.length}}
	    </span>
    </a>
	
</template>

<script>
    export default {
    	props: ['newmessages'],
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>