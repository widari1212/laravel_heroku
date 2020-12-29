<template>
	
	<span v-if="CheckUserOnline()">
    	<i class="fa fa-circle online"></i> online
    </span>
    <span v-else>
    	<i class="fa fa-circle offline"></i> offline
    </span>
		
</template>

<script>
    export default {
        props: ['onlineusers', 'userid'],
        methods: {
          CheckUserOnline: function(){
            return _.find(this.onlineusers, {id: this.userid})
          }
          
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>