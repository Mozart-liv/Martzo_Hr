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
                  ? 'gray'
                  : project.status == 'in_progress'
                  ? 'orange'
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
              class="me-3"
            >
              <v-badge
                color="dark"
                content="&#10006;"
                @click="removeMember(member.id)"
              >
                <v-avatar :image="member.img" size="55"> </v-avatar>
              </v-badge>
            </span>
          </v-card>
        </div>
      </div>
      <div class="col-md-8">
        <v-card class="p-4 mb-5" elevation="3">
          <h4 class="mb-5">Files</h4>
          <p class="text-danger text-center" v-if="files.length == 0">No Data Yet</p>
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
              ><i class="fa-solid fa-xmark"></i
            ></span>
          </div>
        </v-card>
        <v-card elevation="3"></v-card>
      </div>
    </div>
    <Footer></Footer>
  </div>
</template>

<script>
import axios from "axios";
import Header from "../AppHeader.vue";
import Footer from "../FooterPage.vue";
import Swal from "sweetalert2";
export default {
  name: "ProjectDetail",
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      id: "",
      project: {},
      images: [],
      files: [],
      team: {},
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
            }
            if (data.teamMembers[i].role == "member") {
              this.team.members.push(data.teamMembers[i]);
            }
          }

          console.log(this.files);
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

.delete-button {
  position: absolute;
  top: -10px;
  right: -10px;
  color: rgb(0, 0, 0);
}
</style>
