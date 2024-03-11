<template>
  <div>
    <Header title="Attendance create"></Header>
    <div class="container">
      <div class="card my-15 col-md-6 mx-auto">
        <div class="card-body p-5">
          <h1 class="mb-5 text-primary">Add Attendance</h1>
          <form class="text-start row">
            <div v-if="errors && errors.record" class="text-danger">
              {{ errors.record }}
            </div>
            <div class="form-group mb-4">
              <label class="form-label">Employee</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.user_id ? 'is-invalid' : ''"
                v-model="data.user_id"
              >
                <option disabled>Employee</option>
                <option
                  v-for="(employee, index) in employees"
                  :key="index"
                  :value="employee.id"
                >
                  {{ employee.name }}
                </option>
              </select>
              <div v-if="errors && errors.user_id" class="text-danger">
                {{ errors.user_id[0] }}
              </div>
            </div>
            <div class="form-group mb-4">
              <label class="form-label">Date</label>
              <input
                type="date"
                v-model="data.date"
                class="form-control form-control-lg"
                :class="errors.date ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.date" class="text-danger">
                {{ errors.date[0] }}
              </div>
            </div>
            <div class="form-group mb-4">
              <label class="form-label">Check In Time</label>
              <input
                type="time"
                v-model="data.check_in"
                class="form-control form-control-lg"
                :class="errors.check_in ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.check_in" class="text-danger">
                {{ errors.check_in[0] }}
              </div>
            </div>
            <div class="form-group mb-4">
              <label class="form-label">Check Out Time</label>
              <input
                type="time"
                v-model="data.check_out"
                class="form-control form-control-lg"
                :class="errors.check_out ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.check_out" class="text-danger">
                {{ errors.check_out[0] }}
              </div>
            </div>
            <div class="d-flex justify-content-center my-3">
              <button
                type="button"
                class="btn btn-primary text-white btn-block btn-lg"
                @click="createAttendance()"
              >
                ADD
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Footer></Footer>
  </div>
</template>

<script>
import Header from "../AppHeader.vue";
import Footer from "../FooterPage.vue";
import axios from "axios";

export default {
  name: "CreateAttendance",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      data: {
        user_id: "",
        date: "",
        check_in: "",
        check_out: "",
      },
      errors: {},
      employees: [],
    };
  },
  methods: {
    //get username
    getUsername() {
      axios
        .get("http://localhost:8000/api/attendance/data")
        .then((response) => {
          this.employees = response.data;
        })
        .catch((e) => {
          console.log(e);
        });
    },
    //post data to backend
    createAttendance() {
      axios
        .post("http://localhost:8000/api/attendance/create", this.data)
        .then((response) => {
          console.log(response);
          if (response.data.status == true) {
            this.$router.push({
              name: "attendance",
              query: {
                message: response.data.message,
              },
            });
          } else {
            this.errors.record = response.data.message;
          }
        })
        .catch((e) => {
          console.log(e);
          if (e.response.status == 422) {
            this.errors = e.response.data.errors;
          }
        });
    },
  },
  mounted() {
    this.getUsername();
  },
};
</script>

<style lang="stylus" scoped></style>
