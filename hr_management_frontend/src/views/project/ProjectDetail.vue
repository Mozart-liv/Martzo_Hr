<template>
  <div>
    <Header></Header>
    <div class="col-md-10 mx-auto p-3 my-15">
      <div class="mx-auto mb-3" onclick="history.back()">
        <v-icon>mdi-arrow-left-top</v-icon>Back
      </div>
      <div class="d-flex mb-5 justify-content-between">
        <v-card class="col-8 me-5 p-4" elevation="3">
          <h2 class="mb-10">{{ project.title }}</h2>
          <div class="mb-3">
            <b>Start Date: </b>
            <span class="text-muted">{{ project.start_date }} , </span>
            <b>Deadline: </b>
            <span class="text-muted">{{ project.deadline }}</span>
          </div>
          <div class="mb-5">
            <b>Priority : </b>
            <v-chip
              :color="
                project.priority == 'low'
                  ? 'green'
                  : project.priority == 'medium'
                  ? 'orange'
                  : 'red'
              "
              :text="project.priority"
              class="text-uppercase me-3"
              label
              size="small"
            ></v-chip>

            <b>Status : </b>
            <v-chip
              :color="
                project.status == 'pending'
                  ? 'orange'
                  : project.status == 'in_progress'
                  ? 'blue'
                  : 'green'
              "
              :text="project.status"
              class="text-uppercase me-3"
              label
              size="small"
            ></v-chip>
          </div>

          <h5 class="mt-10">Description</h5>
          <p>{{ project.description }}</p>
        </v-card>
        <div class="col-4">
          <v-card class="p-3 mb-3" elevation="3">
            <h5 class="mb-3">Leader</h5>
            <v-avatar size="55">
              <v-img alt="leader" :src="team.leader"></v-img>
            </v-avatar>
          </v-card>

          <v-card class="p-3" elevation="3">
            <h5 class="mb-5">Members</h5>
            <span
              v-for="(member, index) in team.members"
              :key="index"
              class="me-3 image-container"
            >
              <v-avatar :image="member.img" size="55"> </v-avatar>

              <span
                class="badge rounded-circle badge-dark delete-button"
                @click="removeMember(member.id)"
                v-if="userInfo.id == leader_id"
                ><i class="fa-solid fa-xmark"></i
              ></span>
            </span>
          </v-card>
        </div>
      </div>
      <div class="col-md-8">
        <v-card class="p-4 mb-5" elevation="3">
          <h4 class="mb-5">Files</h4>
          <p class="text-danger text-center" v-if="files.length == 0">
            No Data Yet
          </p>
          <div
            v-for="(file, index) in files"
            :key="index"
            class="me-5 image-container"
          >
            <a
              :href="`http://localhost:8000/project/files/` + file"
              target="_blank"
              class="text-center"
              ><span class="card p-2 border">
                <i class="fa-regular fa-file-pdf fs-1"></i>
              </span>
              <span class="text-center text-dark">File {{ index + 1 }}</span></a
            >
            <span
              class="badge rounded-circle badge-dark delete-button"
              @click="removeitem(file, 'file')"
              v-if="userInfo.id == leader_id"
              ><i class="fa-solid fa-xmark"></i
            ></span>
          </div>
        </v-card>

        <v-card class="p-4" elevation="3">
          <h4 class="mb-5">Images</h4>
          <p class="text-danger text-center" v-if="!images">No Data Yet</p>
          <div
            class="me-5 image-container"
            v-for="(img, index) in images"
            :key="index"
            v-viewer
          >
            <img
              :src="`http://localhost:8000/project/images/` + img"
              width="100"
              alt=""
            />
            <span
              class="badge rounded-circle badge-dark delete-button"
              @click="removeitem(img, 'img')"
              v-if="userInfo.id == leader_id"
              ><i class="fa-solid fa-xmark"></i
            ></span>
          </div>
        </v-card>
      </div>
      <div class="row mt-5">
        <div class="col-md-4 mb-1">
          <div class="card">
            <div class="card-header bg-warning">
              <i class="fa-solid fa-bars"></i> Pending
            </div>
            <div class="card-body alert-warning">
              <div class="item mb-2 bg-white p-3 rounded">
                <div class="d-flex mb-2 justify-content-between">
                  <h5 class="text-dark">Title</h5>
                  <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                </div>

                <div class="d-flex justify-content-between align-bottom">
                  <div class="col-md-9">
                    <div class="">
                      <i class="fa-regular fa-clock"></i>
                      Deadline : 23-4-2023
                    </div>
                    <v-chip
                      :color="
                        project.priority == 'low'
                          ? 'green'
                          : project.priority == 'medium'
                          ? 'orange'
                          : 'red'
                      "
                      :text="project.priority"
                      class="text-uppercase me-3"
                      label
                      size="small"
                    ></v-chip>
                  </div>
                  <div v-for="(member, index) in team.members" :key="index">
                    <v-avatar :image="member.img" size="x-small"> </v-avatar>
                  </div>
                </div>
              </div>

              <div
                class="btn bg-white mt-3 w-100"
                @click="openDialog('pending')"
              >
                <i class="fa-regular fa-square-plus me-2"></i> ADD Task
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-1">
          <div class="card">
            <div class="card-header bg-info">
              <i class="fa-solid fa-bars"></i> Pending
            </div>
            <div class="card-body alert-info">
              <div class="item mb-2 bg-white p-3 rounded">
                <div class="d-flex mb-2 justify-content-between">
                  <h5 class="text-dark">Title</h5>
                  <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                </div>

                <div class="d-flex justify-content-between align-bottom">
                  <div class="col-md-9">
                    <div class="">
                      <i class="fa-regular fa-clock"></i>
                      Deadline : 23-4-2023
                    </div>
                    <v-chip
                      :color="
                        project.priority == 'low'
                          ? 'green'
                          : project.priority == 'medium'
                          ? 'orange'
                          : 'red'
                      "
                      :text="project.priority"
                      class="text-uppercase me-3"
                      label
                      size="small"
                    ></v-chip>
                  </div>
                  <div v-for="(member, index) in team.members" :key="index">
                    <v-avatar :image="member.img" size="x-small"> </v-avatar>
                  </div>
                </div>
              </div>

              <div class="btn bg-white mt-3 w-100">
                <i class="fa-regular fa-square-plus me-2"></i> ADD Task
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-1">
          <div class="card">
            <div class="card-header bg-success">
              <i class="fa-solid fa-bars"></i> Pending
            </div>
            <div class="card-body alert-success">
              <div class="item mb-2 bg-white p-3 rounded">
                <div class="d-flex mb-2 justify-content-between">
                  <h5 class="text-dark">Title</h5>
                  <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                </div>

                <div class="d-flex justify-content-between align-bottom">
                  <div class="col-md-9">
                    <div class="">
                      <i class="fa-regular fa-clock"></i>
                      Deadline : 23-4-2023
                    </div>
                    <v-chip
                      :color="
                        project.priority == 'low'
                          ? 'green'
                          : project.priority == 'medium'
                          ? 'orange'
                          : 'red'
                      "
                      :text="project.priority"
                      class="text-uppercase me-3"
                      label
                      size="small"
                    ></v-chip>
                  </div>
                  <div v-for="(member, index) in team.members" :key="index">
                    <v-avatar :image="member.img" size="x-small"> </v-avatar>
                  </div>
                </div>
              </div>

              <div class="item mb-2 bg-white p-3 rounded">
                <div class="d-flex mb-2 justify-content-between">
                  <h5 class="text-dark">Title</h5>
                  <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                </div>

                <div class="d-flex justify-content-between align-bottom">
                  <div class="col-md-9">
                    <div class="">
                      <i class="fa-regular fa-clock"></i>
                      Deadline : 23-4-2023
                    </div>
                    <v-chip
                      :color="
                        project.priority == 'low'
                          ? 'green'
                          : project.priority == 'medium'
                          ? 'orange'
                          : 'red'
                      "
                      :text="project.priority"
                      class="text-uppercase me-3"
                      label
                      size="small"
                    ></v-chip>
                  </div>
                  <div v-for="(member, index) in team.members" :key="index">
                    <v-avatar :image="member.img" size="x-small"> </v-avatar>
                  </div>
                </div>
              </div>

              <div class="item mb-2 bg-white p-3 rounded">
                <div class="d-flex mb-2 justify-content-between">
                  <h5 class="text-dark">Title</h5>
                  <i class="fa-solid fa-ellipsis-vertical text-dark"></i>
                </div>

                <div class="d-flex justify-content-between align-bottom">
                  <div class="col-md-9">
                    <div class="">
                      <i class="fa-regular fa-clock"></i>
                      Deadline : 23-4-2023
                    </div>
                    <v-chip
                      :color="
                        project.priority == 'low'
                          ? 'green'
                          : project.priority == 'medium'
                          ? 'orange'
                          : 'red'
                      "
                      :text="project.priority"
                      class="text-uppercase me-3"
                      label
                      size="small"
                    ></v-chip>
                  </div>
                  <div v-for="(member, index) in team.members" :key="index">
                    <v-avatar :image="member.img" size="x-small"> </v-avatar>
                  </div>
                </div>
              </div>

              <div class="btn bg-white mt-3 w-100">
                <i class="fa-regular fa-square-plus me-2"></i> ADD Task
              </div>
            </div>
          </div>
        </div>
      </div>

      <v-dialog v-if="dialogVisible" v-model="dialogVisible">
        <form action="" class="card col-8 mx-auto p-3">
          <div class="row">
            <div class="col-6">
              <div class="form-gorup mb-4">
                <label class="form-label">Title</label>
                <input
                  type="text"
                  v-model="task.title"
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
                  v-model="task.desc"
                  class="form-control form-control-lg"
                  :class="errors.desc ? 'is-invalid' : ''"
                />
                <div v-if="errors && errors.desc" class="text-danger">
                  {{ errors.desc[0] }}
                </div>
              </div>

              <div class="form-group mb-4">
                <label class="form-label">Members</label>
                <select
                  class="select form-control form-control-lg"
                  :class="errors.members ? 'is-invalid' : ''"
                  v-model="task.members"
                  multiple
                >
                  <option disabled>members</option>
                  <option
                    v-for="(member, index) in team.members"
                    :key="index"
                    :value="member.id"
                  >
                    {{ member.name }}
                  </option>
                </select>
                <div v-if="errors && errors.members" class="text-danger">
                  {{ errors.members[0] }}
                </div>
              </div>
            </div>

            <div class="col-6">
              <div class="form-group mb-4">
                <label class="form-label">Start Date</label>
                <input
                  type="date"
                  v-model="task.start_date"
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
                  v-model="task.deadline"
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
                  v-model="task.priority"
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
            </div>
          </div>

          <div class="d-flex justify-content-end my-3">
            <button
              type="button"
              class="btn btn-primary text-white me-3"
              @click="addTask()"
            >
              ADD
            </button>
            <button
              type="button"
              class="btn btn-secondary text-dark"
              @click="closeDialog()"
            >
              Close
            </button>
          </div>
        </form>
      </v-dialog>
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
  name: "ProjectDetail",
  components: {
    Header,
    Footer,
  },
  computed: {
    ...mapGetters(["userInfo", "getToken"]),
  },
  data() {
    return {
      id: "",
      project: {},
      images: [],
      files: [],
      team: {},
      task: {
        title: "",
        desc: "",
        members: [],
        start_date: "",
        deadline: "",
        priority: "",
        status: "",
      },
      leader_id: "",
      errors: [],
      dialogVisible: false,
    };
  },
  methods: {
    getData(id) {
      axios
        .get("http://localhost:8000/api/project/detail/" + id)
        .then((response) => {
          let data = response.data;
          this.project = data.project;

          let images = JSON.parse(data.project.images);
          this.images = images;
          let files = JSON.parse(data.project.files);
          this.files = files;
          this.team.members = [];
          for (let i = 0; i < data.teamMembers.length; i++) {
            if (data.teamMembers[i].img == null) {
              data.teamMembers[i].img =
                "http://localhost:8000/image/default.jpg";
            } else {
              data.teamMembers[i].img =
                "http://localhost:8000/image/" + data.teamMembers[i].img;
            }

            if (data.teamMembers[i].role == "leader") {
              this.team.leader = "";
              this.team.leader = data.teamMembers[i].img;
              this.leader_id = data.teamMembers[i].user_id;
            }
            if (data.teamMembers[i].role == "member") {
              this.team.members.push(data.teamMembers[i]);
            }
          }

          console.log(this.teamMembersData);
        })
        .catch((e) => {
          console.log(e);
        });
    },
    removeMember(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "Remove this member from project?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .get("http://localhost:8000/api/project/member/delete/" + id)
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Deleted!",
                text: response.data,
                icon: "success",
              });
              this.getData(this.id);
            })
            .catch((e) => {
              console.log(e);
            });
        }
      });
    },
    removeitem(item, type) {
      Swal.fire({
        title: "Are you sure?",
        text: "Remove this item from project?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .get(
              `http://localhost:8000/api/project/item/delete/${this.id}/${item}/${type}`
            )
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Deleted!",
                text: response.data,
                icon: "success",
              });
              this.getData(this.id);
            })
            .catch((e) => {
              console.log(e);
            });
        }
      });
    },
    openDialog(status) {
      this.task.status = status;
      this.dialogVisible = true;
    },
    closeDialog() {
      // Set dialogVisible to false to close the dialog
      this.dialogVisible = false;
      // Clear form fields
      this.task = {};
    },
  },
  mounted() {
    this.id = this.$route.query.id;
    this.getData(this.id);
  },
};
</script>

<style scoped>
p {
  margin-bottom: 0;
}

.image-container {
  position: relative;
  display: inline-block;
}

.box {
  padding: 0 15px;
}

.delete-button {
  position: absolute;
  top: -10px;
  right: -10px;
  color: rgb(0, 0, 0);
}
</style>
