<template>
  <div>
    <h1>Student List</h1>
    <v-select
      :items="clsList"
      v-model="cls"
      label="Select"
      single-line
    />
    <select v-model="cls">
      <option value="1">1</option>
      <option value="2">2</option>
    </select>
      <div v-for="st in filteredStudent" :key="st.id">
      <v-list-tile avatar>
          <v-list-tile-content>
                <v-list-tile-title>{{ st.code }} {{ st.firstName }} {{ st.lastName }}</v-list-tile-title>
                <v-list-tile-sub-title></v-list-tile-sub-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-checkbox v-model="chk" :value="st.code"></v-checkbox>
          </v-list-tile-action>
        </v-list-tile>
      </div>
      <v-spacer></v-spacer>
      <v-btn @click="save"><v-icon flat left>clear_all</v-icon>ส่ง</v-btn>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cls: '1',
      chk: [],
      students: [],
      clsList: [
        { value: '1', text: 'ชั้นปีที่ 1' },
        { value: '2', text: 'ชั้นปีที่ 2' },
        { value: '3', text: 'ชั้นปีที่ 3' },
      ]
    }
    },
  computed: {
    filteredStudent() {
      return this.students.filter(x => x.class + '' === this.cls)
    },
  },
  async created() {
    console.log('created')
    this.getStudent()
  },
  methods: {
    async getStudent() {
      // let res = await this.$http.get('/student?class=' + this.cls)
      let res = await this.$http.get('/student')
      this.students = res.data.student
    },
    async save() {
      let res = await this.$http.post('http://chk.cdp58.com/st_check.php', {chk: this.chk})
      console.log(thik.chk)
    }
  }, // methods
}
</script>