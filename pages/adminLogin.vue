<template>
  <v-container>
    <v-form v-model="valid">
      <h1>เข้าสู่ระบบ [สำหรับผู้ดูแลระบบ]</h1>
      <v-layout column>
        <v-flex>
          <v-text-field
            v-model="user"
            :rules="emailRules"
            label="อีเมลล์"
            required
          />
        </v-flex>
        <v-flex>
          <v-text-field
            v-model="pass"
            :append-icon="e1 ? 'visibility' : 'visibility_off'"
            :append-icon-cb="() => (e1 = !e1)"
            :type="e1 ? 'password' : 'text'"
            name="input-10-1"
            label="รหัสผ่าน"
            hint="At least 8 characters"
            min="8"
            counter />
        </v-flex>
        <v-flex>
          <v-btn color="info" @click="Dosend">Log in.</v-btn>
        </v-flex>
      </v-layout>
      <v-snackbar
        v-model="snackbar"
        top>
        <v-alert :value="true" outline color="error" icon="warning" @click.native="snackbar = false">
          Err Don't Login.
        </v-alert>
      </v-snackbar>
    </v-form>
  </v-container>
</template>
<script>
export default {

  data: () => ({
    snackbar: false,
    e1: true,
    valid: false,
    user: '',
    pass: '',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid',
    ],
  }),
  methods: {
    async Dosend() {
      // let res = await this.$http.post('/auth/login', {
      let res = await this.$http.post('http://panas.krooaom.com/panas-api/adminlogin.php', {
        user: this.user,
        pass: this.pass,
      })
      if (!res.data.ok) {
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
