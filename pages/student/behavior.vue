<template>
  <div>
    <h1>Student List</h1>
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
        <td class="text-xs-left">{{ props.item.code }}</td>
        <td class="text-xs-left">{{ props.item.first_name }}</td>
        <td class="text-xs-left">{{ props.item.last_name }}</td>
        <td class="text-xs-left">{{ props.item.ch_ts }}</td>
      </template>

    </v-data-table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      chk: [],
      students: [],
      headers: [
        { text: 'code', align: 'left', sortable: false },
        { text: 'Firstname', align: 'left', sortable: false },
        { text: 'Lastname', align: 'left', sortable: false },
        { text: 'time', align: 'left', sortable: false },

      ],
      date: this.$moment().format('YYYY-MM-DD'),
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
      // let res = await this.$http.get('/student?class=' + this.cls)
      // let res = await this.$http.get('/student', {params: {class: this.cls}})
      let res = await this.$http.get('http://chk.cdp58.com/api/st_behav.php?ch_date=' + this.date + '&user=' + this.user.user)
      this.students = res.data.student
    },
    async save() {
      let res = await this.$http.post('http://chk.cdp58.com/api/st_check.php', {chk: this.chk})
      // console.log(thik.chk)
      console.log(res.data.ok)
      if (res.data.ok) {
        // TODO: แสดงข้อความ ว่าบันทึกไม่สำเร็จ
      } else {
        // TODO: แสดงข้อความ ว่าบันทึกสำเร็จ
        // this.$router.push('/student')
        this.snackbar = true
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
