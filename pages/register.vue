<template>
  <v-form v-model="valid">
    <h1>เพิ่มข้อมูล.</h1>
    <v-text-field
      v-model="s_code"
      label="รหัส"
      required
    />
    <v-text-field
      v-model="s_idcard"
      label="เลขบัตรประชาชน"
      required
    />
    <v-text-field
      v-model="s_name"
      label="ชื่อ"
      required
    />
    <v-text-field
      v-model="s_class"
      label="ระดับชั้น"
      required
    />
    <v-text-field
      v-model="s_group"
      label="กลุ่ม"
      required
    />
    <v-text-field
      v-model="s_dep"
      label="แผนก"
      required
    />
    <v-text-field
      v-model="s_tel"
      label="เบอร์โทร"
      required
    />
    <v-text-field
      v-model="s_address"
      label="ที่อยู่"
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
  layout: 'defaul',
  data: () => ({
    snackbar: false,
    e1: true,
    valid: false,
    s_code: '',
    s_idcard: '',
    s_name: '',
    s_class: '',
    s_dep: '',
    s_group: '',
    s_tel: '',
    s_address: '',
  }),
  methods: {
    async Dosend() {
      // let res = await this.$http.post('/auth/login', {
      let res = await this.$http.post('http://panas.krooaom.com/panas-api/add.php', {
        s_code: this.s_code,
        s_idcard: this.s_idcard,
        s_name: this.s_name,
        s_class: this.s_class,
        s_dep: this.s_dep,
        s_group: this.s_group,
        s_tel: this.s_tel,
        s_address: this.s_address,

      })
      if (res.data.ok) {
        // TODO: แสดงข้อความ ว่าบันทึกไม่สำเร็จ
        this.snackbar = true
      } else {
        window.sessionStorage.setItem('user', JSON.stringify({
          user: this.user,
        }))

        // TODO: แสดงข้อความ ว่าบันทึกสำเร็จ
        this.$router.push('/login')
      }
    },
  },
}
</script>
