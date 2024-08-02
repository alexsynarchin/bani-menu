<template>
    <group-form
        :form="form"
        :formAction="formAction"
        :closeMsg="'Категория создана'"
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
                title:"",
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
