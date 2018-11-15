<template>
  <div>
    <h1 class="info--text text-xs-center">รายงานการ...</h1>
    <v-container grid-list-md text-xs-center>
      <v-layout row wrap>
        <v-layout row wrap>
          <v-flex xs6 offset-xs3>
            <v-text-field
              v-model="studentId"
              label="รหัสนักศึกษา"
              required
            />
          </v-flex>
        </v-layout>
    </v-layout></v-container>

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
      studentId: '',
      chk: [],
      students: [],
      seen: false,
      headers: [
        { text: 'code', align: 'left', sortable: false },
        { text: 'first name', align: 'left', sortable: false },
        { text: 'last name', align: 'left', sortable: false },
        { text: 'time', align: 'left', sortable: false },
      ],
    }
  },
  created() {

  },
  methods: {

    async getStudent() {
      let res = await this.$http.get('http://chk.cdp58.com/api/list_stdcheck.php?user=' + this.studentId)
      if (res.data.student.length > 0) {
        this.students = res.data.student
        // alert(this.students[0].id)
        this.seen = true
      } else {
        // alert("NO")

      }
    },
  }, // method
}
</script>
