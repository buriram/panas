<template>
  <div>
    <h1>Student Delete</h1>
    <v-text-field v-model="firstName" label="ชื่อ" />
    <v-text-field v-model="lastName" label="นามสกุล" />
    <v-btn @click="save" color="warning">ยืนยันการลบ</v-btn>
  </div>
</template>
<script>
// http://localhost:3000/#/student/edit?id=1
export default {
  data() {
    return {
      firstName: '',
      lastName: '',
    }
  },
  async created() {
    let res = await this.$http.get('/student/id/' + this.$route.query.id)
    this.firstName = res.data.student.firstName || ''
    this.lastName = res.data.student.lastName || ''
    // {
    //   ok: true,
    //   student: {
    //     id: 1,
    //     firstName: '',
    //     lastName: '',
    //     birth: '',
    //     class: 1,
    //   }
    // }
  },
  methods: {
    async save() {
      let res = await this.$http.post('/student/delete', {
        id: this.$route.query.id,
        firstName: this.firstName,
        lastName: this.lastName,
      })
      if (!res.data.ok) {
        // TODO: แสดงข้อความ ว่าบันทึกไม่สำเร็จ
      } else {
        // TODO: แสดงข้อความ ว่าบันทึกสำเร็จ
        this.$router.push('/student')
      }
    },
  },
}
</script>
