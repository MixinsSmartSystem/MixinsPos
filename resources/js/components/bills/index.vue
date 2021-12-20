<template>
  <div>
    <div v-if="hasRole" class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
        <div class="card mb-4">
          <div
            class="
              card-header
              hideMeInPrint
              d-flex
              flex-row
              align-items-center
              justify-content-between
              hideMeInPrint
            "
          >
            <h1 class="text-center my-0 btn-sm d-block">الفواتير</h1>
            <button
              class="btn btn-primary"
              onclick="download('xlsx','resultTable');"
              type="submit"
            >
              <i class="fa fa-file-excel"></i>
            </button>
            <a class="btn btn-info" href="javascript:timedRefresh(2000)">
              <i class="fa fa-sort"></i>
            </a>
            <button
              class="btn btn-success btn-sm"
              @click="printMe()"
              type="submit"
            >
              طباعة
            </button>
            <h6 class="m-0 font-weight-bold text-primary float-left">
                <input class="form-control" placeholder="رقم الفاتورة" type="text" v-model="bill_id"  @keyup="findBill()"/>

            </h6>
              <h6 class="m-0 font-weight-bold text-primary float-left">
                  <input class="form-control" placeholder="باركود الصنف" type="text" v-model="barcode"  @keyup="findBillByTypeId()"/>
              </h6>
            <form
              v-show="!period"
              class="needs-validation mt-2 hideMeInPrint"
              @submit.prevent="allBills"
            >
              <div class="form-row">
                <div class="col-md-5">
                  <div class="input-group">
                    <div class="input-group-prepend input-sm">
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
                    <div class="input-group-prepend float-right input-sm">
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
                <div class="col-md-2">
                  <button class="btn btn-success btn-sm" type="submit">
                    عرض
                  </button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-body">
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
                    <th class="hideMeInPrint" style="width: 10%">طباعة</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="bill in bills"
                    :key="bill.bill_no"
                    @click="
                      showBillDetails(bill.bill_type);
                      selected = bill.bill_no;
                    "
                  >
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_no }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_sum }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_vat_val }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_total }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_discount_val }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_paid_val }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_remain_val }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_date }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.pay_methods.pay_method_name }}
                    </td>

                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.customer ? bill.customer.cust_name : "" }}
                    </td>
                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.user ? bill.user.name : "" }}
                    </td>

                    <td :class="selected === bill.bill_no ? 'selected' : ''">
                      {{ bill.bill_notes }}
                    </td>
                    <td
                      :class="
                        selected === bill.bill_no
                          ? 'hideMeInPrint selected'
                          : 'hideMeInPrint'
                      "
                    >
                      <a
                        class="btn btn-sm btn-success"
                        @click="preparePrint(bill)"
                      >
                        <i class="fa fa-print text-light"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="table-responsive" style="height: 50vh">
              <div class="row text-center">
                <th class="col-1">كود الصنف</th>
                <th class="col-2">اسم الصنف</th>
                <th class="col-1">العدد</th>
                <th class="col-1">سعر البيع</th>
                <th class="col-1">الوحدة</th>
                <th class="col-1">الاجمالي</th>
                <th class="col-5">ملاحظات</th>
              </div>
              <div
                v-for="type in billTypes"
                :key="type.bill_type_id"
                class="text-center row"
              >
                <td class="col-1">{{ type.type_id }}</td>
                <td class="col-2">{{ type.type.type_name_ar }}</td>
                <td class="col-1">{{ type.type_count }}</td>
                <td class="col-1">{{ type.type_price }}</td>
                <td class="col-1">{{ type.sill_unit }}</td>
                <td class="col-1">{{ type.type_total_price }}</td>
                <td class="col-5">{{ type.type_note }}</td>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Printer :bill="bill" :mixins="mixins" />
    </div>
    <Security v-else></Security>
  </div>
</template>

<script>
import Printer from "../printer";
import Spinner from "../spinner/mixinsSpinner";
import Security from "../spinner/security";

export default {
  components: { Printer, Spinner, Security },

  async created() {
    if (!User.loggedIn()) {
      await this.$router.push("/");
    }
    await this.calcDate();
    await this.allBills();
    await this.getMixins();
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(3),
        bill_id: "",
        barcode:"",
      mixins: {},
      bill: null,
      bills: [],
      selected: "",
      searchTerm: "",
      period: false,
      reportName: "",
      hideMe: false,
      total: 1,
      page: 1,
      isPrint: false,
      current_page: "",
      reportPeriod: {
        to: null,
        from: null,
      },
      billTypes: [],
    };
  },

  methods: {
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
    async getMixins() {
      await axios
        .get("/api/mixins/1")
        .then(({ data }) => {
          localStorage.setItem("vat", data.mixins_vat_val);
          this.mixins = data;
        })
        .catch((error) => console.log(error));
    },
    print(bill) {
      this.bill = bill;
    },
    async preparePrint(bill) {
      await this.print(bill);
      $("#printer").click();
      this.bill = null;
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
    showBillDetails(bill) {
      this.billTypes = bill;
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
<style>
@media print {
  .hideMeInPrint {
    display: none;
  }
}

th.hideMeInPrint,
td.hideMeInPrint {
  text-decoration: line-through;
}
</style>
