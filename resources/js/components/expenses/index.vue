<template>
  <div>
    <div class="row">
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
            <h6 class="m-0 font-weight-bold text-primary">كل المصروفات</h6>
            <router-link
              class="m-0 font-weight-bold text-primary"
              to="/create/expense"
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
          <div class="w-100 dragscroll table-wrapper">
            <div id="pagewrap" class="row">
              <div id="body" class="col-sm-12">
                <table id="resultTable" class="text-center table-bordered">
                  <thead>
                    <tr>
                      <th class="col-header" style="width: 15%">إعدادات</th>

                      <th class="col-header" style="width: 15%">كود</th>
                      <th class="col-header" style="width: 15%">الاسم</th>
                      <th class="col-header" style="width: 15%">التكلفة</th>
                      <th class="col-header" style="width: 15%">الفاتورة</th>
                      <th class="col-header" style="width: 15%">التاريخ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="expense in expenses" class="ErrorRow">
                      <td>
                        <router-link
                          :to="{
                            name: 'edit-expense',
                            params: { id: expense.id },
                          }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          class="btn btn-sm btn-danger"
                          @click="deleteAction(expense.id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td>{{ expense.id }}</td>
                      <td>{{ expense.expense_title }}</td>
                      <td>{{ expense.expense_cost }}</td>
                      <td>
                        <img
                          :src="expense.expense_icon"
                          class="card-img-top w-25 h-25 float-left ml-auto"
                        />
                      </td>
                      <td>{{ expense.expense_date }}</td>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- DataTable with Hover -->

      <div v-show="loading" class="text-center bg-info text-light" dir="rtl">
        <MixinsSpinner />
      </div>
    </div>
  </div>
</template>

<script>
import MixinsSpinner from "../spinner/mixinsSpinner";
export default {
  components: { MixinsSpinner },
  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
    this.allExpenses();
  },
  data() {
    return {
      expenses: [],
      searchTerm: "",
      loading: true,
    };
  },
  methods: {
    allExpenses() {
      axios
        .get("/api/expenses")
        .then(({ data }) => {
          if (data.length >= 0) {
            this.loading = false;
            this.expenses = data;
          }
        })
        .catch((error) => console.log(error));
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
            .delete("/api/expenses/" + id)
            .then(() => {
              this.expenses = this.expenses.filter((expense) => {
                return expense.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "expenses" });
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
