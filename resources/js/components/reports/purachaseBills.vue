<template>
  <div>
    <div id="pagewrap">
      <div id="body">
        <div class="row justify-content-center">
          <div class="card mb-4">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
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
                    <button
                      class="
                        collapsed
                        btn btn-secondary
                        font-weight-bold
                        text-light
                      "
                      @click="showBill = !showBill"
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseTwo"
                      aria-expanded="false"
                      aria-controls="collapseTwo"
                    >
                      تقرير فواتير الشراء
                      <i v-if="showBill" class="fa fa-angle-double-down"></i>
                      <i v-else="" class="fa fa-angle-double-up"></i>
                    </button>
                  </h6>

                  <button
                    class="btn btn-success"
                    onclick="download('xlsx','purachaseBills');"
                    type="submit"
                  >
                    <i class="fa fa-file-excel"></i>
                  </button>
                </div>
              </h2>
              <div
                id="collapseTwo"
                :class="
                  showBill
                    ? 'accordion-collapse collapse show'
                    : 'accordion-collapse collapse'
                "
                aria-labelledby="headingTwo"
                data-bs-parent="#accordionExample"
              >
                <div class="accordion-body">
                  <div class="card-body">
                    <table
                      class="text-center table-bordered"
                      style="cellpadding: 20px; cellspacing: 0px; width: 100%"
                      id="purachaseBills"
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
                          v-for="bill in purachaseBills"
                          :key="bill.purchase_bill_no"
                          @click="selected = bill.purchase_bill_no"
                        >
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.purchase_bill_no }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_sum }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_vat_val }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_total }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_discount_val }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_paid_val }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_remain_val }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.bill_date }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.pay_methods.pay_method_name }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.customer ? bill.customer.cust_name : "" }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.user ? bill.user.name : "" }}
                          </td>
                          <td
                            :class="
                              selected === bill.purchase_bill_no
                                ? 'selected'
                                : ''
                            "
                          >
                            {{ bill.purchase_bill_notes }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body"></div>
          </div>
          <div class="accordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
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
                    <button
                      class="btn btn-secondary font-weight-bold text-light"
                      @click="
                        calc();
                        show = !show;
                      "
                      type="button"
                      data-bs-toggle="collapse"
                      data-bs-target="#collapseOne"
                      aria-expanded="true"
                      aria-controls="collapseOne"
                    >
                      تفاصيل الفواتير
                      <i v-if="show" class="fa fa-angle-double-down"></i>
                      <i v-else="" class="fa fa-angle-double-up"></i>
                    </button>
                  </h6>
                </div>
              </h2>
              <div
                id="collapseOne"
                :class="
                  show
                    ? 'accordion-collapse collapse show'
                    : 'accordion-collapse collapse'
                "
                aria-labelledby="headingOne"
              >
                <div class="accordion-body">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-4">
                        <ul class="list-group">
                          <div class="list-group-item my-2 p-0">
                            <div>
                              <b class="btn"> اجمالي الفواتير:</b>
                              <b class="btn float-left"> {{ billTotal }}</b>
                            </div>
                          </div>
                          <div class="list-group-item my-2 p-0 d-none">
                            <div>
                              <b class="btn"> اجمالي الضريبة:</b>
                              <b class="btn float-left"> {{ billTotalVat }}</b>
                            </div>
                          </div>
                          <div class="list-group-item my-2 p-0 d-none">
                            <div>
                              <b class="btn">الاجمالي بدون الضريبة:</b>
                              <b class="btn float-left">
                                {{ billTotal - billTotalVat }}</b
                              >
                            </div>
                          </div>
                        </ul>
                      </div>
                      <div class="col-4">
                        <ul class="list-group">
                          <div class="list-group-item my-2 p-0">
                            <div>
                              <b class="btn"> إجمالي الفواتير المدفوعة كاش:</b>
                              <b class="btn float-left"> {{ paidCash }}</b>
                            </div>
                          </div>
                          <div class="list-group-item my-2 p-0">
                            <div>
                              <b class="btn"> إجمالي الفواتير المدفوعة فيزا:</b>
                              <b class="btn float-left"> {{ paidVisa }}</b>
                            </div>
                          </div>
                          <div class="list-group-item my-2 p-0">
                            <div>
                              <b class="btn"> إجمالي الفواتير المدفوعة آجل:</b>
                              <b class="btn float-left"> {{ paidLater }}</b>
                            </div>
                          </div>
                        </ul>
                      </div>
                    </div>
                  </div>
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
  name: "purachaseBills",
  props: ["purachaseBills", "hideMe"],
  created() {
    if (!User.loggedIn()) {
      this.$router.push("newBill");
    }
    this.period = this.$route.params.period;
    this.calc();
  },
  data() {
    return {
      billTotal: 0,
      billTotalVat: 0,
      paidCash: 0,
      selected: "",
      paidVisa: 0,
      paidLater: 0,
      show: false,
      showBill: true,
    };
  },
  methods: {
    calc() {
      this.billTotal = 0;
      this.billTotalVat = 0;
      this.paidCash = 0;
      this.paidVisa = 0;
      this.paidLater = 0;
      for (let bill of this.purachaseBills) {
        this.billTotal += bill.bill_total;
        this.billTotalVat += bill.bill_vat_val;
        switch (bill.pay_methods.id) {
          case 1:
            this.paidCash += bill.bill_paid_val;
            break;
          case 2:
            this.paidVisa += bill.bill_paid_val;

            break;
          case 3:
            this.paidLater += bill.bill_total;
            break;
          default:
        }
      }
      this.billTotal = Number(this.billTotal).toFixed(2);
      this.billTotalVat = Number(this.billTotalVat).toFixed(2);
      this.paidCash = Number(this.paidCash).toFixed(2);
      this.paidVisa = Number(this.paidVisa).toFixed(2);
      this.paidLater = Number(this.paidLater).toFixed(2);
    },
  },
};
</script>

