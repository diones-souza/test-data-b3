<template>
  <div>
    <SelectBox :options="options" @input="loadChart" @change="(v) => search = v" class="float-right z-10" :class="{'mr-36': series.length}" style="margin-top: -10px;" />
    <SpinnerBox :loading="isLoading"/>
    <apexchart height="350px" type="area" :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script lang="ts">
import { defineComponent, defineAsyncComponent } from 'vue'
import moment from 'moment';
import _ from 'lodash'

const SelectBox = defineAsyncComponent(() => import('../components/SelectBox.vue'))
const SpinnerBox = defineAsyncComponent(() => import('../components/SpinnerBox.vue'))

interface Paper {
  id: number,
  date: string,
  paper: string,
  asset_role: string,
  balance_amount: string,
  average_price: string,
  price_factor: string,
  total_balance: string,
  created_at: string,
  updated_at: string
}

interface Series {
  name: string,
  data: Array<number>
}

export default defineComponent({
  name: 'HomeScreen',
  components: {
    SelectBox,
    SpinnerBox
  },
  data:()=> ({
    options: [],
    search: '',
    chartOptions: {},
    series: [] as Array<Series>,
    isLoading: false
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
        const response = await fetch('api/lending-open-position/papers?' + new URLSearchParams({
          search
        }))
        const result = await response.json()
        this.options = result?.data
      } catch (error) {
        console.error(error)
      }
    },
    async getPaperData(paper: string = '') {
      try {
        const response = await fetch('api/lending-open-position/paper-data?' + new URLSearchParams({
          paper
        }))
        return await response.json()
      } catch (error) {
        console.error(error)
      }
    },
    async loadChart(name: string) {
      this.isLoading = true

      const items = await this.getPaperData(name)

      const categories = items.map((item: Paper) => moment(item.date).utc().format('YYYY-MM-DD'))

      this.series = [
        {
          name: 'Average Price',
          data: items.map((item: Paper) => parseFloat(item.average_price))
        },
        {
          name: 'Balance Amount',
          data: items.map((item: Paper) => parseFloat(item.balance_amount))
        }
      ]

      this.chartOptions = {
        xaxis: {
          type: 'date',
          categories
        }
      }

      this.isLoading = false
    },
  },
  mounted() {
    this.fetchData()
  }
})

</script>
