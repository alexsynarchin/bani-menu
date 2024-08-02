<template>
    <section class="page">
        <div class="page-heading d-flex align-items-center justify-content-between mb-3" style="gap:20px;">
            <el-button type="primary" icon="el-icon-plus" @click="modalOpen('create')">Добавить  товар</el-button>
        </div>

        <data-tables style="width: 100%" :data="products">
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
                                content="Редактировать товар"
                                placement="bottom">
                        <el-button
                            style="min-width: 28px"
                            @click.prevent="handleEdit(scope.row.id)"
                            type="primary" icon="el-icon-edit" circle></el-button>
                    </el-tooltip>
                    <el-tooltip class="item" effect="dark"
                                content="Удалить товар"
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
    props:['categoryId'],
    computed: {
        modalTitle: function () {
            if (this.modalStatus === 'create') {
                return 'Новый товар';
            }
            if (this.modalStatus === 'edit') {
                return 'Редактировать товар';
            }
        },
    },
    data() {
        return {
            modalStatus: '',
            modalVisible: false,
            products: [],
        }
    },
    methods: {
        modalOpen(status) {
            this.modalStatus = status;
            this.modalVisible = true;

        },
        closeModal(data) {
            this.modalVisible = false;
            this.id = null;
            this.getCapabilities();
        },
        getProducts() {
            axios.get('/api/admin/products', {params: {category_id: this.categoryId}})
                .then((response) => {
                    this.products = response.data;
                })
        },
        handleEdit(id) {
            this.id = id;
            this.modalStatus = 'edit';
            this.modalVisible = true;
        },
        handleDelete(id) {
            this.$confirm('Вы уверены что хотите удалить  товар', 'Удаление товара', {
                confirmButtonText: 'Удалить',
                cancelButtonText: 'Отмена',
                type: 'warning'
            }).then(() => {
                axios.delete('/api/admin/products/' + id)
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
        this.getProducts();
    }
}
</script>
