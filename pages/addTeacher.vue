<template>
  <v-form v-model="valid">
    <h1>เพิ่มข้อมูลครู.</h1>
    <v-text-field
      v-model="ta_name"
      label="ชื่อผู้ใช้"
      required
    />
    <v-text-field
      v-model="ta_pass"
      label="รหัสผ่าน"
      required
    />
    <v-text-field
      v-model="ta_email"
      label="อิเมลล์"
      required
    />
    <v-btn color="info" @click="Dosend">บันทึกข้อมูล</v-btn>
    <v-snackbar
      v-model="snackbar"
      top>
      <v-alert :value="true" outline color="error" icon="warning" @click.native="snackbar = false">
        Err Don't Login.
      </v-alert>
    </v-snackbar>
  </v-form>
</template>
<script>
export default {
  layout: 'admin',
  data: () => ({
    snackbar: false,
    e1: true,
    valid: false,
    ta_name: '',
    ta_pass: '',
    ta_email: '',
  }),
  methods: {
    async Dosend() {
      // let res = await this.$http.post('/auth/login', {
      let res = await this.$http.post('http://panas.krooaom.com/panas-api/addTeacher.php', {
        ta_name: this.ta_name,
        ta_pass: this.ta_pass,
        ta_email: this.ta_email,
      })
      if (res.data.ok) {
        // TODO: แสดงข้อความ ว่าบันทึกไม่สำเร็จ
        this.snackbar = true
      } else {
        window.sessionStorage.setItem('user', JSON.stringify({
          user: this.user,
        }))

        // TODO: แสดงข้อความ ว่าบันทึกสำเร็จ
        this.$router.push('/adminPage')
      }
    },
  },
}
</script>
