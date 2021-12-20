<template>
  <div>
    <!-- Login Content -->
    <div v-if="!loading" class="container-login">
      <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
          <div class="card shadow-sm my-5">
            <div class="card-body p-0">
              <div class="row">
                <div class="col-lg-12">
                  <div class="login-form">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 mb-4">Login</h1>
                    </div>
                    <form class="user" @submit.prevent="login">
                      <div class="form-group">
                        <input
                          type="text"
                          class="form-control"
                          aria-describedby="emailHelp"
                          placeholder="Enter name"
                          v-model="form.name"
                        />
                        <small class="alert alert-danger" v-if="errors.name">{{
                          errors.name[0]
                        }}</small>
                      </div>
                      <div class="form-group">
                        <input
                          type="password"
                          class="form-control"
                          placeholder="Password"
                          v-model="form.password"
                        />
                        <small
                          class="alert alert-danger"
                          v-if="errors.password"
                          >{{ errors.password[0] }}</small
                        >
                      </div>

                      <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                          Login
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Login Content -->
    <MixinsSpinner v-else></MixinsSpinner>
  </div>
</template>

<script>
import MixinsSpinner from "../spinner/mixinsSpinner";

export default {
  components: { MixinsSpinner },
  created() {
    if (User.loggedIn()) {
      this.$router.push("home");
    }
  },
  data() {
    return {
      form: {
        name: null,
        password: null,
      },
      loading: false,
      errors: {},
    };
  },
  methods: {
    async login() {
      this.loading = true;

      await axios
        .post("api/auth/login", this.form)
        .then(async (response) => {
          User.responseAfterLogin(response);

          await location.reload(true);
          await this.$router.push({ name: "home" });
          await Toast.fire({
            icon: "success",
            title: "تم تسجيل الدخول بنجاح",
          });
          this.loading = false;
        })
        .catch((error) => {
          this.errors = error.response.data.error;
          console.log(error.response.data);
          this.loading = false;

          Toast.fire({
            icon: "warning",
            title: error.response.data.error,
          });
        });
    },
  },
};
</script>
