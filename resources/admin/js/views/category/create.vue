<template>
    <group-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Категория добавлена'"
        @close="closeModal"
    ></group-form>

</template>
<script>
import GroupForm from './components/form'

export default {
    components: {
        GroupForm,
    },
    computed: {

    },
    data() {
        return {
            formAction: {
                url: '/api/admin/category',
                method: 'post',
            },
            form: {
                name:"",
                targeturl:"",
                group_id:null,
                percentage_of_repeat_visits:0,
                parameters: "",
                active:false,
            }
        }
    },
    methods: {
        closeModal(data) {
            this.$emit('close', data)
        },

    },
    mounted() {

    }
}
</script>
