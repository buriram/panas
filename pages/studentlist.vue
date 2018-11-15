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
        <td class="text-xs-right">{{ props.item.code }}</td>
        <td class="text-xs-right">{{ props.item.pre_name }}</td>
        <td class="text-xs-right">{{ props.item.fname }}</td>
        <td class="text-xs-right">{{ props.item.lname }}</td>
        <td class="text-xs-right">{{ props.item.birt }}</td>
        <td class="text-xs-right">{{ props.item.pin_id }}</td>
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
          text: 'รหัสนักศึกษา',
          align: 'left',
          sortable: false,
          value: 'code',
        },
        { text: 'คำนำหน้า', value: 'calories' },
        { text: 'ชื่อ', value: 'fat' },
        { text: 'นามสกุล', value: 'carbs' },
        { text: 'ว/ด/ป', value: 'protein' },
        { text: 'เลขบัตร', value: 'iron' },
      ],
      desserts: [],
    }
  },
  async created() {
    this.getstudent()
  },
  methods: {
    async getstudent() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/list.php')
      this.desserts = res.data.student
    },
  },
}
</script>
