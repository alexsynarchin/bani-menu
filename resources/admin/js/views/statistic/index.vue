<template>
    <section>
        <h1 class="page-title">Статистика</h1>
        <div class="page-heading row align-items-end  mb-3" >
            <div class="form-group col-lg-3">
                <label class="form-label">Проект:</label>
                <el-select
                    style="width: 100%"
                    filterable
                    v-model="filters.project_id" placeholder="Выбрать проект"
                    @change="getStatistic">

                    <el-option-group
                        v-for="group in projects"
                        :key="group.id"
                        :label="'Название группы / ' + group.name">
                        <el-option
                            v-for="item in group.projects"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                    </el-option-group>
                </el-select>
            </div>
            <div class="form-group col-lg-2">
                <label class="form-label">Девайс:</label>
                <el-select
                    style="width: 100%"
                    v-model="filters.device_id" placeholder="Выбрать девайс"
                    @change="getStatistic">
                    <el-option
                        v-for="item in devices"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="form-group col-lg-4 statistic-calendar">
                <label class="form-label">Выбрать период</label>
                <el-date-picker
                    style="min-width: 400px"
                    v-model="filters.date_range"
                    :picker-options="pickerOptions"
                    value-format="yyyy-MM-dd"
                    type="daterange"
                    @change="getStatistic"
                    start-placeholder="Дата начала"
                    end-placeholder="Дата окончания">
                </el-date-picker>
            </div>
        </div>
        <div class="table-responsive">
        <table class="statistic-table table table-bordered">
            <thead>
            <tr>
                <th class="statistic-table__first-col statistic-table__sticky-col">
                    Запросы
                </th>
                <th v-for="(date, index) in dates">
                    {{date}}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="(item, index) in statistic"
                :key="index"
            >
                <td class="statistic-table__first-col statistic-table__sticky-col">
                    {{item.keyword}}
                </td>
                <template v-for="(date, index) in dates">
                    <statistic-row
                        v-if="item.statistic[date]"
                        :item-data="item.statistic[date]"
                        @show-item="openStatisticItemModal"
                    ></statistic-row>
                    <td v-else class="statistic-data-row statistic-data-row--none">
                        <span class="statistic-data-row__position">--</span>
                    </td>
                </template>


            </tr>
            </tbody>

        </table>
        </div>
        <statistic-item :id="statisticItemId"
            v-if="statisticItemId"
            @close="statisticItemId = 0"
        ></statistic-item>
    </section>

</template>
<script>
    import StatisticRow from "./components/statistic-row.vue";
    import StatisticItem from "./components/statistic-item.vue";
    export default {
        components: {
            StatisticRow, StatisticItem
        },
        data() {
            return {
                pickerOptions: {
                    shortcuts: [{
                        text: 'Неделя',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: 'Месяц',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '3 месяца',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    },

                        {
                            text: '6 месяцев',
                            onClick(picker) {
                                const end = new Date();
                                const start = new Date();
                                start.setTime(start.getTime() - 3600 * 1000 * 24 * 180);
                                picker.$emit('pick', [start, end]);
                            }
                        },
                        {
                            text: 'Год',
                            onClick(picker) {
                                const end = new Date();
                                const start = new Date();
                                start.setTime(start.getTime() - 3600 * 1000 * 24 * 360);
                                picker.$emit('pick', [start, end]);
                            }
                        }
                    ]
                },
                statisticItemId:0,
                dates: [],
                statistic: [],
                projects: [],

                devices: [
                    {
                        value: 0,
                        label: 'All',
                    },
                    {
                        value: 1,
                        label: 'Mobile',
                    },
                    {
                        value: 2,
                        label: 'Desktop',
                    }
                ],
                filters: {
                    project_id:null,
                    device_id: 0,
                    date_range: []
                },
            }
        },
         methods: {
            openStatisticItemModal(id) {
                console.log(id);
                this.statisticItemId = id;
            },
             getFilterOptions() {
                 axios.get('/api/admin/project-key-task/filter-options')
                     .then((response) => {
                         this.projects = response.data.projects;
                     })
             },
             getStatistic() {
                 axios.get('/api/admin/project-key-statistics' ,{params: this.filters})
                     .then((response) => {
                         console.log(response.data);
                         this.statistic = response.data.project_keys_statistic;
                         this.dates = response.data.dates;
                     })
             }
         },
        mounted() {
            this.getFilterOptions();
            this.getStatistic();
        }
    }
</script>
