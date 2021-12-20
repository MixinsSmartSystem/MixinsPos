<template>
  <div>
    <div class="row justify-content-center text-center">
      <div class="card mb-4 text-center">
        <div class="card-header">
          <div class="input-group m-auto">
            <div
              class="input-group-prepend m-auto"
              style="width: 100px !important"
            >
              <input
                class="form-control-sm"
                placeholder="رقم الفاتورة"
                type="text"
                v-model="bill_id"
                @keyup="findBill()"
              />
            </div>
          </div>
        </div>

        <div class="card-body">
          <table
            id="bills"
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
                <th class="col-header" style="width: 20%">تاريخ الفاتورة</th>
                <th class="col-header" style="width: 5%">طريقة الدفع</th>
                <th class="col-header" style="width: 10%">العميل</th>
                <th class="col-header" style="width: 10%">المستخدم</th>
                <th class="col-header" style="width: 10%">ملاحظات</th>
                <th class="col-header" style="width: 10%">طباعة</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="bill in bills"
                :key="bill.bill_no"
                @click="
                  showBillDetails(bill);
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
                <td :class="selected === bill.bill_no ? 'selected' : ''">
                  <a class="btn btn-sm btn-success" @click="preparePrint(bill)">
                    <i class="fa fa-print text-light"></i>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
          <table v-show="bills.length > 0" class="text-center">
            <thead>
              <tr>
                <th class="col-header" style="width: 50%">اسم الصنف</th>
                <th class="col-header" style="width: 10%">العدد</th>
                <th class="col-header" style="width: 10%">السعر</th>
                <th class="col-header" style="width: 10%">اجمالي المرتجعات</th>
                <th class="col-header" style="width: 10%">الاجمالي</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in form.bill_type" :key="index">
                <td
                  :class="
                    product.returned
                      ? 'font-weight-bold   text-light bg-secondary'
                      : 'font-weight-bold'
                  "
                  :style="product.has_Offer ? 'color:red!important' : ''"
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
                      ? 'font-weight-bold   text-light bg-secondary'
                      : 'font-weight-bold'
                  "
                >
                  <b class="btn text-bold">{{ product.returned_total }}</b>
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
                <td class="font-weight-bold text-light bg-secondary text-light">
                  {{ product.returned_qty }}
                </td>
                <td class="font-weight-bold text-light bg-secondary text-light">
                  {{ product.type_price }}
                </td>
                <td class="font-weight-bold text-light bg-secondary text-light">
                  {{ product.returned_qty }}
                </td>
                <td class="font-weight-bold text-light bg-secondary text-light">
                  {{ product.returned_total }}
                </td>
                <td class="font-weight-bold text-light bg-secondary text-light">
                  {{ product.type_total_price }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <Printer :bill="bill" :qr="qr" />
  </div>
</template>

<script>
import Printer from "../printer";
import Spinner from "../spinner/mixinsSpinner";
import Security from "../spinner/security";
import { Invoice } from "@axenda/zatca";

export default {
  components: { Printer, Spinner, Security },

  async created() {
    if (!User.loggedIn()) {
      await this.$router.push("newBill");
    }
  },
  data() {
    return {
      bill: null,
      bills: [],
      qr: "",
      bill_id: "",
      selected: "",
      form: {},
    };
  },
  methods: {
    async findBill() {
      await axios
        .get("api/action/findBillById/" + this.bill_id)
        .then(({ data }) => {
          console.log(data);
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
    async print(bill) {
      this.bill = bill;
      if (this.bill != null && this.bill.customer != null) {
        const invoice = new Invoice({
          sellerName: this.bill.customer.cust_name,
          vatRegistrationNumber: this.mixins.contruct_no,
          invoiceTimestamp: this.bill.bill_date,
          invoiceTotal: this.bill.bill_total,
          invoiceVatTotal: this.bill.bill_vat_val,
        });
        this.qr = await invoice.render();
      }
    },
    async preparePrint(bill) {
      await this.print(bill);
      $("#printer").click();
      this.bill = null;
    },
    async showBillDetails(bill) {
      this.form = bill;
    },
  },
};
</script>


