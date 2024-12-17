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
                url: '/api/admin/products',
                method: 'post',
            },
            form: {
                title:"",
                price:"",
                preview:"",
                descritpion: "",
                r_id:"",
                divider:0,
                category_id: 0,
            }
        }
    },
    methods: {
        closeModal(data) {
            this.$emit('close', data)
        },

    },
    mounted() {
        this.form.category_id = this.$route.params.categoryId;
    }
}
</script>
