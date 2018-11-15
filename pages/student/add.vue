<template>
  <div>
    <h1>Student Add</h1>
    <v-text-field v-model="code" label="รหัสนักศึกษา" />
    <v-text-field v-model="firstName" label="ชื่อ" />
    <v-text-field v-model="lastName" label="นามสกุล" />
    <v-text-field v-model="birth" label="วันเดือนปิเกิด" />
    <v-text-field v-model="st_class" label="กลุ่ม" />
    <v-btn @click="save" color="success">บันทึก</v-btn>
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
      birth: '',
      st_class: '',
    }
  },
  methods: {
    async save() {
      let res = await this.$http.post('/student/save2', {
        code: this.code,
        firstName: this.firstName,
        lastName: this.lastName,
        birth: this.birth,
        st_class: this.st_class,
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
