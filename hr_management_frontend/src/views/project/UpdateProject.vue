<template>
  <div>
    <Header></Header>
    <div class="container">
      <div class="card my-15">
        <div class="card-body p-5">
          <h1 class="mb-5 text-primary">Update Employee</h1>
          <form class="text-start row">
            <div class="form-gorup mb-4">
              <label class="form-label">Title</label>
              <input
                type="text"
                v-model="project.title"
                class="form-control form-control-lg"
                :class="errors.title ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.title" class="text-danger">
                {{ errors.title[0] }}
              </div>
            </div>

            <div class="form-gorup mb-4">
              <label class="form-label">Description</label>
              <input
                type="text"
                v-model="project.description"
                class="form-control form-control-lg"
                :class="errors.desc ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.desc" class="text-danger">
                {{ errors.desc[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Image</label>
              <input
                placeholder="add images"
                type="file"
                @change="imgInput"
                ref="imgInput"
                class="form-control form-control-lg"
                :class="errors.img ? 'is-invalid' : ''"
                multiple
              />
              <div v-if="errors && errors.img" class="text-danger">
                {{ errors.img }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">File</label>
              <input
                placeholder="add files"
                type="file"
                @change="fileInput"
                ref="fileInput"
                class="form-control form-control-lg"
                :class="errors.files ? 'is-invalid' : ''"
                multiple
              />
              <div v-if="errors && errors.files" class="text-danger">
                {{ errors.files }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Start Date</label>
              <input
                type="date"
                v-model="project.start_date"
                class="form-control form-control-lg"
                :class="errors.start_date ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.start_date" class="text-danger">
                {{ errors.start_date[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Deadline</label>
              <input
                type="date"
                v-model="project.deadline"
                class="form-control form-control-lg"
                :class="errors.deadline ? 'is-invalid' : ''"
              />
              <div v-if="errors && errors.deadline" class="text-danger">
                {{ errors.deadline[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Priority</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.priority ? 'is-invalid' : ''"
                v-model="project.priority"
              >
                <option disabled>Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
              <div v-if="errors && errors.priority" class="text-danger">
                {{ errors.priority[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Status</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.status ? 'is-invalid' : ''"
                v-model="project.status"
              >
                <option disabled>status</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In progress</option>
                <option value="done">Done</option>
              </select>
              <div v-if="errors && errors.status" class="text-danger">
                {{ errors.status[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Leader</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.leader ? 'is-invalid' : ''"
                v-model="leader"
              >
                <option disabled>leader</option>
                <option
                  v-for="(employee, index) in employeeData"
                  :key="index"
                  :value="employee.id"
                >
                  {{ employee.name }}
                </option>
              </select>
              <div v-if="errors && errors.leader" class="text-danger">
                {{ errors.leader[0] }}
              </div>
            </div>

            <div class="form-group mb-4">
              <label class="form-label">Members</label>
              <select
                class="select form-control form-control-lg"
                :class="errors.members ? 'is-invalid' : ''"
                v-model="members"
                multiple
              >
                <option disabled>members</option>
                <option
                  v-for="(employee, index) in employeeData"
                  :key="index"
                  :value="employee.id"
                >
                  {{ employee.name }}
                </option>
              </select>
              <div v-if="errors && errors.members" class="text-danger">
                {{ errors.members[0] }}
              </div>
            </div>
            <div class="d-flex justify-content-center my-3">
              <button
                type="button"
                class="btn btn-primary text-white btn-block btn-lg"
                @click="UpdateEmployee()"
              >
                Update
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
  name: "UpdateProject",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      id: "",
      project: {},
      leader: "",
      members: [],
      employeeData: [],
      imgs: null,
      files: null,
      priorityValues: ["low", "medium", "height"],
      errors: {},
    };
  },
  methods: {
    getformData() {
      axios.get("http://localhost:8000/api/employeeList").then((response) => {
        this.employeeData = response.data.employeeData;
      });
    },
    getOldData(id) {
      axios
        .get("http://localhost:8000/api/project/update/" + id)
        .then((response) => {
          console.log(response);
          this.project = response.data.project;
          for (let i = 0; i < response.data.pjMembers.length; i++) {
            if (response.data.pjMembers[i].role == "leader") {
              this.leader = response.data.pjMembers[i].user_id;
            } else {
              this.members.push(response.data.pjMembers[i].user_id);
            }
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
    imgInput() {
      let files = this.$refs.imgInput.files;
      console.log(files);
      for (let i = 0; i < files.length; i++) {
        let file = files[i];
        let allow = ["image/jpeg", "image/png", "image/jpg"];

        if (!allow.includes(file.type)) {
          this.errors.img =
            "Invalid file type. Only jpeg, png, and jpg are allowed.";
        } else {
          this.errors.img = null;
          this.imgs= [];
          this.imgs= files;
        }
      }

      console.log(this.project.images.length);
    },

    fileInput() {
      let files = this.$refs.fileInput.files;
      console.log(files);
      for (let i = 0; i < files.length; i++) {
        let file = files[i];
        let allow = ["image/jpeg", "image/png", "image/jpg"];

        if (allow.includes(file.type)) {
          this.errors.files =
            "Invalid file type.jpeg, png, and jpg are do not allowed.";
        } else if (file.size > 5000000) {
          this.errors.files = "File size too large. Maximum size is 500KB.";
        } else {
          this.errors.files = null;
          this.files = [];
          this.files = files;
        }
      }
    },
    UpdateEmployee() {
      const form = new FormData();
      form.append("id", this.project.id);
      form.append("title", this.project.title);
      form.append("description", this.project.description);
      form.append("leader", this.leader);
      for (let i = 0; i < this.members.length; i++) {
        form.append(`members[${i}]`, this.members[i]);
      }
      form.append("start_date", this.project.start_date);
      form.append("deadline", this.project.deadline);
      if (this.imgs !== null) {
        for (let i = 0; i < this.imgs.length; i++) {
          form.append(`images[${i}]`, this.imgs[i]);
        }
      }
      if (this.files !== null) {
        for (let i = 0; i < this.files.length; i++) {
          form.append(`files[${i}]`, this.files[i]);
        }
      }

      form.append("priority", this.project.priority);
      form.append("status", this.project.status);
      axios
        .post("http://localhost:8000/api/project/update", form)
        .then((response) => {
          if (response.data.status == true) {
            this.$router.push({
              name: "project",
              query: {
                message: response.data.message,
              },
            });
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
    this.getformData();
    this.getOldData(this.id);
  },
};
</script>

<style lang="stylus" scoped></style>
