<template>
  <v-form v-model="valid">
    <h1>เพิ่มข้อมูล.</h1>
    <v-text-field
      v-model="ac_title"
      label="กิจกรรม"
      required
    />
    <v-text-field
      v-model="ac_note"
      label="อื่นๆ"
      required
    />
       <v-btn color="info" @click="Dosend">บันทึกข้อมูล</v-btn>
    <v-snackbar
      v-model="snackbar"
      top>
      <v-alert :value="true" outline color="error" icon="warning" @click.native="snackbar = false">
        Err Don't Save.
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
    ac_title: '',
    ac_note: '',
  }),
  methods: {
    async Dosend() {
      // let res = await this.$http.post('/auth/login', {
      let res = await this.$http.post('http://panas.krooaom.com/panas-api/addActivities.php', {
        ac_title: this.ac_title,
        ac_note: this.ac_note,          
        
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