<template>

            <el-form :model="form" ref="form" label-position="top">

                <div class="d-flex">
                    <el-form-item prop="logo" label="Превью" style="margin-right: 20px">
                        <el-upload
                            action=""
                            v-model="form.preview"
                            class="avatar-uploader"
                            :auto-upload="false"
                            :show-file-list="false"
                            :on-change="uploadImage"
                        >
                            <figure class="avatar" v-if="form.preview">
                                <img  :src="form.preview" >
                            </figure>
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                    <div style="flex:1">
                        <el-form-item prop="title" label="Название" :error="errors.get('title')">
                            <el-input v-model="form.title"/>
                        </el-form-item>
                        <el-form-item prop="price" label="Стоимость" :error="errors.get('price')">
                            <el-input v-model="form.price"/>
                        </el-form-item>
                        <el-form-item prop="description" label="Описание" :error="errors.get('description')">
                            <el-input type="textarea" v-model="form.description"/>
                        </el-form-item>
                        <el-form-item prop="r_id" label="ID для связи" :error="errors.get('r_id')">
                            <el-input v-model="form.r_id"/>
                        </el-form-item>



                        <div class="text-center">
                            <el-button type="success" @click.prevent="save">Сохранить</el-button>
                            <el-button  @click.prevent="closeModal">Отменить</el-button>
                        </div>
                    </div>
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

        uploadImage(file){
            let cond = this.beforeImageUpload(file.raw);
            this.form.imageName = file.raw.name;
            console.log(cond);
            if(cond){
                this.createImage(file);
            }
        },

        beforeImageUpload(file) {
            const isJPG = file.type === 'image/jpeg';
            const isPNG = file.type === 'image/png';
            const isLt2M = file.size / 1024 / 1024 < 2;

            if (!isJPG && !isPNG) {
                this.$message.error('Картинка должна быть в формате jpeg или png');
            }
            if (!isLt2M) {
                this.$message.error('Размер не может превышать 2МБ');
            }
            return (isJPG || isPNG) && isLt2M;
        },

        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.form.preview = e.target.result;
            };
            reader.readAsDataURL(file.raw);
        },
    },
    mounted() {

    }
}
</script>
