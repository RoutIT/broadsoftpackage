<template>   
    <table>
        <tr v-for="msg in messages">
            <td>{{ msg }}</td>
        </tr>
    </table>
</template>



<script>
export default {
    data() {
        return {
            messages: [],
        }
    },
    methods:{
        listen(){
            console.log('pusher client ready to receive messages!');
            this.channel.listen('CallCenterAgentEvent', (e) => {
                console.log(e);
            });
        }
    },
    mounted(){
        Echo.channel('AgentState')
                .listen('.CallCenterAgentEvent', (e) => {
                    this.messages.push(e.message);
                });
    }
}
</script>