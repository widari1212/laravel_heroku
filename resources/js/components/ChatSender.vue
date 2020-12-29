<template lang="html">
	<div class="chat-message clearfix">
        <textarea name="message-to-send" id="message-to-send" placeholder ="Type your message" rows="3" v-on:keyup.enter="sendMsg" v-model="chat"></textarea>
                
        <i class="fa fa-file-o"></i> &nbsp;&nbsp;&nbsp;
        <i class="fa fa-file-image-o"></i>
        
        <button id="sendMsg" v-on:click="sendMsg">Send</button>

      </div> <!-- end chat-message -->
</template>
<script>
    export default {
        props: ['messages', 'authors', 'userid','chatid'],
        data() {
        	return {
        		'chat' : ''
        	}
        },
        methods: {
        	sendMsg: function(e) {

        		// alert(chat.data)
        		if (this.chat != '') {
        			var data = {
        				message: this.chat,
        				author: $('meta[name="userId"]').attr('content'),
        				chat_id: this.chatid
        			}
        			this.chat = '';

        			axios.post('/message/sendMsg', data).then( (response)=> {
        				this.messages.push(data);
        			});
        		}
        	}
        }
    }
</script>