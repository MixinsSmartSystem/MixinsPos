<template>
  <div>
    <MixinsSpinner v-show="loading"></MixinsSpinner>

    <div v-show="!loading">
      <div class="row mb-3 newBill">
        <div class="col-md-12">
          <!--Start Selected Items-->
          <div class="selected text-center w-100">
            <div class="card mb-4 text-center">
              <h1 class="my-0 btn-sm d-block">مرتجع بيع</h1>

              <div
                class="
                  card-header
                  w-100
                  d-flex
                  flex-row
                  align-items-center
                  justify-content-between
                  hideMeInPrint
                "
              >


                      <h6 class="m-0 font-weight-bold text-primary float-left">
                          <input class="form-control" placeholder="رقم الفاتورة" type="text" v-model="bill_id"  @keyup="findBill()"/>

                      </h6>
                      <h6 class="m-0 font-weight-bold text-primary float-left">
                          <input class="form-control" placeholder="باركود الصنف" type="text" v-model="barcode"  @keyup="findBillByTypeId()"/>
                      </h6>

                <form
                  v-show="!period"
                  class="needs-validation"
                  @submit.prevent="allBills"
                >
                  <div class="form-row">
                    <div class="col-md-5">
                      <div class="input-group">
                        <div
                          class="input-group-prepend"
                          style="width: 50px !important"
                        >
                          <span
                            id="validationTooltipUsernamePrepend"
                            class="input-group-text"
                            >من</span
                          >
                        </div>
                        <input
                          id="validationTooltipUsername"
                          v-model="reportPeriod.from"
                          aria-describedby="validationTooltipUsernamePrepend"
                          class="form-control"
                          placeholder="Username"
                          required
                          type="date"
                        />
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="input-group">
                        <div
                          class="input-group-prepend float-right"
                          style="width: 50px !important"
                        >
                          <span class="input-group-text" for="to">الى</span>
                        </div>
                        <input
                          v-model="reportPeriod.to"
                          aria-describedby="validationTooltipUsernamePrepend"
                          class="form-control"
                          placeholder="Username"
                          required
                          type="date"
                        />
                      </div>
                    </div>
                    <button
                      class="btn btn-success font-weight-bold text-light btn-sm"
                      type="submit"
                    >
                      عرض
                    </button>
                  </div>
                </form>
                <form class="" direction="rtl" @submit.prevent="saveBill">
                  <table class="table-bordered">
                    <tbody>
                      <tr>
                        <td>
                          <b>المجموع:</b>
                          {{ returnBill.sum }}
                        </td>
                        <td>
                          <b>إجمالي الضريبة:</b>
                          {{ returnBill.vat }}
                        </td>
                        <td>
                          <b> صافي الاجمالي:</b>
                          {{ returnBill.total }}
                        </td>
                        <td>
                          <button
                            :disabled="returnBill.total <= 0"
                            class="btn btn-success font-weight-bold text-light"
                            type="submit"
                          >
                            حفظ
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </form>
              </div>
              <div class="card-body w-100 text-center">
                <div
                  class="table-responsive"
                  id="printMeReport"
                  style="height: 50vh"
                >
                  <table
                    id="resultTable"
                    class="text-center sortTable"
                    style="cellpadding: 20px; cellspacing: 0px; width: 100%"
                  >
                    <thead>
                      <tr>
                        <th style="width: 5%">رقم الفاتورة</th>
                        <th style="width: 10%">المجموع</th>
                        <th style="width: 10%">ضريبة القيمة المضافة</th>
                        <th style="width: 10%">الاجمالي</th>
                        <th style="width: 5%">الخصم</th>
                        <th style="width: 10%">المدفوع</th>
                        <th style="width: 10%">المتبقي</th>
                        <th style="width: 20%">تاريخ الفاتورة</th>
                        <th style="width: 5%">طريقة الدفع</th>
                        <th style="width: 10%">العميل</th>
                        <th style="width: 10%">المستخدم</th>
                        <th style="width: 10%">ملاحظات</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="bill in bills"
                        :key="bill.bill_no"
                        @dblclick="preparePrint(bill)"
                        @click="
                          showBillDetails(bill);
                          selected = bill.bill_no;
                        "
                      >
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_no }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_sum }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_vat_val }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_total }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_discount_val }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_paid_val }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_remain_val }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_date }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.pay_methods.pay_method_name }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.customer ? bill.customer.cust_name : "" }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.user ? bill.user.name : "" }}
                        </td>
                        <td
                          :class="selected === bill.bill_no ? 'selected' : ''"
                        >
                          {{ bill.bill_notes }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div style="min-height: 50vh">
              <div class="w-100 table-wrapper">
                <div id="pagewrap" class="row">
                  <div id="body" class="col-sm-12">
                    <table class="text-center">
                      <thead>
                        <tr>
                          <th class="col-header" style="width: 50%">
                            اسم الصنف
                          </th>
                          <th class="col-header" style="width: 10%">العدد</th>
                          <th class="col-header" style="width: 10%">السعر</th>
                          <th class="col-header" style="width: 10%">
                            الكمية المرتجعة
                          </th>
                          <th class="col-header" style="width: 10%">
                            اجمالي المرتجعات
                          </th>
                          <th class="col-header" style="width: 10%">
                            الاجمالي
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(product, index) in form.bill_type"
                          :key="index"
                        >
                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold   text-light bg-secondary'
                                : 'font-weight-bold'
                            "
                            :style="
                              product.has_Offer ? 'color:red!important' : ''
                            "
                          >
                            {{ product.type.type_name_ar }}
                          </td>
                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold  text-light  bg-secondary'
                                : 'font-weight-bold'
                            "
                          >
                            {{ product.type_count }}
                          </td>
                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold   text-light bg-secondary'
                                : 'font-weight-bold'
                            "
                          >
                            {{ product.type_price }}
                          </td>
                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold bg-secondary'
                                : 'font-weight-bold'
                            "
                          >
                            <button
                              v-if="!product.returned"
                              class="btn-sm mx-2 btn-warning"
                              @click="decrement(product)"
                            >
                              -
                            </button>
                            <input
                                v-if="!product.returned"
                              v-model="product.returned_qty"
                              readonly=""
                                class="btn-sm"
                              style="width: 50px"
                            />
                              <b v-else>{{product.returned_qty}}</b>
                            <button
                              v-if="!product.returned"
                              class="btn-sm mx-2 btn-success"
                              :disabled="product.has_Offer"
                              @click="increment(product)"
                            >
                              +
                            </button>
                          </td>

                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold   text-light bg-secondary'
                                : 'font-weight-bold'
                            "
                          >
                            <b class="btn text-bold">{{
                              product.returned_total
                            }}</b>
                          </td>
                          <td
                            :class="
                              product.returned
                                ? 'font-weight-bold text-light  bg-secondary'
                                : 'font-weight-bold'
                            "
                          >
                            {{ product.type_total_price }}
                          </td>
                        </tr>
                      </tbody>
                      <tfoot v-for="returnType in form.returns">
                        <tr
                          v-for="(product, index) in returnType.return_types"
                          :key="index"
                        >
                          <td class="font-weight-bold text-light bg-secondary">
                            {{ product.type.type_name_ar }}
                          </td>
                          <td
                            class="
                              font-weight-bold
                              text-light
                              bg-secondary
                              text-light
                            "
                          >
                            {{ product.returned_qty }}
                          </td>
                          <td
                            class="
                              font-weight-bold
                              text-light
                              bg-secondary
                              text-light
                            "
                          >
                            {{ product.type_price }}
                          </td>
                          <td
                            class="
                              font-weight-bold
                              text-light
                              bg-secondary
                              text-light
                            "
                          >
                            {{ product.returned_qty }}
                          </td>
                          <td
                            class="
                              font-weight-bold
                              text-light
                              bg-secondary
                              text-light
                            "
                          >
                            {{ product.returned_total }}
                          </td>
                          <td
                            class="
                              font-weight-bold
                              text-light
                              bg-secondary
                              text-light
                            "
                          >
                            {{ product.type_total_price }}
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Selected Items-->
        </div>
      </div>
      <div>
        <Printer :bill="bill" :qr="qr" />
      </div>
    </div>
  </div>
</template>

<script>
import { Invoice } from "@axenda/zatca";
import MixinsSpinner from "../spinner/mixinsSpinner";
import Printer from "../printer";

export default {
  components: { Printer, MixinsSpinner },
  async created() {
    if (!User.loggedIn()) {
      await this.$router.push("/");
    }
    await this.calcDate();
    await this.allBills();
    await this.getMixins();
    await this.allPayMethods();
  },

  data() {
    return {
      searchTypes: [],
      showSearchTypeModal: false,
      output: null,
      qr: "",
      selected: "",
      isNewbill: true,
      isPrint: false,
      loading: false,
      mixins: {
        bill_column_num: "",
        bill_discount: "",
        bill_with_main_type: "",
        closure_hour: "",
        contruct_no: "",
        default_lang: "",
        end_support_date: "",
        id: "",
        image_path: "",
        bill_type: "",
        item_request_qty: "",
        logo_height: "",
        logo_width: "",
        main_mixins_store: "",
        main_type_column_num: "",
        mixins_adress: "",
        mixins_font_color: "",
        mixins_font_size: "",
        mixins_logo: "",
        mixins_mac_serial: "",
        mixins_main_payment_method: "",
        mixins_mobile: "",
        mixins_name: "",
        mixins_note: "",
        mixins_price_include_vat: false,
        mixins_theme: "",
        mixins_vat_val: "",
        partition_folder: "",
        render_bill_footer_note: "",
        render_bill_img: "",
        render_bill_note: "",
        render_bill_reports: "",
        render_bills: "",
        render_cash: "",
        render_cash_point: "",
        render_en_names: "",
        render_new_bill: "",
        render_purchase_bills: "",
        render_purchase_bills_reports: "",
        render_types_note: "",
        render_withdraw_cash: "",
        show_reset_btn: "",
        type_discount: "",
        use_type_uints: "",
        active_type_offer: "",
      },
      products: [],
      payMethods: [],
      categories: [],
      category: {},
      customers: [],
      customer: {},
      search: "",
      barcode: "",
      id: "",
      searchName: "",
      typeName: "",
      isPercentDiscount: false,
      type: {},
      bill_id: "",
        barcode:"",
      bill: {},
      cart: [],
      form: {},
      hasRole: this.$root.$data.roles.includes(3),
      bills: [],
      searchTerm: "",
      period: false,
      reportName: "",
      hideMe: false,
      total: 1,
      page: 1,
      current_page: "",
      reportPeriod: {
        to: null,
        from: null,
      },

      returnBill: {
        sum: 0.0,
        total: 0.0,
        vat: 0.0,
        cart: [],
        prevtype: [],
      },
      billTypes: [],
      typeUnit: {},
    };
  },
  methods: {
    async allPayMethods() {
      await axios
        .get("/api/payMethods")
        .then(({ data }) => (this.payMethods = data))
        .catch((error) => console.log(error));
    },
    async findBill() {
      await axios
        .get("api/action/findBillById/" + this.bill_id)
        .then(async ({ data }) => {
          if (data.length >= 0) {
            this.bills = data;
          } else {
            Notification.customMsg(
              "warning",
              "topRight",
              "لا يوجد فاتورة بهذا الرقم"
            );
          }
        })
        .catch((err) => console.log(err));
    },
      async findBillByTypeId() {
          await axios
              .get("api/action/findBillWithTypeId/" + this.barcode)
              .then(async ({ data }) => {
                  this.bills=[];
                  data.bill_type.map((bill)=>{
                      this.bills.push(bill.bill);
                  })

              })
              .catch((err) => console.log(err));
      },
    async print(bill) {
      this.bill = bill;

      if (bill != null && bill.customer != null) {
        const invoice = new Invoice({
          sellerName: bill.customer.cust_name,
          vatRegistrationNumber: this.mixins.contruct_no,
          invoiceTimestamp: bill.bill_date,
          invoiceTotal: bill.bill_total,
          invoiceVatTotal: bill.bill_vat_val,
        });
        this.qr = await invoice.render();
      }
      $("#printer").click();
    },
    async getMixins() {
      await axios
        .get("/api/mixins/1")
        .then(({ data }) => {
          this.mixins = data;
        })
        .catch((error) => console.log(error));
    },

    async decrement(product) {
      if (product.returned_qty < 1) {
        product.returned_qty = 0;
        product.returned_total =
          product.returned_qty * Number(product.type_sill_price);
        this.cart.slice(product);
      } else {
        product.returned_qty--;
      }

      await this.calcSum();

      await this.calcTotalTypeCost(product);
    },
    async increment(product) {
      if (this.cart.includes(product)) {
        if (product.returned_qty == product.type_count) {
          product.returned_qty = product.type_count;
        } else {
          product.returned_qty++;
        }
      } else {
        product.returned_qty = 1;
        this.cart.push(product);
      }

      await this.calcTotalTypeCost(product);
    },
    onChangeCount(product) {
      if (product.returned_qty <= 1) {
        product.returned_qty = 1;
      }
      this.calcTotalTypeCost(product);
    },
    onChangeTypeCost(product) {
      if (product.type_price < product.minimum_sill_price) {
        product.type_price = product.minimum_sill_price;
      }
      this.calcTotalTypeCost(product);
    },
    async findUnit(product) {
      await axios
        .get("/api/units/" + product.sell_unit)
        .then(({ data }) => {
          this.typeUnit = data;
        })
        .catch((error) => console.log(error));
    },
    async calcUnitPrice(product) {
      if (product.sell_unit !== null) {
        await this.findUnit(product);
        if (product.type_stock !== null) {
          var totalNofUnit =
            this.typeUnit.no_of_unit *
              product.type.type_stock.mixins_type_stock +
            product.returned_qty;
          product.calc_count = totalNofUnit / this.typeUnit.no_of_unit;
        }
      }
    },
    async calcTotalTypeCost(product) {
      if (this.mixins.use_type_uints) {
        await this.calcUnitPrice(product);
      }
      product.returned_total =
        product.returned_qty * Number(product.type_price);
      await this.calcDef(product);
      await this.calcSum();
    },
    async calcDef(product) {
      if (Number(product.type_discount_value) > 0) {
        product.total_type_cost =
          (product.type_count - product.returned_qty) *
          (Number(product.type_sill_price) -
            Number(product.type_discount_value));
        await this.calcSum();
        return;
      }
      if (Number(product.type_discount_percent) > 0) {
        let price =
          product.type_sill_price -
          product.type_sill_price * (product.type_discount_percent / 100.0);
        product.total_type_cost =
          (product.type_count - product.returned_qty) * price;
        await this.calcSum();
        return;
      }
      product.total_type_cost =
        (product.type_count - product.returned_qty) *
        Number(product.type_sill_price);
      await this.calcSum();
    },
    async calcSum() {
      this.returnBill.sum = 0;
      this.cart.filter((product) => {
        this.returnBill.sum += product.returned_total;
      });
      if (this.mixins.mixins_price_include_vat) {
        this.returnBill.sum =
          this.returnBill.sum / (1 + this.mixins.mixins_vat_val / 100.0);
      }
      await this.calcTotal();
    },
    async calcTotal() {
      this.returnBill.total = this.returnBill.sum;
      if (this.mixins.mixins_vat_val > 0) {
        let vatVal = this.mixins.mixins_vat_val;
        this.returnBill.vat = (this.returnBill.total * vatVal) / 100.0;
        this.returnBill.total = this.returnBill.total + this.returnBill.vat;
      }
      //Form number

      this.returnBill.vat = Number(this.returnBill.vat).toFixed(2);
      this.returnBill.sum = Number(this.returnBill.sum).toFixed(2);
      this.returnBill.total = Number(this.returnBill.total).toFixed(2);
    },
    async saveBill() {
      let isValid = true;
      if (this.cart.length <= 0) {
        isValid = false;
        Notification.customMsg(
          "error",
          "topRight",
          "لايمكن حفظ فاتورة بدون أصناف"
        );
        return;
      }
      if (this.form.total <= 0) {
        isValid = false;
        Notification.customMsg(
          "error",
          "topRight",
          "لايمكن حفظ فاتورة قيمتها صفر"
        );
        return;
      }

      if (isValid) await this.saveValidBill();
    },
    async saveValidBill() {
      this.returnBill.cart = this.cart;
      this.returnBill.prevtype = this.form.bill_type;
      if (this.returnBill.cart.length > 0) {
        await axios
          .patch("api/bills/" + this.form.bill_no, this.returnBill)
          .then(async (data) => {
            Notification.success();
            await this.clearAll();
            await this.allBills();
          })
          .catch((error) => console.log(error));
      } else {
        Notification.error();
      }
    },
    clearAll() {
      this.form.bill_type = [];
      this.form.cart = [];
      this.customer = {};
      this.search = "";
      this.calcSum();
      this.isPrint = false;
    },
    async preparePrint(bill) {
      await this.print(bill);
    },
    nextPage(i) {
      this.page = i;
      this.allBills();
    },
    printMe() {
      this.$htmlToPaper("printMeReport");
    },
    allBills() {
      axios
        .get(
          "/api/bill/report/" +
            this.period +
            "/" +
            this.reportPeriod.from +
            "/" +
            this.reportPeriod.to
        )
        .then(({ data }) => {
          if (data.length >= 0) {
            // this.loading = false;
            this.bills = data;
          }
        })
        .catch((error) => console.log(error));
    },
    async showBillDetails(bill) {
      this.form = bill;
    },
    calcDate() {
      var lastDate = new Date();
      lastDate.setDate(lastDate.getDate() - 5);
      var currentDate = new Date();
      currentDate.setDate(currentDate.getDate() + 1);
      this.reportPeriod.from = lastDate
        .toJSON()
        .slice(0, 10)
        .replace(/-/g, "-");
      this.reportPeriod.to = currentDate
        .toJSON()
        .slice(0, 10)
        .replace(/-/g, "-");
    },
  },
};
</script>
<style scoped>
b.btn {
  float: right;
}

.fa {
  cursor: pointer;
}

:root {
  --secondary: linear-gradient(221deg, #8743ff, #4136f1 60%);
  --body: #eaf2ff;
  --card: #fff;
  --text: #000;
  --price: #4136f1;
}

body {
  /*background: var(--secondary);*/
  transition: background 0.3s;
  gap: 20px;
  font-family: "Poppins", sans-serif;
}

.newBill .card {
  background: var(--card);
  border-radius: 20px;
  font-family: "Poppins", sans-serif;
  display: flex;
  color: var(--text);
  flex-direction: column;
  align-items: flex-start;
  transition: transform 0.3s, background 0.3s;
}

.newBill .card-header {
  border-radius: 0;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  font-weight: bolder;
}

.newBill .card img {
  width: 160px;
  height: 120px;
  border-radius: 14px;
  object-fit: cover;
}

.newBill .card__title {
  margin-top: 16px;
  font-size: 15px;
  font-weight: 400;
  transition: color 0.3s;
}

.newBill .card__shop {
  width: 100%;
  margin-top: auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.newBill .card__shop__action span {
  color: #fff;
  font-size: 26px;
}
</style>
