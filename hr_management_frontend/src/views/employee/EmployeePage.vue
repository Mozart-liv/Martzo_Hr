<template>
  <div>
    <Header></Header>
    <div class="col-md-10 my-15 mx-auto p-3">
      <button class="btn btn-primary" @click="goCreate()">
        <i class="fa-regular fa-square-plus"></i>
        Create Employee
      </button>
      <div class="card mt-3">
        <div class="card-body p-4">
          <v-row>
            <v-col md="3" >
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
              <template v-slot:[`item.id`]="{item}">
				<v-icon small @click="detailPage(item.id)" class="me-1 text-primary">mdi-information-outline</v-icon>
                <v-icon small @click="updatePage(item.id)" class="me-1">mdi-pencil</v-icon>
                <v-icon small @click="deleteData(item.id)" v-if="userInfo.role_id == 1" class="me-1 text-danger">mdi-delete</v-icon>
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
        { title: "Actions", value: "id"},
      ],
      items: [],
      loading: "",
		itemsPerPage:5,
		total:0,
    };
  },
  computed: {
    ...mapGetters(["userInfo", "getToken"]),
  },
  methods: {
    getData() {
      this.loading = true;
      axios
        .get("http://localhost:8000/api/employeeList")
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
      this.$router.replace({'query': null});
    },
    updatePage(id){
       this.$router.push({
        name: 'update#employee',
        query: {
            id: id
        }
       })
    },
    detailPage(id){
      this.$router.push({
        name: 'employeeDetail',
        query: {
          id: id
        }
      })
    },
	deleteData(id){
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!"
		}).then((result) => {
			if (result.isConfirmed) {
				axios.get("http://localhost:8000/api/employee/delete/" + id).then((response)=>{
				console.log(response);
				Swal.fire({
				title: "Deleted!",
				text: response.data,
				icon: "success"
				});
				this.getData();
				
				}).catch((e)=>{
					console.log(e);
				})
				
			}
			
		});
		
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