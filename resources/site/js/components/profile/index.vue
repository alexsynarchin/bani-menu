<template>
    <div class="" style="margin-bottom: 10px; ">
        <div v-if="user.name"><a href="/admin" >{{user.name}}</a></div>
        <a v-else href="/admin/login" style="font-size: 18px">Авторизация</a>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                user: {}
            }
        },
        methods: {
            getUser() {
                axios.get('/api/user')
                    .then((response) => {
                        if(response.data) {
                            this.user = response.data;
                        }
                    })
            }
        },
        mounted() {
            this.getUser();
        }
    }
</script>
