<template>
  <v-parallax>
    <v-flex xs12 sm6 offset-sm3>
      <v-card color="transparent">
        <v-card-media
          height="593px"
          contain
          src="/pic/logo.png"
        />
        <div class="text-xs-center">
          <v-btn color="light-green accent-4" @click="trunIn">Continue to program</v-btn>
        </div>
      </v-card>
    </v-flex>
  </v-parallax>
</template>
<script>
export default {
  data() {
    return {
      id: 1,
    }
  },
}
</script>
