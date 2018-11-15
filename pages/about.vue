<template>
  <div>
    <h1 v-if="ok">About <i>{{ newName }}</i></h1>
    <h2 v-show="ok">age <b>{{ age * 2 }}</b></h2>
    <input :value="name" type="text"><br>
    <input v-model="name" type="text"><br>
    <input v-model="name" type="text"><br>
    <button @click="doSave">SAVE</button>
    <button @click="doAdd">ADD MEMBER</button>
    <table>
      <thead>
        <tr>
          <th>ลำดับ</th>
          <th>ชื่อ</th>
          <th>หน่วยงาน</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(mem, i) in members" :key="mem.id"
          :class="{gray: mem.id % 2}"
          class="text"
        >
          <td>{{ i + 1 }}</td>
          <td>{{ mem.name }}</td>
          <td>{{ mem.org }}</td>
        </tr>
        <tr v-for="(item, k) in {id: 1, name: 'Somsak'}" :key="k" >
          <td>{{ k }} = {{ item }}</td>
        </tr>
        <tr v-for="i in 10" :key="i">
          <td>{{ i + 10 }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      name: 'Somsak Lim',
      age: 25,
      ok: true,
      members: [
        { id: 1, name: 'Name1', org: 'Org1' },
        { id: 2, name: 'Name2', org: 'Org2' },
        { id: 3, name: 'Name3', org: 'Org3' },
      ],
    }
  },
  computed: {
    upperName() {
      return this.name.toUpperCase()
    },
    newName() {
      var tmp = this.name.split(' ')
      if (tmp.length === 1) {
        return this.name
      }
      return tmp[0] + ' ' + tmp[1].substr(0, 1)
    },
  },
  methods: {
    doSave() {
      this.name += '*'
      this.ok = !this.ok
    },
    doAdd() {
      let id = this.members.length + 1
      this.members.push({
        id,
        name: `Name${id}`,
        org: `Org${id}`,
      })
    },
  },
}
</script>
<style>
.text {
  color: blue;
}
.gray {
  background-color: #eee;
}
</style>