<template>
  <div>
    <h1 class="info--text text-xs-center">แบบบันทึกการมาเรียน</h1>
    <v-container grid-list-md text-xs-center>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="subjectList"
            item-value="sub_code"
            item-text="sub_code"
            v-model="subjectId"
            label="เลือกวิชา"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="classList"
            item-value="class_id"
            item-text="class_id"
            v-model="classId"
            label="เลือกกลุ่มเรียน"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-btn @click="getStudent"><v-icon class="success--text">repeat</v-icon> GET Student!!</v-btn>
        </v-flex>
      </v-layout>
    </v-container>

    <v-container v-if="seen">
      <v-layout row wrap>
        <v-flex>
          <v-data-table :headers="headers" :items="students" hide-actions class="elevation-1">
            <template slot="items" slot-scope="props">
              <td class="text-xs-left">{{ props.item.code }} {{ props.item.first_name }} {{ props.item.last_name }}</td>
              <td class="text-xs-left">
                <v-radio-group v-model="props.item.chk" row>
                  <v-radio
                    color="info"
                    :value="1"
                  />
                  <v-radio
                    color="warning"
                    :value="2"
                  />
                </v-radio-group>
              </td>
            </template>
          </v-data-table>
        </v-flex>
      </v-layout>
      <div class="text-xs-right">
        <v-btn class="success" @click="saveMark">SAVE !!</v-btn>
        <v-snackbar
          top
          v-model="snackbar">
          <v-alert :value="true" outline color="primary" dark icon="cloud_done" @click.native="snackbar = false">
            Success Data.
          </v-alert>
        </v-snackbar>
      </div>

    </v-container>

  </div>
</template>

<script>
export default {
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      snackbar: false,
      subjectId: '',
      classId: '',
      studentId: '',
      chk: ['0'],
      subjectList: [],
      classList: [],
      students: [],
      seen: false,
      headers: [
        { text: 'ข้อมูล', align: 'left', sortable: false},
        { text: 'มา - ลา', align: 'left', sortable: false},
      ],
    }
  },
  computed: {
    clsList() {
      return this.subjectList.map(x => ({value: `${x.sub_code}`, text: `${x.sub_code}`}))
    },
    filteredClass_id() {
      return this.classList.filter(x => x.sub_code + '' === this.subjectId)
    },
  },
  watch: {
    subjectId() {
      this.getClassroom()
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
      let res = await this.$http.get('http://chk.cdp58.com/api/list_stdLearn.php?class_id=' + this.classId)
      if (res.data.student.length > 0) {
        this.students = res.data.student
        // alert(this.students[0].id)
        this.seen = true
      } else {
        // alert("NO")

      }
    },

    async saveMark() {
      let res = await this.$http.post('http://chk.cdp58.com/api/std_checkL.php', {
        // let res = await this.$http.post('http://127.0.0.1/php_file/std_checkL.php', {
        user: this.user.user,
        sub_code: this.subjectId,
        marks: this.students.map(st => ({sid: st.code, mark: st.chk})),
      })
      // console.log(thik.chk)
      console.log(res.data.ok)
      if (res.data.ok != true) {
        // TODO: แสดงข้อความ ว่าบันทึกไม่สำเร็จ
      } else {
        // TODO: แสดงข้อความ ว่าบันทึกสำเร็จ
        // this.$router.push('/student')
        this.snackbar = true
      }
    },

  },
}
</script>
