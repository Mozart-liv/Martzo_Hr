<template>
  <div>
    <Header title="Payroll"></Header>
    <div class="col-md-9 my-15 mx-auto p-3">
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
              <div class="me-3 col-4">
                <select v-model="month" class="form-select" @change="getData()">
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
                    <th class="text-center">Role</th>
                    <th class="text-center">Days of Month</th>
                    <th class="text-center">Working Days</th>
                    <th class="text-center">Off Days</th>
                    <th class="text-center">Present days</th>
                    <th class="text-center">Absent Days</th>
                    <th class="text-center">Per Day(MMK)</th>
                    <th class="text-center">Total(MMK)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(employee, index) in employees" :key="index">
                    <td class="text-center">{{ employee.name }}</td>
                    <td class="text-center">{{ employee.role }}</td>
                    <td class="text-center">{{ periods.length }}</td>
                    <td class="text-center">{{ workingDays }}</td>
                    <td class="text-center">
                      {{ periods.length - workingDays }}
                    </td>
                    <td class="text-center">
                      {{ attendance[index][0].length }}
                    </td>
                    <td class="text-center">
                      {{
                        attendance[index][1].length -
                        (periods.length - workingDays)
                      }}
                    </td>
                    <td class="text-center">
                      {{ salary(employee.id, salaries, "perDay") }}
                    </td>
                    <td class="text-center">
                      {{
                        salary(
                          employee.id,
                          salaries,
                          attendance[index][0].length
                        )
                      }}
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
import Header from "./AppHeader.vue";
import Footer from "./FooterPage.vue";
import moment from "moment";

export default {
  name: "PayrollPage",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      periods: [],
      employees: [],
      attendance: [],
      workingDays: "",
      salaries: [],
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
        .get(`http://localhost:8000/api/payroll/${this.month}/${this.year}`)
        .then((response) => {
          this.periods = [];
          let data = response.data;
          this.periods = data.periods;
          this.salaries = data.salaries;
          this.workingDays = data.workingDays;
          this.employees = data.employees;
          this.attendance = data.attendance;
          console.log(this.attendance);
          this.total = data.length;
        })
        .catch((e) => {
          console.log(e);
        });
      this.years = [];
      for (let i = 5; i >= 0; i--) {
        this.years.push(moment().subtract(i, "years").format("YYYY"));
      }
    },
    salary(employee, salaries, status) {
      console.log(employee);
      if (salaries) {
        for (let i = 0; i < salaries.length; i++) {
          if (employee === salaries[i].user_id) {
            if (status == "perDay") {
              return Number(
                salaries[i].amount / this.workingDays
              ).toLocaleString();
            } else {
              return Number(
                (salaries[i].amount / this.workingDays) * status
              ).toLocaleString();
            }
          }
        }
      }
    },
  },

  mounted() {
    this.getData();
  },
};
</script>
<style>
.v-pagination__list {
  margin-bottom: 0;
}
</style>
