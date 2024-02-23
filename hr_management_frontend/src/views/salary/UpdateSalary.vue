<template>
  <div>
    <Header></Header>
    <div class="container">
      <div class="card my-15 col-md-6">
        <div class="card-body p-5">
          <h1 class="mb-5 text-primary">Update Department</h1>
          <form class="text-start row">
            <div class="form-group mb-4">
              <label class="form-label">Employee</label>
              <select
                class="select form-select"
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

            <div class="form-gorup mb-4">
              <label class="form-label">Year</label>
              <select v-model="data.year" class="form-select">
                <option
                  :value="year"
                  v-for="(year, index) in years"
                  :key="index"
                >
                  {{ year }}
                </option>
              </select>
            </div>
            <div class="form-gorup mb-4">
              <label class="form-label">Month</label>
              <select v-model="data.month" class="form-select">
                <option
                  v-for="(month, index) in months"
                  :key="index"
                  :value="month.id"
                >
                  {{ month.name }}
                </option>
              </select>
            </div>

            <div class="form-gorup mb-4">
              <label class="form-label">Amount</label>
              <input
                type="text"
                v-model="data.amount"
                class="form-control form-control-lg"
                :class="errors.amount ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.amount" class="text-danger">
                {{ errors.amount[0] }}
              </div>
            </div>

            <div class="d-flex justify-content-center my-3">
              <button
                type="button"
                class="btn btn-primary text-white btn-block btn-lg"
                @click="updateSalary()"
              >
                ADD
              </button>
            </div>
            <div v-if="errors.message" class="text-danger">
              {{ errors.message }}
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
import moment from "moment";
export default {
  name: "UpdateSalary",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      id: "",
      employees: [],
      data: {},
      errors: {},
      years: [],
      months: [
        {
          id: 1,
          name: "Jan",
        },
        {
          id: 2,
          name: "Fed",
        },
        {
          id: 3,
          name: "Mar",
        },
        {
          id: 4,
          name: "Apr",
        },
        {
          id: 5,
          name: "May",
        },
        {
          id: 6,
          name: "Jun",
        },
        {
          id: 7,
          name: "Jul",
        },
        {
          id: 8,
          name: "Aug",
        },
        {
          id: 9,
          name: "Sep",
        },
        {
          id: 10,
          name: "Oct",
        },
        {
          id: 11,
          name: "Nov",
        },
        {
          id: 12,
          name: "Dec",
        },
      ],
    };
  },
  methods: {
    getOldData(id) {
      axios
        .get("http://localhost:8000/api/salary/update/" + id)
        .then((response) => {
          console.log(response);
          this.data = response.data;
        })
        .catch((e) => {
          console.log(e);
        });

      axios
        .get("http://localhost:8000/api/salary/getFormData")
        .then((response) => {
          this.employees = response.data.employees;
        });

      this.years = [];
      for (let i = 10; i >= 0; i--) {
        this.years.push(
          moment().add(5, "years").subtract(i, "years").format("YYYY")
        );
      }
    },
    updateSalary() {
      axios
        .post("http://localhost:8000/api/salary/update", this.data)
        .then((response) => {
          if (response.data.status == true) {
            this.$router.push({
              name: "salary",
              query: {
                message: response.data.message,
              },
            });
          } else {
            this.errors.message = response.data.message;
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
    this.id = this.$route.query.id;
    this.getOldData(this.id);
  },
};
</script>

<style lang="stylus" scoped></style>
