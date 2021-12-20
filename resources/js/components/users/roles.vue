<template>
  <div>
    <div v-if="hasRole" class="row justify-content-center">
      <div class="col-md-10 text-center">
        <div class="card mb-4" style="height: 90vh">
          <form @submit.prevent="create">
            <div
              class="
                card-header
                py-3
                d-flex
                flex-row
                align-items-center
                justify-content-between
              "
            >
              <h6 class="m-0 font-weight-bold text-primary">
                صلاحيات الممستخدم ({{ form.name }})
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="row justify-content-right" dir="rtl">
                <div class="col-4">
                  <div
                    class="
                      card-header
                      bg-success
                      py-3
                      d-flex
                      flex-row
                      align-items-center
                      justify-content-between
                    "
                  >
                    <h6 class="m-0 font-weight-bold text-light">
                      الصلاحيات المعطاه
                    </h6>
                  </div>
                  <ul
                    class="list-group w-100 h-50 bg-blue"
                    style="overflow: auto; min-height: 65vh"
                  >
                    <li
                      v-for="(role, index) in currentUserRoles"
                      :key="index"
                      class="list-group-item w-100 float-right mb-1"
                    >
                      <b class="float-right">{{ role.role.role_name }}</b>
                      <i
                        class="fa fa-times btn-sm btn-danger float-left"
                        @click="deleteAction(role.mixins_role)"
                      ></i>
                    </li>
                  </ul>
                </div>
                <div class="col-4">
                  <div
                    class="
                      card-header
                      bg-secondary
                      py-3
                      d-flex
                      flex-row
                      align-items-center
                      justify-content-between
                    "
                  >
                    <h6 class="m-0 font-weight-bold text-light w-100">
                      الصلاحيات الغير المعطاه
                    </h6>
                  </div>
                  <span class="alert-warning"
                    >اضغط على زر CTR لإختيار أكثر من صلاحية</span
                  >

                  <select
                    v-show="roles.length > 0"
                    v-model="userRoles"
                    class="w-100 h-50 bg-secondary"
                    style="min-height: 65vh; overflow: auto"
                    multiple
                  >
                    <option
                      class="list-group-item w-100 cursor-pointer mb-1"
                      style="padding: 0.5rem 1rem; cursor: pointer"
                      v-for="role in roles"
                      v-show="!checkIfRoleAdded(role)"
                      :value="role"
                    >
                      {{ role.role_name }}
                    </option>
                  </select>
                </div>
                <div class="col-4">
                  <div
                    class="
                      card-header
                      py-3
                      bg-warning
                      d-flex
                      flex-row
                      align-items-center
                      justify-content-between
                    "
                  >
                    <h6 class="m-0 font-weight-bold text-light">
                      الصلاحيات الجديدة
                    </h6>
                  </div>
                  <ul
                    class="list-group w-100 bg-gradient-warning h-50"
                    style="overflow: auto; min-height: 65vh"
                  >
                    <li
                      v-for="(role, index) in userRoles"
                      :key="index"
                      class="list-group-item w-100 mb-1"
                    >
                      <b class="float-right">{{ role.role_name }}</b>
                      <i
                        class="fa fa-times btn-sm btn-danger float-left"
                        @click="removeFromUserRole(role, index)"
                      ></i>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Security v-else></Security>
  </div>
</template>

<script>
import Security from "../spinner/security";
import Spinner from "../spinner/mixinsSpinner";

export default {
  components: { Security, Spinner },

  async created() {
    if (!User.loggedIn()) {
      await this.$router.push({ name: "/" });
    }

    let id = this.$route.params.id;
    await axios
      .get("/api/users/" + id)
      .then(({ data }) => (this.form = data))
      .catch((error) => console.log(error));
    await this.allRoles();
    await this.findRoleByUserId(id);
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(15),

      roles: [],
      form: {
        id: "",
        name: "",
        userRoles: [],
      },
      userRoles: [],
      currentUserRoles: [],
    };
  },
  methods: {
    allRoles() {
      axios
        .get("/api/roles")
        .then(({ data }) => {
          this.roles = data;
        })
        .catch((err) => console.log(err));
    },
    create() {
      this.form.userRoles = this.userRoles;

      axios
        .post("/api/user/roles/", this.form)
        .then(() => {
          this.$router.push({ name: "users" });
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    checkIfRoleAdded(role) {
      let hasRole = false;
      this.currentUserRoles.length > 0
        ? this.currentUserRoles.map((rol) => {
            if (rol.mixins_role == role.role_id) {
              hasRole = true;
              return;
            }
          })
        : (hasRole = false);
      if (this.userRoles.includes(role)) {
        hasRole = true;
      }
      return hasRole;
    },
    checkIfRoleExist(role) {
      let hasRole = false;
      if (this.currentUserRoles.indexOf(role.role_id)) {
        hasRole = true;
      }
      return hasRole;
    },
    removeFromUserRole(role, index) {
      if (this.userRoles.includes(role)) {
        this.$delete(this.userRoles, index);
      }
    },
    findRoleByUserId(id) {
      axios
        .get("/api/user/roles/" + id)
        .then(({ data }) => {
          this.currentUserRoles = data;
        })
        .catch((error) => console.log(error));
    },
    deleteAction(id) {
      axios
        .delete("/api/user/roles/" + id)
        .then(() => {
          this.currentUserRoles = this.currentUserRoles.filter((userRole) => {
            return userRole.mixins_role != id;
          });
        })
        .catch(() => {
          this.$router.push({ name: "add/roles/" + this.form.id });
        });
    },
  },
};
</script>

<style scoped>
.fa-times {
  cursor: pointer;
}
</style>
