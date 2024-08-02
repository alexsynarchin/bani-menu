<template>
    <td class="statistic-data-row"
        @click.prevent ="showStatisticItem"
        :class="selectBgClassName()"
        :style="position !== 0 ? 'cursor:pointer' : ''">
        <template v-if="position > 0" >
        <span class="statistic-data-row__position">
             {{position}}
        </span>
            <sup style="font-weight: bold; font-size: 14px">
                <template v-if="avg_position_diff < 0">
                    <i class="el-icon-top" style="color: #20b805"></i>
                    <span style="color: #20b805">
                      {{avg_position_diff * -1}}
                    </span>
                </template>
                <template v-else-if="avg_position_diff > 0">
                    <i class="el-icon-bottom" style="color:#f56c6c"></i>
                    <span style="color:#f56c6c">
                      {{avg_position_diff}}
                    </span>
                </template>
            </sup>
        </template>
        <template v-else>
            <span class="statistic-data-row__position">--</span><sup><i class="el-icon-close" style="color:#f56c6c"></i></sup>
        </template>

    </td>
</template>
<script>
import postcss from "postcss";

export default
{
    data() {
        return {

        }
    },
    props: {
        itemData: {
            type:Object
        }
    },
    computed: {
        position: function () {
            let avg_position = this.itemData.sum_position / this.itemData.found;
            return avg_position ? Math.round(avg_position) : 0;
        },
        avg_position_diff:function () {
            let avg_diff = 0;
            if(this.position > 0 && this.itemData.avg_position_last > 0) {
                avg_diff = this.position - Math.round(this.itemData.avg_position_last);
            }
            return avg_diff;
        }
    },
     methods: {
        showStatisticItem() {
            if(this.position > 0) {
                this.$emit('show-item', this.itemData.id)
            }

        },
        selectBgClassName() {
            let tdClassName = '';

                if(this.avg_position_diff > 0) {
                    switch (this.avg_position_diff) {
                        case 0:
                            tdClassName = '';
                            break;
                        case 1:
                            tdClassName = 'statistic-data-row--1';
                            break;
                        case 2:
                        case 3:
                            tdClassName = 'statistic-data-row--3';
                            break;
                        case 4:
                            tdClassName = 'statistic-data-row--4';
                            break;
                        case 5:
                            tdClassName = 'statistic-data-row--5';
                            break;
                        case 6:
                            tdClassName = 'statistic-data-row--6';
                            break;
                        case 7:
                            tdClassName = 'statistic-data-row--7';
                            break;
                        case 8:
                            tdClassName = 'statistic-data-row--8';
                            break;
                        case 9:
                            tdClassName = 'statistic-data-row--9';
                            break;
                        case 10:
                            tdClassName = 'statistic-data-row--10';
                            break;
                        default:
                            tdClassName = 'statistic-data-row--11';
                    }
                } else if (this.avg_position_diff < 0) {
                    tdClassName = 'statistic-data-row--upper'
                }
                if(this.position === 0) {
                    tdClassName = 'statistic-data-row--11'
                }

            return tdClassName;
        }

     },
    mounted() {
        this.selectBgClassName()
    }
}
</script>
