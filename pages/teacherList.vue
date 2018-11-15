<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="desserts"
      class="elevation-1"
    >
      <template slot="headerCell" slot-scope="props">
        <v-tooltip bottom>
          <span slot="activator">
            {{ props.header.text }}
          </span>
          <span>
            {{ props.header.text }}
          </span>
        </v-tooltip>
      </template>
      <template slot="items" slot-scope="props">
        <td class="text-xs-right">{{ props.item.ta_name }}</td>
        <td class="text-xs-right">{{ props.item.ta_pass }}</td>
        <td class="text-xs-right">{{ props.item.ta_email }}</td>
      </template>
    </v-data-table>
  </div>
</template>
<script>
export default {
  layout: 'admin',
  data () {
    return {
      headers: [
        {
          text: 'ชื่อผู้ใช้',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { text: 'รหัสผ่าน', value: 'calories' },
        { text: 'อีเมลล์', value: 'fat' },
      ],
      desserts: [],
    }
  },
  async created() {
    this.getstudent()
  },
  methods: {
    async getstudent() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/teacher_list.php')
      this.desserts = res.data.teacher
    },
  },
}
</script>
