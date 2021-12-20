<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <form
              class="types"
              dir="rtl"
              enctype="multipart/form-data"
              @submit.prevent="createType"
            >
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
                  <img
                    :src="type.type_icon"
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
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">اسم الصنف عربي</span>
                  </div>
                  <input
                    v-model="type.type_name_ar"
                    aria-describedby="basic-addon1"
                    aria-label="اسم الصنف عربي"
                    class="form-control"
                    placeholder="اسم الصنف عربي"
                    type="text"
                  />
                  <div class="input-group-prepend">
                    <span class="input-group-text">اسم الصنف انجليزي</span>
                  </div>
                  <input
                    v-model="type.type_name_en"
                    aria-describedby="basic-addon1"
                    aria-label="اسم الصنف انجليزي"
                    class="form-control"
                    placeholder="اسم الصنف انجليزي"
                    type="text"
                  />
                </div>
                <div class="input-group mb-3">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> سعر الشراء</span>
                    </div>
                    <input
                      v-model="type.type_purchases_price"
                      aria-describedby="basic-addon1"
                      aria-label="سعر الشراء"
                      class="form-control"
                      placeholder="سعر الشراء"
                      type="text"
                    />
                    <div class="input-group-prepend">
                      <span class="input-group-text">سعر البيع</span>
                    </div>
                    <input
                      v-model="type.type_sill_price"
                      aria-describedby="basic-addon1"
                      aria-label="سعر البيع"
                      class="form-control"
                      placeholder="سعر البيع"
                      type="text"
                      @keyup="calcVat()"
                    />
                    <div class="input-group-prepend">
                      <span class="input-group-text"> أقل سعر البيع</span>
                    </div>
                    <input
                      v-model="type.minimum_sill_price"
                      aria-describedby="basic-addon1"
                      aria-label="أقل سعر البيع "
                      class="form-control"
                      placeholder="أقل سعر البيع"
                      type="text"
                    />

                    <div class="input-group-prepend d-none">
                      <span class="input-group-text">قيمة الضريبة</span>
                    </div>
                    <input
                      v-model="type.type_vat_value"
                      aria-describedby="basic-addon1"
                      aria-label="قيمة الضريبة "
                      class="form-control d-none"
                      placeholder="قيمة الضريبة"
                      type="text"
                    />
                  </div>
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> التصنيف</span>
                  </div>
                  <select v-model="type.main_type" class="form-control-sm w-25">
                    <option v-for="cat in categories" :value="cat.main_type_id">
                      {{ cat.main_type_title_ar }}
                    </option>
                  </select>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> الباركود الدولي</span>
                  </div>
                  <input
                    v-model="type.type_barcode"
                    aria-describedby="basic-addon1"
                    aria-label="  الباركود الدولي"
                    class="form-control"
                    placeholder="  الباركود الدولي"
                    type="text"
                  />
                  <div class="input-group-prepend">
                    <span class="input-group-text">كود مختصر</span>
                  </div>
                  <input
                    v-model="type.type_code"
                    aria-describedby="basic-addon1"
                    aria-label="كود مختصر"
                    class="form-control"
                    placeholder=" كود مختصر"
                    type="text"
                  />
                </div>
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">نسبة الخصم</span>
                  </div>
                  <input
                    v-model="type.type_discount_value"
                    aria-describedby="basic-addon1"
                    aria-label="نسبة الخصم"
                    class="form-control"
                    placeholder="نسبة الخصم"
                    type="text"
                  />
                  <div class="input-group-prepend">
                    <span class="input-group-text">نسبة الخصم</span>
                  </div>
                  <input
                    v-model="type.type_discount_percent"
                    aria-describedby="basic-addon1"
                    aria-label="نسبة الخصم"
                    class="form-control"
                    placeholder=" نسبة الخصم"
                    type="text"
                  />
                </div>

                <div class="card">
                  <div
                    class="
                      card-header
                      d-flex
                      flex-row
                      align-items-center
                      justify-content-between
                    "
                  >
                    <div class="input-group-prepend">
                      <a class="btn btn-sm btn-success" @click="addUnit()">
                        اضافة وحدة الصنف
                        <i class="fa fa-plus"></i>
                      </a>
                    </div>
                    <div
                      class="input-group-prepend"
                      v-show="selected_units.length > 0"
                    >
                      <span
                        class="input-group-text btn btn-sm"
                        for="selectUnit"
                      >
                        وحدة البيع</span
                      >
                      <select
                        id="selectUnit"
                        style="width: 150px"
                        v-model="type.sell_unit"
                      >
                        <option
                          :key="index"
                          v-for="(selected, index) in selected_units"
                          :value="selected.unit_id.unit_id"
                        >
                          {{ selected.unit_id.unit_ar_name }}
                        </option>
                      </select>
                    </div>
                  </div>

                  <div class="card-body">
                    <table
                      class="table-bordered text-center"
                      v-show="selected_units.length > 0"
                    >
                      <thead>
                        <tr>
                          <th style="width: 10%">الوحدة</th>
                          <th style="width: 10%">عدد الوحدات</th>
                          <th style="width: 10%">السعر</th>
                          <th style="width: 10%">فرق السعر</th>
                          <th style="width: 10%">باركود</th>
                          <th>X</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          class="text-center"
                          v-for="(selected, index) in selected_units"
                          :key="index"
                        >
                          <td>
                            <select
                              class="form-control-sm"
                              v-model="selected.unit_id"
                              @change="onChangeCountCalcPrice(selected)"
                            >
                              <option v-for="(unit, i) in units" :value="unit">
                                {{ unit.unit_ar_name }}
                              </option>
                            </select>
                          </td>
                          <td>
                            <input
                              class="form-control-sm"
                              v-model="selected.no_of_unit"
                              @keyup="onChangeCountCalcPrice(selected)"
                            />
                          </td>
                          <td>
                            <input
                              class="form-control-sm"
                              v-model="selected.price"
                            />
                          </td>
                          <td>
                            <input
                              class="form-control-sm"
                              v-model="selected.deff_price"
                              @keyup="onChangeCountCalcPrice(selected)"
                            />
                          </td>
                          <td>
                            <input
                              class="form-control-sm"
                              v-model="selected.barcode"
                            />
                          </td>
                          <td @click="removeUnit(selected, index)">
                            <i
                              class="pointer btn-sm btn-danger fa fa-times"
                            ></i>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">مكان الصنف</span>
                  </div>
                  <input
                    v-model="type.type_location"
                    aria-describedby="basic-addon1"
                    aria-label="مكان الصنف"
                    class="form-control"
                    placeholder="مكان الصنف"
                    type="text"
                  />
                  <div class="input-group-prepend">
                    <span class="input-group-text">ملاحظــــات الصنف</span>
                  </div>
                  <input
                    v-model="type.type_note"
                    aria-describedby="basic-addon1"
                    aria-label="ملاحظــــات الصنف"
                    class="form-control"
                    placeholder="ملاحظــــات الصنف"
                    type="text"
                  />
                </div>
              </div>
            </form>
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
    this.allMainType();
    this.allUnits();
  },
  data() {
    return {
      type: {
        type_name_ar: null,
        type_name_en: null,
        type_icon: null,
        type_location: null,
        type_purchases_price: null,
        type_count: null,
        type_has_vat: null,
        type_vat_value: null,
        type_vat_percent: null,
        type_note: null,
        type_sill_price: null,
        type_discount_value: null,
        type_discount_percent: null,
        total_type_cost: null,
        type_barcode: null,
        type_exp_date: null,
        sell_unit: null,
        lg_unit: null,
        md_unit: null,
        no_md_unit: null,
        sm_unit: null,
        no_sm_unit: null,
        diff_md_unit_price: null,
        diff_sm_unit_price: null,
        is_deleted: null,
        minimum_sill_price: null,
        type_code: null,
        prevent_use: null,
        main_type: null,
        type_unit: [],
      },
      categories: [],
      errors: {},
      type_units: {
        unit_id: "",
        no_of_unit: 1,
        deff_price: 0.0,
        price: 0.0,
        barcode: "",
      },
      selected_units: [],
      units: [],
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
          this.type.type_icon = event.target.result;
          console.log(event.target.result);
        };
        reader.readAsDataURL(file);
      }
    },

    allMainType() {
      axios
        .get("/api/mainTypes")
        .then(({ data }) => {
          this.categories = data;
        })
        .catch((error) => console.log(error));
    },
    allUnits() {
      axios
        .get("/api/units")
        .then(({ data }) => {
          this.units = data;
        })
        .catch((error) => console.log(error));
    },

    calcVat() {
      let vat = localStorage.getItem("vat");
      if (this.type.type_sill_price) {
        this.type.type_vat_value = (this.type.type_sill_price * vat) / 100.0;
      }
    },
    addUnit() {
      let TypeUnits = JSON.parse(JSON.stringify(this.type_units));
      this.selected_units.push(TypeUnits);
    },
    removeUnit(selected, index) {
      selected.no_of_unit = 1;
      selected.price = 0;
      this.$delete(this.selected_units, index);
    },
    onChangeCountCalcPrice(selected) {
      selected.price = 0;
      selected.price =
        this.type.type_sill_price / selected.no_of_unit +
        Number(selected.deff_price);
    },
    createType() {
      this.type.type_unit = this.selected_units;
      axios
        .post("/api/types", this.type)
        .then(() => {
          this.$router.push({ name: "types" });
          Notification.success();
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        })
        .then((e) => {
          if (this.errors.type_name_ar)
            Notification.customMsg(
              "error",
              "topRight",
              this.errors.type_name_ar[0]
            );
          if (this.errors.type_sill_price)
            Notification.customMsg(
              "error",
              "topRight",
              this.errors.type_sill_price[0]
            );
        });
    },
  },
};
</script>
<style>
label {
  float: right;
}
.pointer {
  cursor: pointer;
}
</style>
