<template>
  <div>
    <h1>Student List</h1>
    <v-select
      :headers="headers"
      :items="clsList"
      v-model="cls"
      label="โปรดเลือกชั้นปี"
      single-line
    />
    <v-data-table :headers="headers" :items="students" hide-actions class="elevation-1">
      <template slot="items" slot-scope="props">
        <td class="text-xs-left">{{ props.item.code }} {{ props.item.first_name }} {{ props.item.last_name }}</td>
        <td class="text-xs-left"><v-checkbox v-model="chk" :value="props.item.code"/></td>
      </template>
    </v-data-table>
    <div class="text-xs-right">
      <v-btn color="primary" dark style="cursor : pointer" @click="save">check<v-icon>add_box</v-icon></v-btn>
      <v-snackbar
        v-model="snackbar"
        top>
        <v-alert :value="true" outline color="primary" dark icon="cloud_done" @click.native="snackbar = false">
          Success Data.
        </v-alert>
      </v-snackbar>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      cls: '',
      chk: [],
      students: [],
      snackbar: false,
      classe: [],
      headers: [
        { text: 'Data', align: 'left', sortable: false},
        { text: 'Check', align: 'left', sortable: false},
      ],
    }
  },
  computed: {
    clsList() {
      return this.classe.map(x => ({value: `${x.class_id}`, text: `${x.class_name}`}))
    },
    filteredStudent() {
      return this.students.filter(x => x.class + '' === this.cls)
    },
  },
  watch: {
    cls() {
      this.getStudent()
    },
  },
  async created() {
    console.log('created')
    this.getStudent()
    this.getClass_id()
  },
  methods: {
    async getClass_id() {
      let res = await this.$http.get('http://chk.cdp58.com/api/list_class.php?ta_code=' + this.user.user)
      if (res.data.classed.length > 0) {
        this.classe = res.data.classed
      }
    },
    async getStudent() {
      // let res = await this.$http.get('/student?class=' + this.cls)
      // let res = await this.$http.get('/student', {params: {class: this.cls}})
      if (this.cls != '') {
        let res = await this.$http.get('http://chk.cdp58.com/api/list_student.php?class=' + this.cls)
        if (res.data.student.length > 0) {
          this.students = res.data.student
        }
      }
    },
    async save() {
      let res = await this.$http.post('http://chk.cdp58.com/api/st_check.php', {chk: this.chk, user: this.user.user})
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
  }, // methods
}
</script>
