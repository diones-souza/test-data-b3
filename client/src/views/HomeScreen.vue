<template>
  <div>
    <SelectBox :options="options" class="float-right mr-8 z-10" style="margin-top: -10px;"/>
    <div ref="chart"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue'
import type { ApexOptions } from 'apexcharts'
import ApexCharts from 'apexcharts'

const SelectBox = defineAsyncComponent(() => import('../components/SelectBox.vue'))

export default defineComponent({
  name: 'HomeScreen',
  components: {
    SelectBox
  },
  data:()=> ({
    options: ['test']
  }),
  mounted() {
    const options: ApexOptions = {
      chart: {
        type: 'bar'
      },
      series: [
        {
          name: 'sales',
          data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
        }
      ],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep']
      }
    }

    const chart = new ApexCharts(this.$refs.chart as HTMLElement, options)
    chart.render()
  }
})

</script>