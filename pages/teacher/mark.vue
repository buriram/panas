<template>
  <div>
    <h1 class="info--text text-xs-center">แบบบันทึกการเข้าร่วมกิจกรรม</h1>
    <v-container grid-list-md text-xs-center>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="actList"
            item-value="ac_id"
            item-text="ac_title"
            v-model="actId"
            label="กิจกรรม"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-select
            :items="groupList"
            item-value="group_code"
            item-text="group_code"
            v-model="groupList"
            label="เลือกกลุ่มเรียน"
            single-line
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap>
        <v-flex xs6 offset-xs3>
          <v-btn @click="getStudent"><v-icon class="success--text">repeat</v-icon> ข้อมูลผู้เรียน!!</v-btn>
        </v-flex>
      </v-layout>
    </v-container>

    <v-container v-if="seen">
      <v-layout row wrap>
        <v-flex>
          <v-data-table :headers="headers" :items="students" hide-actions class="elevation-1">
            <template slot="items" slot-scope="props">
              <td class="text-xs-left">{{ props.item.code }} {{ props.item.fname }} {{ props.item.lname }}</td>
              <td class="text-xs-left">
                <v-radio-group v-model="props.item.chk" row>
                  <v-radio
                    color="info"
                    :value="1"
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
  layout: 'teacher',
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      snackbar: false,
      group_code: '',
      studentId: '',
      chk: ['0'],
      groupList: [],
      actList: [],
      students: [],
      actId: '',
      seen: false,
      headers: [
        { text: 'ข้อมูล', align: 'left', sortable: false },
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
      this.getActivities()
    },
  },
  created() {
    this.getGroup()
    this.getActivities()
  },
  methods: {
    async getActivities() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/act_list.php')
      this.actList = res.data.activities
    },
    async getGroup() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/grp_list.php')
      this.groupList = res.data.groupList
    },
    async getStudent() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/studentList.php?group_code=' + this.groupList)
      if (res.data.student.length > 0) {
        this.students = res.data.student
        // alert(this.students[0].id)
        this.seen = true
      } else {
        // alert("NO")

      }
    },

    async saveMark() {
      let res = await this.$http.post('http://panas.krooaom.com/panas-api/actCheck.php', {
        user: this.user.user,
        actId: this.actId,
        marks: this.students.map(st => ({sid: st.code, mark: st.chk})),
      })
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

  },
}
</script>
