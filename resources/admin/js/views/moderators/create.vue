<template>
    <moderator-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Пользователь добавлен'"
        @close="closeModal"
       ></moderator-form>
</template>
<script>
import ModeratorForm from './components/form'
export default {
    components: {
        ModeratorForm,
    },
    data() {
        return {
            formAction: {
                url: '/api/admin/user/store',
                method: 'post',
            },
            form: {
                email:"",
                name:"",
                password:"",
                r_code: 0,
                active: false,
                password_confirmation:"",
                role:'',
                id:null,
            }
        }
    },
    methods: {
        closeModal(data) {
            this.$emit('close', data)
        },
    },
}
</script>
