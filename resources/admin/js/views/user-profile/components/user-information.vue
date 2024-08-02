<template>
<section>

    <el-form :model="form" label-position="top">
        <div class="row">
            <el-form-item class="col-md-6" label="Имя" :error="errors.get('name')">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item class="col-md-6" label="E-mail" :error="errors.get('email')">
                <el-input v-model="form.email"></el-input>
            </el-form-item>
        </div>

        <el-button type="success" @click="onSubmit">Сохранить</el-button>
        <el-button icon="el-icon-unlock" type="primary" @click="showPasswordModal = true">Сменить пароль</el-button>
    </el-form>
    <el-dialog
        :visible.sync="showPasswordModal"
        title="Сменить пароль"
    >
        <el-form :model="passwordForm" label-position="top">
            <div class="row">
                <el-form-item class="col-md-6" label="Новый пароль" :error="errors.get('password')">
                    <el-input v-model="passwordForm.password" show-password></el-input>
                </el-form-item>
                <el-form-item class="col-md-6" label="Подтверждение пароля">
                    <el-input v-model="passwordForm.password_confirmation" show-password></el-input>
                </el-form-item>
            </div>
        </el-form>
        <span slot="footer" class="dialog-footer">
            <el-button @click="showPasswordModal = false">Отмена</el-button>
            <el-button type="success" @click="changePassword">Сохранить</el-button>
          </span>
    </el-dialog>
</section>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
import {mapGetters} from "vuex";
export default {

    data() {
        return {
            showPasswordModal:false,
            passwordForm: {
                password: '',
                password_confirmation: ''
            },
            form: {
                name: "",
                email: "",
                telegram: "",
                company_name: "",
                phone: "",
            },
            errors: new Errors(),
        }
    },
    computed: {
        ...mapGetters([
            'userId',
        ]),
    },
    methods: {
        changePassword() {
            axios.post('/api/admin/user/' + this.userId + '/change-password', this.passwordForm)
                .then((response) => {
                    this.$message({
                        message: response.data,
                        type: 'success'
                    });
                    this.showPasswordModal = false;
                    this.passwordForm.password = '';
                    this.passwordForm.password_confirmation= '';
                })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
        },
        onSubmit() {
            axios.post('/api/admin/user/' + this.userId + '/update', this.form)
                .then((response) => {
                    this.$store.commit('user/SET_NAME', response.data.name);
                    this.$message({
                        message: 'Ваши данные изменены',
                        type: 'success'
                    });
                })
                .catch((error) => {
                    this.errors.record(error.response.data.errors);
                })
        },
        getUser() {
            axios.get('/api/admin/user/' + this.userId + '/show')
                .then((response) => {
                    this.form = response.data;
                })
        },
    },
    mounted() {
        this.getUser();
    }
}
</script>
