<template>
    <section>
        <project-form
            :save-msg="'Проект обновлен'"
            v-if="loaded"
            :form="form"
            :formAction="formAction"
            @close="closeModal"
        ></project-form>
    </section>

</template>
<script>
import ProjectForm from "./components/form";
export default {
    components:{
        ProjectForm
    },
    props:['id'],
    data() {
        return {
            loaded:false,
            form: {

            },
            formAction: {
                url: '/api/admin/category/' + this.id,
                method: 'put',
            },
        }
    },
    methods:{
        closeModal(data) {
            this.$emit('close',data)
        },
        getFormData() {
            console.log('test')
            this.$root.isLoading = true;
            return axios.get('/api/admin/category/' + this.id)
                .then((response) => {
                    this.form = response.data;
                    this.loaded = true;
                    this.$root.isLoading = false;

                })
        }
    },
    async mounted() {
        await this.getFormData();
    }
}
</script>
