<template>
  <div>
    <div class="footer-menu position-fixed w-100 bottom-0 bg-grey">
      <div class="row justify-content-center">
        <div class="col-md-8 p-2 d-flex justify-content-between">
          <div @click="home()" class="d-flex flex-column align-center">
            <i class="fas fa-home"></i>
            Home
          </div>
          <div @click="profile()" class="d-flex flex-column align-center">
            <i class="fas fa-user"></i>
            Profile
          </div>
          <div @click="myproject()" class="d-flex flex-column align-center">
            <i class="fas fa-user"></i>
            My Project
          </div>
          <div
            v-if="userInfo.role_id == 1"
            @click="company()"
            class="d-flex flex-column align-center"
          >
            <i class="fas fa-gear"></i>
            Company Setting
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  name: "FooterPage",
  computed: {
    ...mapGetters(["userInfo", "getToken"]),
  },
  methods: {
    profile() {
      this.$router.push({
        name: "profile",
      });
    },
    company() {
      this.$router.push({
        name: "company",
      });
    },
    myproject() {
      this.$router.push({
        name: "myProject",
      });
    },
    home() {
      this.$router.push({
        name: "home",
      });
    },
  },
};
</script>

<style lang="stylus" scoped></style>
