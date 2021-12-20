<template>
  <div>
    <div v-if="hasRole" class="row justify-content-center">
      <div class="col-md-8">
        <div class="card mb-4">
          <form class="user" @submit.prevent="create">
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
                ادخل بيانات العميل
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">اسم العميل</span>
                </div>
                <input
                  aria-label="اسم العميل"
                  class="form-control"
                  v-model="form.cust_name"
                  placeholder="اسم العميل"
                  type="text"
                />
                <div class="input-group-prepend">
                  <span class="input-group-text">عنوان العميل</span>
                </div>
                <input
                  aria-label="عنوان العميل"
                  class="form-control"
                  v-model="form.cust_address"
                  placeholder="عنوان العميل"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">هاتف العميل</span>
                </div>
                <input
                  aria-label="هاتف العميل"
                  class="form-control"
                  placeholder="هاتف العميل"
                  v-model="form.cust_mobile"
                  type="text"
                />
                <div class="input-group-append">
                  <span class="input-group-text">رصيد العميل</span>
                </div>
                <input
                  aria-label="رصيد العميل"
                  class="form-control"
                  readonly
                  placeholder="رصيد العميل"
                  v-model="form.cust_balance"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">قيمة خصم العميل</span>
                </div>
                <input
                  aria-label="قيمة خصم العميل"
                  class="form-control"
                  :readonly="form.cust_discount_percent > 0"
                  placeholder="قيمة خصم العميل"
                  v-model="form.cust_discount_val"
                  type="text"
                />
                <div class="input-group-append">
                  <span class="input-group-text">نسبة خصم العميل</span>
                </div>
                <input
                  aria-label="نسبة خصم العميل"
                  class="form-control"
                  :readonly="form.cust_discount_val > 0"
                  placeholder="نسبة خصم العميل"
                  v-model="form.cust_discount_percent"
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

<script>
import Security from "../spinner/security";
import Spinner from "../spinner/mixinsSpinner";

export default {
  components: { Security, Spinner },

  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(10),

      form: {
        cust_name: null,
        cust_address: null,
        cust_discount_val: null,
        cust_discount_percent: null,
        cust_mobile: null,
        cust_balance: 0,
      },
      errors: {},
    };
  },

  methods: {
    create() {
      axios
        .post("/api/customers", this.form)
        .then(() => {
          this.$router.push({ name: "customers" });
          Notification.success();
        }).catch((error) => {
          this.errors = error.response.data.errors;
        })
        .then((error) => {
            if (this.errors.cust_name)
            Notification.customMsg("error", "topRight", this.errors.cust_name[0]);
          if (this.errors.cust_mobile)
            Notification.customMsg("error", "topRight", this.errors.cust_mobile[0]);
        });
    },
  },
};
</script>
