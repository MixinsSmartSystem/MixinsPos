<template>
  <div>
    <div v-if="hasRole" class="row">
      <form enctype="multipart/form-data" @submit.prevent="saveChanges">
        <div class="row">
          <div class="col-lg-6">
            <!-- Form Basic -->
            <div class="card mb-4">
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
                  الاعدادات الرئيسية
                </h6>
                <button type="submit" class="btn btn-primary">حفظ</button>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label>اسم المؤسسة </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.mixins_name"
                  />
                </div>
                <div class="form-group">
                  <label>عنوان المؤسسة</label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.mixins_adress"
                  />
                </div>
                <div class="form-group">
                  <div class="row">
                    <div class="col-6">
                      <div class="custom-file mt-5">
                        <input
                          type="file"
                          class="custom-file-input"
                          @change="onFileSelected"
                        />
                        <label class="custom-file-label">شعار المؤسسة</label>
                      </div>
                    </div>
                    <div class="col-6">
                      <img
                        v-if="mixins_new_logo"
                        :src="mixins.mixins_new_logo"
                        style="height: 170px; width: 170px"
                      />
                      <img
                        v-else=""
                        :src="mixins.mixins_logo"
                        style="height: 170px; width: 170px"
                      />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>هاتف المؤسسة </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.mixins_mobile"
                  />
                </div>
                <div class="form-group">
                  <label> عرض الشعار </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.logo_width"
                  />
                </div>
                <div class="form-group">
                  <label> طول الشعار </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.logo_height"
                  />
                </div>
                <div class="form-group d-none">
                  <label> نوع المبيعات </label>
                  <select class="form-control-sm">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>
              </div>
            </div>
              <div class="card mb-3">
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
                      <h6 class="m-0 font-weight-bold text-primary"> العروض</h6>
                  </div>

                  <div class="card-body">


                      <div class="form-group">
                          <div class="custom-control custom-switch">
                              <input
                                  type="checkbox"
                                  class="custom-control-input"
                                  id="active_type_offer"
                                  v-model="mixins.active_type_offer"
                              />
                              <label class="custom-control-label" for="active_type_offer">
                                  تفعيل عرض على صنف</label
                              >
                          </div>
                      </div>
                      <h6 class="mr-auto text-center font-weight-bold text-primary"> عروض لفترة محددة</h6>

                      <div class="form-group">
                          <div class="custom-control custom-switch">
                              <input
                                  type="checkbox"
                                  class="custom-control-input"
                                  id="active_offer"
                                  v-model="mixins.active_offer"
                              />
                              <label class="custom-control-label" for="active_offer">
                                  تفعيل العروض</label
                              >
                          </div>
                      </div>
                      <div class="form-group">
                          <label>تاريخ بداية العرص</label>
                          <input
                              type="date"
                              class="form-control-sm"
                              v-model="mixins.offer_start_date"
                          />
                      </div>
                      <div class="form-group">
                          <label>تاريخ نهاية العرص</label>
                          <input
                              type="date"
                              class="form-control-sm"
                              v-model="mixins.offer_endt_date"
                          />
                      </div>
                      <div class="form-group">
                          <label>قيمة العرض</label>
                          <input
                              type="number"
                              min="0"
                              :readonly="mixins.offer_percenet>0"
                              class="form-control-sm"
                              v-model="mixins.offer_value"
                          />
                      </div>
                      <div class="form-group">
                          <label>نسبة العرض</label>
                          <input
                              type="number"
                              min="0"
                              :readonly="mixins.offer_value>0"
                              class="form-control-sm"
                              v-model="mixins.offer_percenet"
                          />
                      </div>
                  </div>
              </div>

          </div>

          <div class="col-lg-6">
            <div class="card mb-4">
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
                  بيانات الضريبة
                </h6>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="mixins_price_include_vat"
                      v-model="mixins.mixins_price_include_vat"
                    />
                    <label
                      class="custom-control-label"
                      for="mixins_price_include_vat"
                      >الاسعار شاملة الضريبة</label
                    >
                  </div>
                </div>
                <div class="form-group">
                  <label>الرقم الضريبي </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.contruct_no"
                  />
                </div>
                <div class="form-group">
                  <label>نسبة الضريبة </label>
                  <input
                    type="text"
                    class="form-control-sm"
                    v-model="mixins.mixins_vat_val"
                  />
                </div>
                <div class="form-group d-none">
                  <label>نسبة الضريبة </label>
                  <select class="form-control-sm">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>ملاحظات </label>
                  <textarea
                    class="form-control"
                    v-model="mixins.mixins_note"
                    rows="3"
                  ></textarea>
                </div>
              </div>
            </div>
            <!-- Input Group -->
            <div class="card mb-3">
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
                <h6 class="m-0 font-weight-bold text-primary">شاشة الفاتورة</h6>
              </div>

              <div class="card-body">
                <div class="form-group">
                  <div class="custom-control custom-switch">
                    <input
                      type="checkbox"
                      class="custom-control-input"
                      id="bill_with_main_type"
                      v-model="mixins.bill_with_main_type"
                    />
                    <label
                      class="custom-control-label"
                      for="bill_with_main_type"
                      >أصناف رئيسية</label
                    >
                  </div>
                </div>

                <div class="form-group">
                  <label>فاتورة مبيعات</label>
                  <select
                    class="form-control-sm"
                    v-model="mixins.bill_type"
                  >
                    <option value="1">افتراضي</option>
                    <option value="2">افتراضي مع تنبيه النواقص</option>
                    <option value="3">وحدات</option>
                    <option value="4">وحدات مع تنبيه النواقص</option>
                  </select>
                </div>
                <div class="form-group">
                  <label> تنبيه النواقص عندما يكون مخزون الصنف </label>
                  <input
                    type="text"
                    class="form-control-sm num"
                    v-model="mixins.item_request_qty"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
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
      this.$router.push({ name: "/" });
    }
    let id = this.$route.params.id;
    axios
      .get("/api/mixins/" + 1)
      .then(({ data }) => (this.mixins = data))
      .catch((err) => console.log(err));
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(2),

      isShow: "",
      mixins: {
        contruct_no: "",
        id: "",
        bill_type: "",
        item_request_qty: "",
        logo_height: "",
        logo_width: "",
        mixins_adress: "",
        mixins_logo: "",
        mixins_mobile: "",
        mixins_name: "",
        mixins_note: "",
        mixins_price_include_vat: "",
        mixins_new_logo: "",
        use_type_uints: "",
      },
      mixins_new_logo: "",
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
          this.mixins.mixins_new_logo = event.target.result;
          this.mixins_new_logo = event.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    saveChanges() {
      axios
        .patch("/api/mixins/1", this.mixins)
        .then(async () => {
          await this.$router.push({ name: "newBill" });
          await location.reload(true);
          Notification.success();
        })
        .catch((error) => (this.errors = error.response.data.errors));
    },
    showDropDown() {
      this.isShow = !this.isShow;
    },
  },
};
</script>
<style scoped>
input {
  min-width: 80%;
}
input.num {
  min-width: 20%;
}
</style>

