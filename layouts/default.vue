<template>
  <v-app>
    <v-navigation-drawer v-model= "sideNav" app>
      <v-list>
        <v-list-tile
          v-for = "item in Items"
          :to="item.to"
          :key = "item.title"
          router>
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>{{ item.title }}</v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar dark class="red darken-4">
      <v-toolbar-side-icon class="hidden-sm-and-up"
                           @click.native.stop = "sideNav = !sideNav"/>
      <v-toolbar-title>อวท 4.0</v-toolbar-title>
      <v-spacer/>
      <v-toolbar-items class="hidden-xs-only">
        <v-btn v-for = "item in Items" :to="item.to" :key = "item.title" flat router>
          <v-icon left dark="">{{ item.icon }}</v-icon>
          {{ item.title }}
        </v-btn>
      </v-toolbar-items>
    </v-toolbar>
    <v-content class="white">
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer :fixed="fixed" app class="red darken-1" dark>
      <span>PANAS->computer&copy;2018 </span><nuxt-link to="/adminLogin">[สำหรับผู้ดูแลระบบ]</nuxt-link>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
      user: JSON.parse(window.sessionStorage.getItem('user')),
      sideNav: false,
      fixed: false,
      Items: [
        { icon: 'home', title: 'หน้าหลัก', to: '/' },
        { icon: 'group', title: '[ครู-เจ้าหน้าที่]', to: '/taLogin' },
        { icon: 'person_add', title: 'สมัครสมาชิก', to: '/register' },
        { icon: 'lock_open', title: 'เข้าสู่ระบบ', to: '/login' },
      ],
    }
  },
}
</script>
