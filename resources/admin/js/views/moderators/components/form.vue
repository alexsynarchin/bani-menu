<template>
    <el-tabs type="card" >
        <el-tab-pane label="Основная информация">
            <el-form :model="form" ref="form" label-position="top">
                <el-row type="flex" :gutter="10">
                    <el-col :span="12">
                        <el-form-item prop="email" label="E-mail" :error="errors.get('email')">
                            <el-input v-model="form.email" placeholder="Электронная почта"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item prop="name" label="Имя"  :error="errors.get('name')">
                            <el-input v-model="form.name" placeholder="Имя"></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="10" type="flex">

                    <el-col :span="12">
                        <el-form-item prop="role" label="Роль" :error="errors.get('role')">
                            <el-select v-model="form.role" placeholder="Выберите роль" style="width: 100%">
                                <el-option
                                    v-for="item in roles"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                   >
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                    <el-form-item prop="r_code" label="Связь с RKeeper" :error="errors.get('r_code')">
                        <el-select v-model="form.r_code" filterable placeholder="Выберите пользователя" style="width: 100%">
                            <el-option
                                v-for="item in employees"
                                :key="item.r_code"
                                :label="item.name"
                                :value="item.r_code"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                </el-row>
                <el-row type="flex" :gutter="10"  v-if="formAction.url === '/api/admin/user/store'">
                    <el-col :span="12">
                        <el-form-item prop="password" label="Пароль" :error="errors.get('password')">
                            <el-input v-model="form.password" placeholder="Введите пароль"
                                      show-password></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :span="12">
                        <el-form-item prop="password_confirmation" label="Подтверждение пароля">
                            <el-input v-model="form.password_confirmation" placeholder="Повторите пароль"
                                      show-password></el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-form-item prop="active" label="Активировать">
                    <el-switch v-model="form.active">
                    </el-switch>
                </el-form-item>
                <div class="text-center">
                    <el-button type="success" @click.prevent="save">Сохранить</el-button>
                    <el-button  @click.prevent="closeModal">Отменить</el-button>
                </div>
            </el-form>
        </el-tab-pane>
    </el-tabs>
</template>
<script>
import { Errors } from  '@/common/js/services/errors.js';
export default {
    props:{
        saveMsg: {
            default: 'Модератор добавлен'
        },
        form: {
            type:Object
        },
        formAction: {
            type:Object
        }
    },
    data() {
        return {
            employees: [],
            roles: [
                {
                    label: 'Официант',
                    value: 'manager'
                },
                {
                    label: 'Администратор',
                    value: 'admin'
                }
            ],
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
                })
            ;

        },
        getEmployees() {
            axios.get('/api/admin/user/employees')
                .then((response) => {
                    this.employees = response.data
                })
        }
    },
    mounted() {
        this.getEmployees();
    }
}
</script>
