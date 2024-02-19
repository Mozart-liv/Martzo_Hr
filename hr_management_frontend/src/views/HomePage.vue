<template>
  <div>
    <Header></Header>
    <h1 v-if="!login">Login please</h1>
    <div v-else class="col-md-10 mx-auto p-3 my-5">
      <v-card class="mx-auto p-4 col-md-8" elevation="6">
        <div class="d-flex flex-row flex-wrap align-center justify-start p-3">
          <div class="me-5">
            <v-avatar size="150">
              <v-img :src="data.img" cover> </v-img>
            </v-avatar>
          </div>
          <div class="p-3 text-center">
            <h3>{{ data.name }}</h3>
            <p class="text-grey">{{ data.employee_id }}</p>
          </div>
        </div>
        <div class="">
          <v-switch
            @change="checkinOut()"
            :model-value="check"
            hide-details
            color="success"
            :label="`${checkLable}`"
          ></v-switch>
        </div>
      </v-card>
    </div>
    <Footer></Footer>
  </div>
</template>

<script>
import Header from "../views/AppHeader.vue";
import Footer from "../views/FooterPage.vue";
import { mapGetters } from "vuex";
import axios from "axios";
import Swal from "sweetalert2";
export default {
  name: "HomePage",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      login: false,
      check: "",
      checkLable : "",
      data: {},
    };
  },
  computed: {
    ...mapGetters(["userInfo", "getToken"]),
  },
  methods: {
    checkLogin() {
      if (this.getToken !== "") {
        this.login = true;
      }
    },
    //for check when page reload
    checkattend() {
      axios
        .get("http://localhost:8000/api/checkInOutData/" + this.userInfo.id)
        .then((response) => {
          if (response.data == true) {
            this.check = true;
            this.checkLable = 'checkin';
          }else{
            this.check = false;
            this.checkLable = 'checkout';
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
    checkinOut() {
      const data = {
        user_id: this.userInfo.id,
        check: this.check,
      };
      axios
        .post("http://localhost:8000/api/checkInOut", data)
        .then((response) => {
          console.log(response);
          if (response.data.status == "false") {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Today Attendence has already recorded!",
            });
          }else{
            if(response.data.mes == 'checkin'){
                this.checkLable = 'checkin';
            }else{
                this.checkLable = 'checkout';
            }
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
    getData() {
      axios
        .get("http://localhost:8000/api/employee/userData/" + this.userInfo.id)
        .then((response) => {
          console.log(response);
          if (response.data.img == null) {
            response.data.img = "http://localhost:8000/image/default.jpg";
          } else {
            response.data.img =
              "http://localhost:8000/image/" + response.data.img;
          }
          this.data = response.data;
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
  mounted() {
    this.checkLogin();
    this.getData();
    this.checkattend();
  },
};
</script>

<style lang="stylus" scoped></style>
