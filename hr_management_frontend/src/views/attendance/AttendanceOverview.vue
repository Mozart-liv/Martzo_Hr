<template>
  <div>
    <Header></Header>
    <div class="col-md-8 my-5 mx-auto p-3">
      <div class="card mt-3">
        <div class="card-body p-4">
          <v-row>
            <v-col class="d-flex justify-content-around">
              <div class="me-3 col-4">
                <select v-model="year" class="form-select" @change="getData()">
                  <option
                    :value="year"
                    v-for="(year, index) in years"
                    :key="index"
                  >
                    {{ year }}
                  </option>
                </select>
              </div>
              <div class="me-3 col-4" @change="getData()">
                <select v-model="month" class="form-select">
                  <option
                    :value="month.id"
                    v-for="(month, index) in months"
                    :key="index"
                  >
                    {{ month.name }}
                  </option>
                </select>
              </div>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-table>
                <thead>
                  <tr>
                    <th class="text-left">Name</th>

                    <th
                      v-for="(period, columnIndex) in periods"
                      :key="columnIndex"
                    >
                      {{ period }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(employee, index) in employees" :key="index">
                    <td>{{ employee.name }}</td>
                    <td
                      v-for="(period, columnIndex) in periods"
                      :key="columnIndex"
                    >
                      <i :class="condition(attendance[index][columnIndex])"></i>
                    </td>
                  </tr>
                </tbody>
              </v-table>
            </v-col>
          </v-row>
        </div>
      </div>
    </div>

    <Footer></Footer>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
import Header from "../AppHeader.vue";
import Footer from "../FooterPage.vue";
import moment from "moment";
export default {
  name: "AttendanceOverView",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      message: "",
      periods: [],
      employees: [],
      loading: "",
      attendance: [],
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
      month: moment().format("M"),
      year: moment().format("YYYY"),
      itemsPerPage: 5,
      total: 0,
    };
  },
  computed: {
    ...mapGetters(["userInfo", "getToken"]),
  },
  methods: {
    getData() {
      this.loading = true;
      axios
        .get(
          `http://localhost:8000/api/attendance/overview/${this.month}/${this.year}`
        )
        .then((response) => {
          this.periods = [];
          let data = response.data;
          for (let i = 0; i < data.periods.length; i++) {
            this.periods.push(moment(data.periods[i]).format("DD"));
          }

          this.employees = data.employees;
          this.attendance = data.attendance;
          console.log(this.attendance);
          this.total = data.length;
          this.loading = false;
        })
        .catch((e) => {
          console.log(e);
        });
      this.years = [];
      for (let i = 5; i >= 0; i--) {
        this.years.push(moment().subtract(i, "years").format("YYYY"));
      }

      console.log(this.years);
    },
    condition(attendance) {
      let classes = ["base-class"];

      if (attendance !== "absent") {
        classes.push("text-success fa-solid fa-circle-check");
      } else {
        classes.push("text-danger fa-solid fa-circle-xmark");
      }

      return classes.join(" ");
    },
  },

  mounted() {
    this.message = this.$route.query.message;
    this.getData();
  },
};
</script>
<style>
.v-pagination__list {
  margin-bottom: 0;
}
</style>
