<template>
  <div>
    <Header></Header>
    <div class="col-md-9 my-5 mx-auto">
      <button class="btn btn-primary" @click="goCreate()">
        <i class="fa-regular fa-square-plus"></i>
        Create Employee
      </button>
      <div class="card mt-3">
        <div class="card-body p-4">
          <v-row>
            <v-col md="3">
              <v-text-field
                v-model="search"
               append-icon="mdi-magnify"
                density="compact"
                label="Search"
                single-line
                flat
                hide-details
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-data-table
                :headers="headers"
                :items="items"
				:items-length="totalItems"
                :search="search"
                :items-per-page="itemsPerPage"
                class="p-3 elevation-1"
                :loading="loading"
                @update:options="getData"
              >
				<!-- show img column  -->
				<template v-slot:[`item.img`]="{ item }">
					<v-card class="my-2" elevation="2" rounded>
					<v-img
						:src="item.img"
						cover
					></v-img>
					</v-card>
				</template>
				<!-- is_present column  -->
              <template v-slot:[`item.is_present`]="{ item }">
                <div class="text-center">
                  <v-chip
                    :color="item.is_present == 1 ? 'green' : 'red'"
                    :text="item.is_present == 1 ? 'Present' : 'Leave'"
                    class="text-uppercase"
                    label
                    size="small"
                  ></v-chip>
                </div>
              </template>

				<!-- action buttons  -->
              <template v-slot:[`item.actions`]="{item}">
				<v-icon small @click="updatePage(item.id)" class="me-3 text-primary">mdi-information-outline</v-icon>
                <v-icon small @click="updatePage(item.id)" class="me-3">mdi-pencil</v-icon>
                <v-icon small @click="updatePage(item.id)" class="me-3 text-danger">mdi-delete</v-icon>
              </template>
              </v-data-table>
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
import Swal from "sweetalert2";
export default {
  name: "EmployeePage",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      message: "",
      search: "",
      headers: [
		{ title: "Profile", value: "img" },
        { title: "Employee_id", value: "employee_id" },
        { title: "Name", value: "name" },
        { title: "Email", value: "email" },
        { title: "Role", value: "role" },
        { title: "Department", value: "department_name" },
        { title: "Is present", value: "is_present" },
        { title: "Actions", value: "actions" , sortable: false},
      ],
      items: [],
      loading: "",
		itemsPerPage:5,
		total:0
    };
  },
  computed: {
    ...mapGetters(["userInfo", "loginStatus"]),
  },
  methods: {
    getData() {
      this.loading = true;
      axios
        .post("http://localhost:8000/api/employeeList", this.userInfo)
        .then((response) => {
			let data = response.data.employeeData
          console.log(data);
		for(let i=0; i<data.length; i++){
			if(data[i].img == null){
				data[i].img = "http://localhost:8000/image/default.jpg"
			}else{
				data[i].img = "http://localhost:8000/image/" + data[i].img
			}
		}
          this.items = data;
		this.total = data.length;
          this.loading = false;
        })
        .catch((e) => {
          console.log(e);
        });
    },
    goCreate() {
      this.$router.push({
        name: "create#employee",
      });
    },
    messageAlert(mes) {
      if (mes !== undefined && mes !== "" && mes !== null) {
        Swal.fire({
          title: "success!",
          text: mes,
          icon: "success",
        });
      }
      this.message = "";
    },
    updatePage(id){
       this.$router.push({
        name: 'update#employee',
        query: {
            id: id
        }
       })
    }
  },

  mounted() {
    this.message = this.$route.query.message;
    this.getData();
    this.messageAlert(this.message);
  },
};
</script>
<style >
.v-pagination__list{
	margin-bottom: 0;
}
</style>