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
                ادخال بيانات العرض
              </h6>
              <button class="btn btn-primary" type="submit">حفظ</button>
            </div>
            <div class="card-body">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span id="basic-addon1" class="input-group-text">
                    صنف العرض الرئيسي</span
                  >
                </div>
                <input
                  readonly
                  aria-describedby="basic-addon1"
                  aria-label=" صنف العرض الرئيسي"
                  class="form-control"
                  v-model="form.main_type"
                  placeholder=" صنف العرض الرئيسي"
                  type="text"
                />
                <a
                  class="btn btn-info btn text-light"
                  @click="showMainType = !showMainType"
                  ><i class="fas fa-search font-weight-bold text-light"></i
                ></a>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span id="basic-addon2" class="input-group-text">
                    صنف العرض
                  </span>
                </div>
                <input
                  readonly
                  aria-describedby="basic-addon2"
                  aria-label=" صنف العرض "
                  class="form-control"
                  placeholder=" صنف العرض "
                  v-model="form.sup_type"
                  type="text"
                />
                <a
                  class="btn btn-info btn text-light"
                  @click="showSupType = !showSupType"
                  ><i class="fas fa-search font-weight-bold text-light"></i
                ></a>
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">نسبة الخصم</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="نسبة الخصم"
                  class="form-control"
                  placeholder="نسبة الخصم"
                  v-model="form.offer_discount_percent"
                  type="text"
                />
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text">عدد الصنف الرئيسي</span>
                </div>
                <input
                  aria-describedby="basic-addon2"
                  aria-label="عدد الصنف الفرعي"
                  class="form-control"
                  placeholder="عدد الصنف الرئيسي"
                  v-model="form.main_type_count"
                  type="text"
                />
              </div>
            </div>
          </form>
          <div
            aria-hidden="true"
            aria-labelledby="exampleModalLabel"
            :class="showMainType ? 'modal fade d-block show' : 'modal fade'"
            role="dialog"
            tabindex="-1"
          >
            <div
              class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
              role="document"
            >
              <div class="modal-content m-auto" style="min-width: 800px">
                <div class="modal-header">
                  <h5 class="modal-title">إضافة الصنف الرئيسي</h5>
                  <button
                    aria-label="Close"
                    class="close"
                    data-dismiss="modal"
                    type="button"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body min-h-50">
                  <div class="table-responsive w-100">
                    <input
                      v-model="typeName"
                      class="form-control-sm"
                      placeholder="اسم الصنــــــف "
                      type="search"
                    />
                    <button
                      class="btn btn-sm btn-info"
                      @click="findTypeByLike()"
                    >
                      <i class="fa fa-search font-weight-bold text-light"></i>
                    </button>
                    <table class="table align-items-center">
                      <thead>
                        <tr>
                          <th class="col-header" style="width: 10%">
                            كود الصنف
                          </th>
                          <th class="col-header" style="width: 20%">
                            اسم الصنف
                          </th>
                          <th class="col-header" style="width: 5%">تحديد</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(type, index) in products" :key="index">
                          <td>{{ type.type_id }}</td>
                          <td>{{ type.type_name_ar }}</td>
                          <td>
                            <button
                              class="btn btn-success btn-sm"
                              @click="selectMainProduct(type)"
                            >
                              <i
                                class="fa fa-plus font-weight-bold text-light"
                              ></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button
                    class="btn btn-secondary"
                    @click="
                      showMainType = !showMainType;
                      typeName = '';
                    "
                    type="button"
                  >
                    إغلاق
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div
            id="exampleModal"
            aria-hidden="true"
            aria-labelledby="exampleModalLabel"
            :class="showSupType ? 'modal fade d-block show' : 'modal fade'"
            role="dialog"
            tabindex="-1"
          >
            <div
              class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
              role="document"
            >
              <div class="modal-content m-auto" style="min-width: 800px">
                <div class="modal-header">
                  <h5 class="modal-title">إضافة صنف العرض</h5>
                  <button
                    aria-label="Close"
                    class="close"
                    data-dismiss="modal"
                    type="button"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body min-h-50">
                  <div class="table-responsive">
                    <input
                      v-model="typeName"
                      class="form-control-sm"
                      placeholder="اسم الصنــــــف "
                      type="search"
                    />
                    <button
                      class="btn btn-sm btn-info"
                      @click="findTypeByLike()"
                    >
                      <i class="fa fa-search font-weight-bold text-light"></i>
                    </button>
                    <table class="table align-items-center">
                      <thead>
                        <tr>
                          <th class="col-header" style="width: 10%">
                            كود الصنف
                          </th>
                          <th class="col-header" style="width: 20%">
                            اسم الصنف
                          </th>
                          <th class="col-header" style="width: 5%">تحديد</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(type, index) in products" :key="index">
                          <td>{{ type.type_id }}</td>
                          <td>{{ type.type_name_ar }}</td>
                          <td>
                            <button
                              class="btn btn-success btn-sm"
                              @click="selectSupProduct(type)"
                            >
                              <i
                                class="fa fa-plus font-weight-bold text-light"
                              ></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="modal-footer">
                  <button
                    class="btn btn-secondary"
                    @click="
                      showSupType = !showSupType;
                      typeName = '';
                    "
                    type="button"
                  >
                    إغلاق
                  </button>
                </div>
              </div>
            </div>
          </div>
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
    this.allProducts();
  },
  data() {
    return {
      typeName: "",
      showMainType: false,
      showSupType: false,
      form: {
        main_type: null,
        sup_type: null,
        offer_discount_percent: null,
        main_type_count: null,
      },
      errors: {},
      products: [],
    };
  },

  methods: {
    async findTypeByLike() {
      await axios
        .get("/api/action/like/" + this.typeName)
        .then(({ data }) => {
          this.products = data;
        })
        .catch((error) => console.log(error));
    },
    selectMainProduct(type) {
      this.form.main_type = type.type_id;
      this.showMainType = !this.showMainType;
      this.typeName = "";
    },
    selectSupProduct(type) {
      this.form.sup_type = type.type_id;
      this.showSupType = !this.showSupType;
      this.typeName = "";
    },
    create() {
      axios
        .post("/api/offers", this.form)
        .then(() => {
          this.$router.push({ name: "offers" });
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
  },
};
</script>
