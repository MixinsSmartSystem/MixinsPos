<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card mb-4">
          <form @submit.prevent="create" enctype="multipart/form-data">
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
                ادخال بيانات المصروف
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span id="basic-addon1" class="input-group-text"
                    >اسم المصروف</span
                  >
                </div>
                <input
                  aria-describedby="basic-addon1"
                  aria-label="اسم المصروف"
                  class="form-control"
                  v-model="form.expense_title"
                  placeholder="اسم المصروف"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">التكلفة</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="التكلفة"
                  class="form-control"
                  placeholder="التكلفة"
                  v-model="form.expense_cost"
                  min="0"
                  type="number"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">التاريخ</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="التاريخ"
                  class="form-control"
                  placeholder="التاريخ"
                  v-model="form.expense_date"
                  type="date"
                />
              </div>
              <div class="input-group mb-3">
                <img
                  :src="form.expense_icon"
                  class="card-img-top w-25 h-25 float-left ml-auto"
                />
                <input
                  id="customFile"
                  class="custom-file-input"
                  type="file"
                  @change="onFileSelected"
                />
                <span
                  class="custom-file-label input-group-text w-100"
                  for="customFile"
                  style="width: 80px; text-align: center"
                ></span>
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
        expense_title: null,
        expense_cost: null,
        expense_icon: null,
        expense_date: null,
      },
      errors: {},
    };
  },

  methods: {
    onFileSelected(event) {
      let file = event.target.files[0];
      if (file.size > 1048770) {
        Notification.image_validation();
      } else {
        let reader = new FileReader();
        reader.onload = (event) => {
          this.form.expense_icon = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },
    create() {
      axios
        .post("/api/expenses", this.form)
        .then(() => {
          this.$router.push({ name: "expenses" });
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>
