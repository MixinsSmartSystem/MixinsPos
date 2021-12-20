<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-6">
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
                تحديث بيانات المورد
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
                  v-model="form.supplier_name"
                  aria-describedby="basic-addon1"
                  aria-label="اسم المورد"
                  class="form-control"
                  placeholder="اسم المورد"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">هاتف المورد</span>
                </div>
                <input
                  v-model="form.supplier_mobile"
                  aria-describedby="basic-addon2"
                  aria-label="هاتف المورد"
                  class="form-control"
                  placeholder="هاتف المورد"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">اجمالي المسحوبات </span>
                </div>
                <input
                  v-model="form.supplier_total_withdrawals"
                  aria-describedby="basic-addon2"
                  aria-label="اجمالي المسحوبات"
                  class="form-control"
                  readonly
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">اجمالي المدفوعات </span>
                </div>
                <input
                  v-model="form.supplier_total_paid"
                  aria-describedby="basic-addon2"
                  aria-label="اجمالي المدفوعات"
                  class="form-control"
                  placeholder="اجمالي المدفوعات"
                  readonly
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">اجمالي المتبقي</span>
                </div>
                <input
                  v-model="form.supplier_total_remain"
                  aria-describedby="basic-addon1"
                  aria-label="اجمالي المتبقي"
                  class="form-control"
                  placeholder="اجمالي المتبقي"
                  readonly
                  type="text"
                />
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4">
          <div
            class="
              card-header
              py-3
              d-flex
              flex-row
              align-items-center
              bg-secondary
              justify-content-between
            "
          >
            <h6 class="m-0 font-weight-bold text-primary">
              توريد نقدية للمورد
            </h6>
            <button class="btn btn-primary" type="button" @click="pay(form)">
              توريد
            </button>
          </div>
          <div class="card-body">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">اجمالي المتبقي</span>
              </div>
              <input
                v-model="form.supplier_total_remain"
                aria-describedby="basic-addon1"
                aria-label="اجمالي المتبقي"
                class="form-control"
                placeholder="اجمالي المتبقي"
                readonly
                type="text"
              />
            </div>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text">المبلغ</span>
              </div>
              <input
                v-model="supplier_pay"
                aria-describedby="basic-addon2"
                aria-label="المبلغ "
                class="form-control"
                placeholder="المبلغ "
                type="text"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script type="text/javascript">
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
    let id = this.$route.params.id;
    axios
      .get("/api/suppliers/" + id)
      .then(({ data }) => (this.form = data))
      .catch((err) => console.log(err));
  },

  data() {
    return {
      form: {
        supplier_name: "",
        supplier_mobile: "",
      },
      supplier_pay: "",
      errors: {},
    };
  },

  methods: {
    pay(supplier) {
      if (supplier.supplier_total_remain > 0) {
        if (this.supplier_pay > 0) {
          axios
            .get(
              "/api/supplierPay/" +
                supplier.supplier_id +
                "/" +
                this.supplier_pay
            )
            .then(() => {
              this.$router.push({ name: "suppliers" });
              Notification.success();
            })
            .catch((error) => (this.errors = error.response.data.errors));
        } else {
          Notification.customMsg(
            "error",
            "topRight",
            "يرجى كتابة مبلغ اكبر من 0"
          );
        }
      } else {
        Notification.customMsg(
          "warning",
          "topRight",
          "تم دفع حساب المورد بالكامل"
        );
      }
    },
    update() {
      let id = this.$route.params.id;
      axios
        .patch("/api/suppliers/" + id, this.form)
        .then(() => {
          this.$router.push({ name: "suppliers" });
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>


<style type="text/css">
.input-group-text {
  min-width: 160px;
}
</style>
