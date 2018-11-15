<template>
  <div>
    <h1>ตรวจสอบผลการเข้าร่วมกิจกรรม</h1>
    <v-flex xs12 lg6>
      <v-menu
        :close-on-content-click="false"
        v-model="menud"
        :nudge-right="40"
        lazy
        transition="scale-transition"
        offset-y
        full-width
        max-width="290px"
        min-width="290px"
      >
        <v-text-field
          slot="activator"
          v-model="computedDateFormatted"
          label="กรุณาเลือกวันที่"
          hint="MM/DD/YYYY format"
          persistent-hint
          prepend-icon="event"
          readonly
        />
        <v-date-picker v-model="date" no-title @input="menud = false"/>
      </v-menu>
      <p>Date in ISO format: <strong>{{ date }}</strong></p>
    </v-flex>
    <v-data-table
      :headers="headers"
      :items="students"
      class="elevation-1"
    >
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.ac_id }} </td>
        <td class="text-xs-left">{{ props.item.chk_status }} </td>
        <td class="text-xs-left">{{ props.item.chk_date }} </td>
        <td class="text-xs-left">{{ props.item.chk_time }}</td>
      </template>

    </v-data-table>
  </div>
</template>
<script>
export default {
  layout: 'usermember',
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      chk: [],
      students: [],
      headers: [
        { text: 'กิจกรรม', align: 'left', sortable: false },
        { text: 'สถานะ', align: 'left', sortable: false },
        { text: 'วันที่', align: 'left', sortable: false },
        { text: 'เวลา', align: 'left', sortable: false },
      ],
      date: '',
      dateFormatted: null,
      menud: false,
    }
  },
  computed: {
    filteredStudent() {
      return this.students.filter(x => x.ch_date + '' === this.date)
    },
    computedDateFormatted() {
      return this.formatDate(this.date)
    },
  },
  watch: {
    date (val) {
      this.dateFormatted = this.formatDate(this.date)
      this.getStudent()
    },
  },
  async created() {
    console.log('created')
    this.getStudent()
  },
  methods: {
    async getStudent() {
      if (this.date) {
        let res = await this.$http.get('http://panas.krooaom.com/panas-api/std_check.php?ch_date=' + this.date + '&user=' + this.user.user)
        this.students = res.data.student
      } else {
      // let res = await this.$http.get('/student?class=' + this.cls)
      // let res = await this.$http.get('/student', {params: {class: this.cls}})
        let res = await this.$http.get('http://panas.krooaom.com/panas-api/std_checkAll.php?user=' + this.user.user)
        this.students = res.data.student
      }
    },
    formatDate (date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${month}/${day}/${year}`
    },
    parseDate (date) {
      if (!date) return null

      const [month, day, year] = date.split('/')
      return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
    },
  }, // methods
}
</script>
