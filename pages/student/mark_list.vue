<template>
  <div>
    <h1 class="info--text text-xs-center">รายงานการมาเรียน</h1>
    <v-container grid-list-md text-xs-center>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="subjectList"
            v-model="subjectId"
            item-value="sub_code"
            item-text="sub_code"
            label="เลือกวิชา"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="classList"
            v-model="classId"
            item-value="class_id"
            item-text="class_id"
            label="เลือกกลุ่มเรียน"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
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
        </v-flex>
      </v-layout>
    </v-container>

    <v-container v-if="seen">
      <v-layout row wrap>
        <v-flex xs12>
          <v-data-table :headers="headers" :items="students" class="elevation-1">
            <template slot="items" slot-scope="props">
              <td class="text-xs-left">{{ props.item.st_code }}</td>
              <td class="text-xs-left">{{ props.item.first_name }}</td>
              <td class="text-xs-left">{{ props.item.last_name }}</td>
              <td class="text-xs-left">{{ props.item.l_time }}</td>
            </template>
          </v-data-table>
        </v-flex>
      </v-layout>

    </v-container>

  </div>
</template>

<script>
export default {
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      subjectId: '',
      classId: '',
      studentId: '',
      chk: [],
      subjectList: [],
      classList: [],
      students: [],
      seen: false,
      headers: [
        { text: 'code', align: 'left', sortable: false },
        { text: 'first name', align: 'left', sortable: false },
        { text: 'last name', align: 'left', sortable: false },
        { text: 'time', align: 'left', sortable: false },
      ],
      date: '2018-05-11',
      dateFormatted: null,
      menud: false,
    }
  },
  computed: {
    clsList() {
      return this.subjectList.map(x => ({value: `${x.sub_code}`, text: `${x.sub_code}`}))
    },
    filteredClass_id() {
      return this.classList.filter(x => x.sub_code + '' === this.subjectId)
    },
    computedDateFormatted() {
      return this.formatDate(this.date)
    },
  },
  watch: {
    subjectId() {
      this.getClassroom()
    },
    date (val) {
      this.dateFormatted = this.formatDate(this.date)
      this.getStudent()
    },
  },
  created() {
    this.getSubject()
    this.getClassroom()
  },
  methods: {
    async getClassroom() {
      let res = await this.$http.get('http://chk.cdp58.com/api/list_class-sub.php?sub_code=' + this.subjectId)
      this.classList = res.data.classrooms
    },

    async getSubject() {
      let res = await this.$http.get('http://chk.cdp58.com/api/list_sub.php?user=' + this.user.user)
      console.log(res.data.subject)
      this.subjectList = res.data.subject
    },

    async getStudent() {
      let res = await this.$http.get('http://chk.cdp58.com/api/list_stdcheck.php?user=' + this.user.user +
            '&subject=' + this.subjectId + '&date=' + this.date)
      if (res.data.student.length > 0) {
        this.students = res.data.student
        // alert(this.students[0].id)
        this.seen = true
      } else {
        // alert("NO")

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
  }, // method
}
</script>
