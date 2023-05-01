<template>
  <div>
    <SelectBox :options="options" @input="loadChart" @change="(v) => search = v" class="float-right mr-8 z-10" style="margin-top: -10px;"/>
    <div ref="chart"></div>
  </div>
</template>

<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue'
import type { ApexOptions } from 'apexcharts'
import ApexCharts from 'apexcharts'
import _ from 'lodash'

const SelectBox = defineAsyncComponent(() => import('../components/SelectBox.vue'))

export default defineComponent({
  name: 'HomeScreen',
  components: {
    SelectBox
  },
  data:()=> ({
    options: [],
    search: ''
  }),
  watch: {
    search: _.debounce(function(this: any, value: string){
      if(typeof value === 'string') {
        this.fetchData(value)
      }
    }, 1000)
  },
  methods: {
    async fetchData(search: string = '') {
      try {
        const url = import.meta.env.VITE_API_URL
        const response = await fetch(`${url}/lending-open-position/papers?` + new URLSearchParams({
          search
        }))
        const result = await response.json()
        this.options = result?.data
      } catch (error) {
        console.error(error)
      }
    },
    loadChart(value: string) {
      console.log(value);
      
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
    },
  },
  mounted() {
    this.fetchData()
  }
})

</script>