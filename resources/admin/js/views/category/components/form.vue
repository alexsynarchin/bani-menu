<template>

            <el-form :model="form" ref="form" label-position="top">
                <el-form-item prop="title" label="Название Категории" :error="errors.get('name')">
                    <el-input v-model="form.title" placeholder="Название Категории"></el-input>
                </el-form-item>

                <div class="text-center">
                    <el-button type="success" @click.prevent="save">Сохранить</el-button>
                    <el-button  @click.prevent="closeModal">Отменить</el-button>
                </div>
            </el-form>

</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import { mapGetters } from 'vuex';

import {copyProjectApiUrlMixin} from "@/admin/js/mixins/copyProjectApiUrlMixin";
export default {
    props:{
        saveMsg: {
            default: 'Проект добавлен'
        },
        form: {
            type:Object
        },
        formAction: {
            type:Object
        }
    },
    mixins: [copyProjectApiUrlMixin],
    computed: {

        ...mapGetters([
            'userId',
        ]),
    },
    data() {
        return {
            groups:[],
            errors: new Errors(),
        }
    },
    methods: {

        closeModal(data) {
            this.$emit('close', data);
        },
        save() {
            axios({
                method: this.formAction.method ,
                url: this.formAction.url,
                data: this.form
            }).then((response) => {
                this.$message({
                    message: this.saveMsg,
                    type: 'success'
                });
                this.closeModal();
            })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                });

        },

    },
    mounted() {

    }
}
</script>
