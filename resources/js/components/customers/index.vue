<template>
  <div>
    <div v-if="hasRole" class="row">
      <!-- Datatables -->
      <div v-show="!loading" class="col-lg-12">
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
            <h6 class="m-0 font-weight-bold text-primary">كل المنتجات</h6>
            <router-link
              class="m-0 font-weight-bold text-primary"
              to="/create/customer"
              >إضافة</router-link
            >
            <button
              class="btn btn-primary"
              onclick="download('xlsx');"
              type="submit"
            >
              <i class="fa fa-file-excel"></i>
            </button>
            <a class="btn btn-info" href="javascript:timedRefresh(2000)">
              <i class="fa fa-sort"></i>
            </a>
            <h6 class="m-0 font-weight-bold text-primary float-left">
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
          </div>
          <div class="w-100 table-wrapper">
            <div id="pagewrap" class="row">
              <div id="body" class="col-sm-12">
                <table id="resultTable" class="text-center table-bordered">
                  <thead>
                    <tr>
                      <th
                        v-show="
                          $root.$data.roles.includes(14) ||
                          $root.$data.roles.includes(20)
                        "
                        class="col-header"
                        style="width: 15%"
                      >
                        إعدادات
                      </th>
                      <th class="col-header" style="width: 15%">كود</th>
                      <th class="col-header" style="width: 15%">الاسم</th>
                      <th class="col-header" style="width: 15%">الهاتف</th>
                      <th class="col-header" style="width: 15%">العنوان</th>
                      <th class="col-header" style="width: 15%">رصيد العميل</th>
                      <th class="col-header" style="width: 15%">قيمة الخصم</th>
                      <th class="col-header" style="width: 15%">نسبة الخصم</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="customer in filterSearch" class="ErrorRow">
                      <td>
                        <router-link
                          v-show="$root.$data.roles.includes(14)"
                          :to="{
                            name: 'edit-customer',
                            params: { id: customer.cust_id },
                          }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          v-show="$root.$data.roles.includes(20)"
                          class="btn btn-sm btn-danger"
                          @click="deleteAction(customer.cust_id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td>{{ customer.cust_id }}</td>
                      <td>{{ customer.cust_name }}</td>
                      <td>{{ customer.cust_mobile }}</td>
                      <td>{{ customer.cust_address }}</td>
                      <td>{{ customer.cust_balance }}</td>
                      <td>{{ customer.cust_discount_percent }}</td>
                      <td>{{ customer.cust_discount_val }}</td>
                      <div
                        class="modal fade"
                        :id="'pay-' + customer.cust_id"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                      >
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">
                                Modal title
                              </h5>
                              <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                              >
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">...</div>
                            <div class="modal-footer">
                              <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                              >
                                Close
                              </button>
                              <button type="button" class="btn btn-primary">
                                Save changes
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
                </table>
                <div v-show="customers.length > 0" class="row text-center">
                  <ul class="pagination justify-content-center">
                    <li :class="page == 1 ? 'page-item disabled' : 'page-item'">
                      <a class="page-link" href="#" @click="nextPage(1)"
                        >البداية</a
                      >
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        href="#"
                        @click="nextPage(current_page - 1)"
                        >السابق</a
                      >
                    </li>
                    <li
                      class="page-item d-none"
                      v-for="(i, index) in total"
                      @click="nextPage(i)"
                    >
                      <a class="page-link" href="#">{{ i }}</a>
                    </li>
                    <li class="page-item">
                      <a
                        class="page-link"
                        href="#"
                        @click="nextPage(current_page + 1)"
                        >التالي</a
                      >
                    </li>
                    <li
                      :class="
                        page == total + 1 ? 'page-item disabled' : 'page-item'
                      "
                    >
                      <a class="page-link" href="#" @click="nextPage(total + 1)"
                        >الاخير</a
                      >
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- DataTable with Hover -->
    </div>
    <Security v-else></Security>
    <Spinner v-show="loading"></Spinner>
  </div>
</template>

<script>
import Spinner from "../spinner/mixinsSpinner";
import Security from "../spinner/security";

export default {
  components: { Spinner, Security },

  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
    this.allCustomers();
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(10),

      customer: {},
      searchTerm: "",
      loading: true,
      total: 1,
      page: 1,
      current_page: "",
      customers: [],
    };
  },
  computed: {
    filterSearch() {
      return this.customers.length > 0
        ? this.customers.filter((customer) => {
            return customer.cust_name.match(this.searchTerm);
          })
        : "";
    },
  },
  methods: {
    allCustomers() {
      axios
        .get("/api/customers?page=" + this.page)
        .then(({ data }) => {
          if (data.data.length >= 0) {
            this.loading = false;
            this.total = parseInt(data.total / data.per_page);
            this.customers = data.data;
            this.current_page = data.current_page;
          }
        })
        .catch((error) => console.log(error));
    },

    nextPage(i) {
      this.page = i;
      this.allcustomer();
    },

    deleteAction(id) {
      Swal.fire({
        title: "هل تريد حذف الصنف؟",
        text: "لايمكن الاسترجاع عن هذا!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "تأكيد حذف لصنف!",
        cancelButtonText: "إلغاء",
      }).then((result) => {
        if (result.value) {
          axios
            .delete("/api/customers/" + id)
            .then(() => {
              this.customers = this.customers.filter((customer) => {
                return customer.cust_id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "customers" });
            });
          Swal.fire("حذف!", "تم الحذف.", "success");
        }
      });
    },
  },
};
</script>
<style>
a,
a:hover {
  text-decoration: none;
  font-weight: bolder;
}

.bg-info {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
}

.spinner-border {
  margin: 50vh auto !important;
}

table.table-fit {
  width: auto !important;
  table-layout: auto !important;
}

table.table-fit thead th,
table.table-fit tfoot th {
  width: auto !important;
}

table.table-fit tbody td,
table.table-fit tfoot td {
  width: auto !important;
}
</style>
