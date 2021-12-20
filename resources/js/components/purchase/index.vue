<template>
  <div>
    <div v-if="hasRole" class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
        <div class="card mb-4">
          <div
            class="
              card-header
              d-flex
              flex-row
              align-items-center
              justify-content-between
            "
          >
            <h1 class="text-center hideMeInPrint my-0 btn-sm d-block">
              فواتير الشراء
            </h1>
            <button
              class="btn hideMeInPrint btn-primary"
              onclick="download('xlsx','resultTable');"
              type="submit"
            >
              <i class="fa fa-file-excel"></i>
            </button>
            <a
              class="btn hideMeInPrint btn-info"
              href="javascript:timedRefresh(2000)"
            >
              <i class="fa fa-sort"></i>
            </a>
            <button
              class="hideMeInPrint btn btn-success btn-sm"
              onclick="window.print()"
              type="submit"
            >
              طباعة
            </button>

            <h6
              class="m-0 hideMeInPrint font-weight-bold text-primary float-left"
            >
              <div id="search">
                <input
                  id="filter"
                  class="form-control-sm"
                  name="filter"
                  type="text"
                  value=""
                />
              </div>
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
          <div
            class="table-responsive dragscroll table-wrapper"
            style="height: 50vh"
          >
            <div id="pagewrap">
              <div id="body">
                <table
                  id="resultTable"
                  class="text-center table-bordered"
                  style="cellpadding: 20px; cellspacing: 0px; width: 100%"
                >
                  <thead>
                    <tr>
                      <th class="col-header" style="width: 5%">رقم الفاتورة</th>
                      <th class="col-header" style="width: 10%">المجموع</th>
                      <th class="col-header" style="width: 10%">
                        ضريبة القيمة المضافة
                      </th>
                      <th class="col-header" style="width: 10%">الاجمالي</th>
                      <th class="col-header" style="width: 5%">الخصم</th>
                      <th class="col-header" style="width: 10%">المدفوع</th>
                      <th class="col-header" style="width: 10%">المتبقي</th>
                      <th class="col-header" style="width: 20%">
                        تاريخ الفاتورة
                      </th>
                      <th class="col-header" style="width: 10%">المورد</th>
                      <th class="col-header" style="width: 10%">المستخدم</th>
                      <th class="col-header" style="width: 10%">ملاحظات</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="bill in bills"
                      :key="bill.bill_no"
                      class="ErrorRow"
                      @click="showBillDetails(bill.bill_type)"
                    >
                      <td>{{ bill.bill_no }}</td>
                      <td>{{ bill.bill_sum }}</td>
                      <td>{{ bill.bill_vat_val }}</td>
                      <td>{{ bill.bill_total }}</td>
                      <td>{{ bill.bill_discount_val }}</td>
                      <td>{{ bill.bill_paid_val }}</td>
                      <td>{{ bill.bill_remain_val }}</td>
                      <td>{{ bill.bill_date }}</td>
                      <td>
                        {{ bill.supplier ? bill.supplier.supplier_name : "" }}
                      </td>
                      <td>{{ bill.user ? bill.user.name : "" }}</td>

                      <td>{{ bill.bill_notes }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="table-responsive hideMeInPrint" style="height: 50vh">
            <div class="row text-center">
              <th class="col-1">كود الصنف</th>
              <th class="col-2">اسم الصنف</th>
              <th class="col-1">العدد</th>
              <th class="col-1">سعر الشراء</th>
              <th class="col-1" v-show="$root.$data.mixins.use_type_uints">
                الوحدة
              </th>
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
              <td class="col-1">{{ type.type_purchase_price }}</td>
              <td class="col-1" v-show="$root.$data.mixins.use_type_uints">
                {{ type.sill_unit }}
              </td>
              <td class="col-1">{{ type.total_purchase_price }}</td>
              <td class="col-5">{{ type.type_note }}</td>
            </div>
          </div>
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
    this.calcDate();
    this.allBills();
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(7),

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
      billTypes: [],
    };
  },
  computed: {
    filterSearch() {
      return bills.length > 0
        ? this.bills.filter((bill) => {
            return bill.bill_no.match(this.searchTerm);
          })
        : "";
    },
  },
  methods: {
    nextPage(i) {
      this.page = i;
      this.allBills();
    },
    allBills() {
      axios
        .get(
          "/api/bill/purchases/report/" +
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
