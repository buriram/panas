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
        <td class="text-xs-right">{{ props.item.ac_id }}</td>
        <td class="text-xs-right">{{ props.item.ac_title }}</td>
        <td class="text-xs-right">{{ props.item.ac_note }}</td>
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
          text: 'ที่',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { text: 'กิจกรรม', value: 'calories' },
        { text: 'อื่นๆ', value: 'fat' },
      ],
      desserts: [],
    }
  },
  async created() {
    this.getstudent()
  },
  methods: {
    async getstudent() {
      let res = await this.$http.get('http://panas.krooaom.com/panas-api/act_list.php')
      this.desserts = res.data.activities
    },
  },
}
</script>
