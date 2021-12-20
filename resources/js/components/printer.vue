<template>
  <div v-if="bill">
    <a
      id="btn"
      class="btn btn-info text-light d-none"
      data-target="#printModal"
      data-toggle="modal"
      ><i class="fas fa-ellipsis-v"></i
    ></a>
    <div
      id="printModal"
      aria-hidden="true"
      aria-labelledby="printModal"
      class="modal fade"
      role="dialog"
      tabindex="-1"
    >
      <div
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        role="document"
      >
        <div class="modal-content m-auto" style="min-width: 850px">
          <div class="modal-header">
            <button
              aria-label="Close"
              class="close"
              data-dismiss="modal"
              type="button"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="printMe" class="modal-body">
            <div id="invoice-POS">
              <div id="top" style="text-align: center">
                <div class="logo">
                  <img
                    :src="mixins.mixins_logo"
                    style="width: 50px; height: 50px; border-radius: 50%"
                  />
                </div>
                <div class="info">
                  <h5>{{ mixins.mixins_name }}</h5>
                </div>
                <div class="info">
                  <h5>{{ mixins.mixins_adress }}</h5>
                </div>
                <div class="info">
                  <h5>{{ mixins.mixins_mobile }}</h5>
                </div>
                <!--End Info-->
              </div>
              <!--End InvoiceTop-->

              <div id="bot">
                <div id="table">
                  <table id="resultTable" class="text-center w-100">
                    <tr>
                      <td class="no-border">رقم الفاتوره</td>
                      <td class="no-border">{{ bill.bill_no }}</td>

                      <td class="no-border">تاريخ الفاتوره</td>
                      <td class="no-border">{{ bill.bill_date }}</td>
                    </tr>
                    <tr>
                      <td class="no-border" v-if="bill.user != null">
                        مستخدم النظام
                      </td>
                      <td class="no-border" v-if="bill.user != null">
                        {{ bill.user.name }}
                      </td>
                      <td class="no-border" v-if="bill.pay_methods != null">
                        طريقة الدفع
                      </td>
                      <td class="no-border" v-if="bill.pay_methods != null">
                        {{ bill.pay_methods.pay_method_name }}
                      </td>
                    </tr>
                    <tr v-if="bill.customer">
                      <td class="no-border">اسم العميل</td>
                      <td class="no-border">{{ bill.customer.cust_name }}</td>
                      <td class="no-border">هاتف العميل</td>
                      <td class="no-border">{{ bill.customer.cust_mobile }}</td>
                    </tr>
                    <tr v-if="bill.customer && bill.customer.cust_address">
                      <td class="no-border">عنوان العميل</td>

                      <td class="no-border">
                        {{ bill.customer.cust_address }}
                      </td>
                      <td class="no-border">رصيد العميل</td>

                      <td class="no-border">
                        {{ bill.customer.cust_balance }}
                      </td>
                    </tr>
                    <tr>
                      <th style="width: 40%">اسم الصنف</th>
                      <th style="width: 20%">العدد</th>
                      <th style="width: 20%">السعر</th>
                      <th style="width: 20%">الاجمالي</th>
                    </tr>
                    <tr
                      v-for="(type, index) in bill.bill_type"
                      :key="index"
                      class="ErrorRow"
                    >
                      <td>
                        {{ type.type.type_name_ar }}
                        <small class="d-block">{{ type.type_note }}</small>
                      </td>
                      <td>{{ type.type_count }}</td>
                      <td>{{ type.type_price }}</td>
                      <td>{{ type.type_total_price }}</td>
                    </tr>

                    <tr>
                      <td colspan="2" class="no-border">المجموع:</td>
                      <td colspan="2" class="no-border">{{ bill.bill_sum }}</td>
                    </tr>
                    <tr v-if="bill.bill_discount > 0">
                      <td colspan="2" class="no-border">الخصم:</td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_discount }}
                      </td>
                    </tr>
                    <tr v-if="bill.bill_extra > 0">
                      <td colspan="2" class="no-border">الاضافي:</td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_extra }}
                      </td>
                    </tr>
                    <tr v-if="bill.bill_vat_val > 0">
                      <td colspan="2" class="no-border">
                        ضريبة القيمة المضافة ({{ mixins.mixins_vat_val }}%):
                      </td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_vat_val }}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" class="no-border">الاجمالي:</td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_total }}
                      </td>
                    </tr>
                    <tr v-if="bill.bill_paid_val != bill.bill_total">
                      <td colspan="2" class="no-border">المدفوع:</td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_paid_val }}
                      </td>
                    </tr>
                    <tr v-if="bill.bill_remain_val != 0">
                      <td colspan="2" class="no-border">الباقي:</td>
                      <td colspan="2" class="no-border">
                        {{ bill.bill_remain_val }}
                      </td>
                    </tr>
                    <tfoot
                      v-if="bill.returns"
                      v-for="returnType in bill.returns"
                    >
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
                <!--End Table-->
              </div>
              <div
                v-if="
                  bill.customer != null &&
                  mixins.mixins_name != null &&
                  !mixins.mixins_name.isEmpty &&
                  mixins.contruct_no != null &&
                  !mixins.mixins_name.contruct_no
                "
                class="text-center"
              >
                <img :src="qr" />
              </div>
              <!--End InvoiceBot-->
            </div>
            <!--End Invoice-->
          </div>
          <div class="modal-footer text-center">
            <button
              id="print"
              class="btn btn-secondary"
              data-dismiss="modal"
              type="button"
            >
              إغلاق
            </button>
            <button id="printer" class="btn btn-success" @click="print()">
              طباعة
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Invoice } from "@axenda/zatca";

export default {
  props: ["bill", "qr"],
  data() {
    return {
      isDone: false,
      mixins: this.$root.$data.mixins,
    };
  },
  methods: {
    print() {
      this.$htmlToPaper("printMe");
    },
  },
};
</script>

<style scoped>
</style>
