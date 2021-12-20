<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card mb-4">
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
                ادخال بيانات المورد
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span id="basic-addon1" class="input-group-text"
                    >اسم المورد</span
                  >
                </div>
                <input
                  aria-describedby="basic-addon1"
                  aria-label="اسم المورد"
                  class="form-control"
                  v-model="form.supplier_name"
                  placeholder="اسم المورد"
                  type="text"
                />
                <small
                  class="text-danger errorMsg d-none"
                  v-if="errors.supplier_name"
                >
                  {{ errors.supplier_name[0] }}
                </small>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span id="basic-addon2" class="input-group-text"
                    >هاتف المورد</span
                  >
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="هاتف المورد"
                  class="form-control"
                  placeholder="هاتف المورد"
                  v-model="form.supplier_mobile"
                  type="text"
                />
                <small
                  class="text-danger errorMsg d-none"
                  v-if="errors.supplier_mobile"
                >
                  {{ errors.supplier_mobile[0] }}
                </small>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
  },
  data() {
    return {
      form: {
        supplier_name: null,
        supplier_mobile: null,
      },
      errors: {},
    };
  },

  methods: {
    async create() {
      axios
        .post("/api/suppliers", this.form)
        .then(() => {
          this.$router.push({ name: "suppliers" });
          Notification.success();
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
        .then((e) => {
          if (this.errors.supplier_name)
            Notification.customMsg(
              "error",
              "topRight",
              this.errors.supplier_name[0]
            );
          if (this.errors.supplier_mobile)
            Notification.customMsg(
              "error",
              "topRight",
              this.errors.supplier_mobile[0]
            );
        });
    },
  },
};
</script>
