<template>
  <div>
    <h1>Student behavior.</h1>
    <v-text-field v-model="code" label="รหัส" />
    <v-text-field v-model="firstName" label="ชื่อ" />
    <v-text-field v-model="lastName" label="นามสกุล" />
    <v-text-field v-model="b_date" label="วันที่" />
    <v-text-field v-model="b_time" label="เวลา" />
    <v-select
      :items="clsList"
      v-model="cls"
      label="Select"
      single-line
    />
    <v-btn @click="save">บันทึก</v-btn>
  </div>
</template>
<script>
// http://localhost:3000/#/student/edit?id=1
export default {
  data() {
    return {
      code: '',
      firstName: '',
      lastName: '',
      b_date: '',
      b_time: '',
      cls: '1',
        clsList: [
        { value: 'ทำความดี', text: 'ทำความดี' },
        { value: 'แต่งกายไม่เรียบร้อย', text: 'แต่งกายไม่เรียบร้อย' },
        { value: 'มาสาย', text: 'มาสาย' },
      ],
    }
  },
    async created() {
    let res = await this.$http.get('/student/id/' + this.$route.query.id)
     this.code = res.data.student.code || ''
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
      let res = await this.$http.post('/student/save5', {
        code: this.code,
        firstName: this.firstName,
        lastName: this.lastName,
        behav: this.cls,
        b_date: this.b_date,
        b_time: this.b_time,
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
