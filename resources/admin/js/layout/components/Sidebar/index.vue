<template>
    <aside class="main-sidebar"  ref="SidebarMenu" id="main_sidebar">

            <el-menu
                :router="true"
                class="sidebar-nav"

            >
                <perfect-scrollbar :style="{height: height + 'px'}">

                    <el-menu-item index="/profile" >
                        <i class="el-icon-user"></i>
                        <span class="sidebar-nav__link-text">Аккаунт</span>
                    </el-menu-item>
                    <el-menu-item index="/catalog" >
                        <i class="el-icon-folder-checked"></i>
                        <span class="sidebar-nav__link-text">Каталог</span>
                    </el-menu-item>
                    <el-menu-item index="/users" v-if="checkPermission(['manage_moderators'])">
                        <i class="el-icon-s-custom"></i>
                        <span class="sidebar-nav__link-text">Пользователи</span>
                    </el-menu-item>

                </perfect-scrollbar>
            </el-menu>
        <input type="hidden" id="update_statistic_url" :value="updateStatisticUrl">
    </aside>
</template>
<script>

import checkPermission from '@/admin/js/utils/permission';
import { PerfectScrollbar } from 'vue2-perfect-scrollbar'
export default {
    components: { PerfectScrollbar },
    mounted(){
        const resize_ob = new ResizeObserver(() => {
            this.matchHeight();
        });
        resize_ob.observe(document.querySelector('#main_sidebar'));

    },
    computed:{

    },

    methods: {
        checkPermission,
        copyUpdateStatisticUrl() {
            const url = window.location.protocol + '//' + window.location.host + '/api/update-task/?tid=[[TID]]&taskid=[[TASKID]]&date=[[FORMATTED_DATE]]&tasktype=[[TASKTYPE]]&targetdomain=[[TARGETDOMAIN]]&targeturl=[[TARGETURL]]&keyword=[[KEYWORD]]&position=[[POSITION]]&getparameters=[[GETPARAMETERS]]&projectname=[[PROJECTNAME]]&pid=[[PID]]&device=[[DEVICE]]&cookies=[[COOKIES]]&uniquedomains=[[UNIQUEDOMAINS]]&ymdomains=[[YMDOMAINS]]&gadomains=[[GADOMAINS]]&proxy=[[PROXY]]';
            let updateStatisticUrlInput = document.querySelector('#update_statistic_url');
            updateStatisticUrlInput.setAttribute('type', 'text');
            updateStatisticUrlInput.setAttribute('value', url);
            updateStatisticUrlInput.select()

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                this.$message({
                    type: 'success',
                    message: 'Ссылка для отправки статистики из скрипта в API скопирована'
                });
            } catch (err) {

            }

            /* unselect the range */
            updateStatisticUrlInput.setAttribute('type', 'hidden')
            window.getSelection().removeAllRanges()
        },
        matchHeight() {
            let height = this.$refs.SidebarMenu.clientHeight;

            this.height = height - 80;
        }
    },
    data(){
        return{
           height:0,
            updateStatisticUrl: '',
            menu:[


            ],
        }
    }
}
</script>
<style>
@import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
.ps {

}
</style>

