<template>
    <section class="page">
        <div class="page-heading d-flex align-items-center justify-content-between mb-3" style="gap:20px;">
            <el-button type="primary" icon="el-icon-plus" @click="modalOpen('create')">Добавить  категорию</el-button>
        </div>
        <data-tables style="width: 100%" :data="categories">
            <el-table-column

                fixed
                label="Название"
                prop="title"
                sortable
                min-width="155px"
            >
            </el-table-column>
            <el-table-column
                label="Действия"
            >
                <template slot-scope="scope">

                    <el-tooltip class="item" effect="dark"
                                content="Просмотр категории"
                                placement="bottom">
                        <router-link style="margin-left: 10px; margin-right: 10px" :to="'/catalog/'+ scope.row.id">
                            <el-button
                                style="min-width: 28px"

                                type="info" icon="el-icon-view" circle></el-button>
                        </router-link>
                    </el-tooltip>
                    <el-tooltip class="item" effect="dark"
                                content="Редактировать категорию"
                                placement="bottom">
                    <el-button
                        style="min-width: 28px"
                        @click.prevent="handleEdit(scope.row.id)"
                        type="primary" icon="el-icon-edit" circle></el-button>
                    </el-tooltip>
                    <el-tooltip class="item" effect="dark"
                                content="Удалить категорию"
                                placement="bottom">
                        <el-button
                            style="min-width: 28px"
                            @click.prevent="handleDelete(scope.row.id)"
                            type="danger" icon="el-icon-delete" circle></el-button>
                    </el-tooltip>
                </template>
            </el-table-column>
        </data-tables>
        <el-dialog
            :visible.sync="modalVisible"
            width="70%"
            :title="modalTitle"
        >
            <create
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'create'"></create>
            <edit
                :id="id"
                @close="closeModal"
                v-if="modalVisible && modalStatus === 'edit'"></edit>
        </el-dialog>
    </section>

</template>
<script>
import edit from "./edit.vue";
import create from "./create.vue";
    export default {
        components: {create, edit},
        computed: {
            modalTitle:function () {
                if(this.modalStatus === 'create') {
                    return 'Новая категория';
                }
                if(this.modalStatus === 'edit') {
                    return 'Редактировать Категорию';
                }
            },
        },
        data() {
     return {
         modalStatus: '',
         modalVisible:false,
         categories: [],
            }
        },
        methods: {
            modalOpen(status) {
                this.modalStatus = status;
                this.modalVisible= true;

            },
            closeModal(data) {
                this.modalVisible= false;
                this.id = null;
                this.getCapabilities();
            },
            getCapabilities() {
                axios.get('/api/admin/category')
                    .then((response) => {
                        this.categories = response.data;
                    })
            },
            handleEdit(id) {
                this.id = id;
                this.modalStatus = 'edit';
                this.modalVisible = true;
            },
            handleDelete(id) {
                this.$confirm('Вы уверены что хотите удалить  категорию товаров', 'Удаление категории', {
                    confirmButtonText: 'Удалить',
                    cancelButtonText: 'Отмена',
                    type: 'warning'
                }).then(() => {
                    axios.delete('/api/admin/category/' + id)
                        .then((response) => {
                            let index = this.categories.findIndex(item => item.id === response.data.id);
                            this.categories.splice(index, 1);
                            this.$message({
                                type: 'success',
                                message: 'Проект удален'
                            });
                        });

                }).catch(() => {

                });
            },
        },
        mounted() {
            this.getCapabilities();
        }
    }
</script>
