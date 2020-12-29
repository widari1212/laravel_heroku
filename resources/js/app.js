
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 
Vue.component('chat', require('./components/Chat.vue'));
Vue.component('chat-sender', require('./components/ChatSender.vue'));
Vue.component('msgalert', require('./components/MessageAlert.vue'));
Vue.component('onlinestatus', require('./components/OnlineStatus.vue'));


const app = new Vue({
    el: '#app',
    props: [
        'messages',
        'newMessages',
        'authors',
        'chatfriendson',
        'chat',
        'chatid',
        'onlineUsers'
    ],
    created() {

        const userId = $('meta[name="userId"]').attr('content');

        axios.post('/unsen_messages').then( (response)=>{
            this.newMessages = response.data;
        });

        if ($('meta[name="chatId"]').length) {
            this.chatid = $('meta[name="chatId"]').attr('content');

            axios.post('/chat/'+this.chatid).then( (response)=>{
                this.messages = response.data[0];
                this.authors = response.data[1];
                this.chatfriendson = response.data[2];
                this.chat = response.data[3];
            });

            Echo.private('Chat.'+userId)
                .listen('BroadcastChatEvent', (e) =>{
                    if (this.chat.id == e.message.chat_id)
                        axios.post('/msgSeen/'+e.message.id).then( (response)=>{
                            this.messages.push(e.message);
                        }); 
                            
                    else
                        this.newMessages.push(e.message.chat_id);
                });
        }
        else{
            Echo.private('Chat.'+userId)
                .listen('BroadcastChatEvent', (e) =>{
                    this.newMessages.push(e.message.chat_id);
                });
        }            

        Echo.join('Online')
            .here((users) =>{
                this.onlineUsers = users;
            })
            .joining( (user) => {
                this.onlineUsers.push(user);
            })
            .leaving( (user) => {
                this.onlineUsers = this.onlineUsers.filter( (u)=>{ u != user });
            });

    },

});


