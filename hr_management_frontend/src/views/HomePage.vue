<template>
  <div>
    <Header></Header>
    <h1 v-if="!login">Login please</h1>
    <div v-else class="col-md-11 mx-auto p-3 my-15">
      <v-card class="mx-auto p-4 col-md-8 mb-10" elevation="6">
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
      <v-card class="mx-auto p-5 col-md-11 mb-5" elevation="6">
        <h3>Records</h3>
        <v-row class="mb-5">
          <v-col class="d-flex justify-content-around">
            <div class="me-3 col-4">
              <select
                v-model="attendanceOverview.year"
                class="form-select"
                @change="getData()"
              >
                <option
                  v-for="(year, index) in attendanceOverview.years"
                  :key="index"
                >
                  {{ year }}
                </option>
              </select>
            </div>
            <div class="me-3 col-4">
              <select
                v-model="attendanceOverview.month"
                class="form-select"
                @change="getData()"
              >
                <option
                  :value="month.id"
                  v-for="(month, index) in attendanceOverview.months"
                  :key="index"
                >
                  {{ month.name }}
                </option>
              </select>
            </div>
          </v-col>
        </v-row>
        <v-row class="mb-5">
          <v-col>
            <v-table>
              <thead>
                <tr>
                  <th
                    v-for="(period, columnIndex) in attendanceOverview.periods"
                    :key="columnIndex"
                    :class="checkOffday(period)"
                  >
                    {{ getperiodDate(period) }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td
                    v-for="(period, columnIndex) in attendanceOverview.periods"
                    :key="columnIndex"
                    :class="checkOffday(period)"
                  >
                    <i
                      v-html="
                        condition(
                          attendanceOverview.attendance[columnIndex],
                          period
                        )
                      "
                    ></i>
                  </td>
                </tr>
              </tbody>
            </v-table>
          </v-col>
        </v-row>
        <v-row class="mb-3">
          <v-col>
            <v-data-table
              :headers="attendance.headers"
              :items="attendance.items"
              :items-length="attendance.total"
              :items-per-page="attendance.itemsPerPage"
              class="p-3 elevation-1"
              :loading="attendance.loading"
              @update:options="getData"
            >
              <!-- action buttons  -->
              <template v-slot:[`item.actions`]="{ item }">
                <v-icon small @click="deleteData(item.id)" class="text-danger"
                  >mdi-delete</v-icon
                >
              </template>
            </v-data-table>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-table>
              <thead>
                <tr>
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
                <tr>
                  <td class="text-center">
                    {{ attendanceOverview.periods.length }}
                  </td>
                  <td class="text-center">{{ payroll.workingDays }}</td>
                  <td class="text-center">
                    {{
                      attendanceOverview.periods.length - payroll.workingDays
                    }}
                  </td>
                  <td class="text-center">
                    {{ payroll.present }}
                  </td>
                  <td class="text-center">
                    {{
                      payroll.absent -
                      (attendanceOverview.periods.length - payroll.workingDays)
                    }}
                  </td>
                  <td class="text-center">
                      {{ salary(payroll.salaries, "perDay") }}
                    </td>
                    <td class="text-center">
                      {{
                        salary(
                          payroll.salaries,
                          payroll.present
                        )
                      }}
                    </td>
                </tr>
              </tbody>
            </v-table>
          </v-col>
        </v-row>
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
import moment from "moment";
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
      checkLable: "",
      data: {},
      attendance: {
        headers: [
          { title: "Date", value: "date" },
          { title: "Check in", value: "check_in" },
          { title: "Check out", value: "check_out" },
          { title: "Action", value: "actions" },
        ],
        items: [],
        loading: "",
        itemsPerPage: 3,
        total: 0,
      },
      attendanceOverview: {
        periods: [],
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
      },
      payroll: {
        workingDays: "",
        salaries: [],
        present: 0,
        absent: 0,
      },
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
            this.checkLable = "checkin";
          } else {
            this.check = false;
            this.checkLable = "checkout";
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
              text: response.data.mes,
            });
          } else {
            if (response.data.mes == "checkin") {
              this.checkLable = "checkin";
            } else {
              this.checkLable = "checkout";
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

      //get attendance overview
      this.attendanceOverview.loading = true;
      axios
        .get(
          `http://localhost:8000/api/records/${this.attendanceOverview.month}/${this.attendanceOverview.year}/${this.userInfo.id}`
        )
        .then((response) => {
          this.attendanceOverview.periods = [];
          let data = response.data;
          this.attendance.items = data.records;
          this.attendance.total = data.records.length;
          this.attendance.loading = false;
          this.attendanceOverview.periods = data.periods;
          this.attendanceOverview.attendance = data.attendance;

          this.attendanceOverview.total = data.length;
          this.attendanceOverview.loading = false;
          this.payroll.salaries = data.salaries;
          this.payroll.workingDays = data.workingDays;
          this.payroll.present = data.attendForPayroll[0].length;
          this.payroll.absent = data.attendForPayroll[1].length;
          console.log(this.payroll.salaries);
        })
        .catch((e) => {
          console.log(e);
        });
      this.attendanceOverview.years = [];
      for (let i = 5; i >= 0; i--) {
        this.attendanceOverview.years.push(
          moment().subtract(i, "years").format("YYYY")
        );
      }
    },
    condition(attendance, period) {
      if (moment(period).isBefore(moment())) {
        if (attendance !== "absent") {
          return `<i class="fa-solid fa-circle-check text-success"></i>`;
        } else {
          if (
            moment(period).format("ddd") !== "Sat" &&
            moment(period).format("ddd") !== "Sun"
          ) {
            return `<i class="fa-solid fa-circle-xmark text-danger"></i>`;
          }
        }
      }
    },
    getperiodDate(period) {
      return moment(period).format("DD");
    },
    checkOffday(period) {
      if (
        moment(period).format("ddd") == "Sat" ||
        moment(period).format("ddd") == "Sun"
      ) {
        return "alert-danger";
      }
    },
    deleteData(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .get("http://localhost:8000/api/attendance/delete/" + id)
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Deleted!",
                text: response.data,
                icon: "success",
              });
              this.getData();
            })
            .catch((e) => {
              console.log(e);
            });
        }
      });
    },
    salary(salaries, status) {
      if (salaries) {
            if (status == "perDay") {
              return Number(
                salaries.amount / this.payroll.workingDays
              ).toLocaleString();
            } else {
              return Number(
                (salaries.amount / this.payroll.workingDays) * status
              ).toLocaleString();
            }
      }
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
