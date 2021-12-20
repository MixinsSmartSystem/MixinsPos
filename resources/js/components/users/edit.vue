

<template>
  <div>
    <div v-if="hasRole" class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card mb-4">
          <form @submit.prevent="update">
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
                تحديث بيانات المستخدم
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span id="basic-addon1" class="input-group-text"
                    >اسم المستخدم</span
                  >
                </div>
                <input
                  aria-describedby="basic-addon1"
                  aria-label="اسم المستخدم"
                  class="form-control"
                  v-model="form.name"
                  placeholder="اسم المستخدم"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">البريد الاليكتروني </span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="البريد الاليكتروني "
                  class="form-control"
                  placeholder="البريد الاليكتروني "
                  v-model="form.email"
                  type="text"
                />
              </div>
              <div class="input-group mb-3 d-none">
                <div class="input-group-append">
                  <span class="input-group-text">كلمة المرور </span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="كلمة المرور "
                  class="form-control"
                  placeholder="كلمة المرور "
                  v-model="form.password"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="custom-control custom-switch">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="bill_type"
                    v-model="form.is_user"
                  />
                  <label class="custom-control-label" for="bill_type"
                    >مستخدم مدير</label
                  >
                </div>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span id="basic-addon2" class="input-group-text"
                    >هاتف المستخدم</span
                  >
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="هاتف المستخدم"
                  class="form-control"
                  placeholder="هاتف المستخدم"
                  v-model="form.mobile"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">راتب المستخدم</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="راتب المستخدم"
                  class="form-control"
                  placeholder="راتب المستخدم"
                  v-model="form.salary"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"> الوظيفة </span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="الوظيفة "
                  class="form-control"
                  placeholder="الوظيفة "
                  v-model="form.jop_title"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">عدد ساعات العمل</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="عدد ساعات العمل "
                  class="form-control"
                  placeholder="عدد ساعات العمل "
                  v-model="form.work_hour_count"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"> سعر ساعة العمل</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="سعر ساعة العمل "
                  class="form-control"
                  placeholder="سعر ساعة العمل "
                  v-model="form.hour_price"
                  type="text"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <Security v-else></Security>
  </div>
</template>



<script type="text/javascript">
import Security from "../spinner/security";
import Spinner from "../spinner/mixinsSpinner";

export default {
  components: { Security, Spinner },

  created() {
    if (!User.loggedIn()) {
      Notification.navigationAlert();
      this.$router.push({ name: "/" });
    }
    let id = this.$route.params.id;
    axios
      .get("/api/users/" + id)
      .then(({ data }) => (this.form = data))
      .catch((err) => console.log(err));
  },

  data() {
    return {
      hasRole: this.$root.$data.roles.includes(16),
      form: {
        name: "",
        mobile: "",
        work_hour_count: 8,
        password: "",
        hour_price: 0,
        jop_title: "",
        salary: 0,
        email: "",
        is_user: false,
      },

      errors: {},
    };
  },

  methods: {
    update() {
      let id = this.$route.params.id;
      axios
        .patch("/api/users/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "users" });
          Notification.success();
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
        .then((e) => {
          if (this.errors.name)
            Notification.customMsg("error", "topRight", this.errors.name[0]);
          if (this.errors.email)
            Notification.customMsg("error", "topRight", this.errors.email[0]);
        });
    },
  },
};
</script>


<style type="text/css">
</style>
