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
            <h6 class="m-0 font-weight-bold text-primary">كل الموظفون</h6>
            <router-link
              class="m-0 font-weight-bold text-primary"
              to="/create/worker"
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
                      <th class="col-header" style="width: 15%">الهاتف</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="worker in workers" class="ErrorRow">
                      <td>
                        <router-link
                          :to="{
                            name: 'edit-worker',
                            params: { id: worker.id },
                          }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          class="btn btn-sm btn-danger"
                          @click="deleteAction(worker.id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td>{{ worker.id }}</td>
                      <td>{{ worker.name }}</td>
                      <td>{{ worker.mobile }}</td>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
                </table>
                <div v-show="workers.length > 0" class="row text-center">
                  <ul class="pagination justify-content-center">
                    <li :class="page == 1 ? 'page-item disabled' : 'page-item'">
                      <button class="page-link" @click="nextPage(1)">
                        البداية
                      </button>
                    </li>
                    <li class="page-item">
                      <button
                        class="page-link"
                        @click="nextPage(current_page - 1)"
                      >
                        السابق
                      </button>
                    </li>
                    <li
                      class="page-item d-none"
                      v-for="(i, index) in total"
                      @click="nextPage(i)"
                    >
                      <button class="page-link">{{ i }}</button>
                    </li>
                    <li class="page-item">
                      <button
                        class="page-link"
                        @click="nextPage(current_page + 1)"
                      >
                        التالي
                      </button>
                    </li>
                    <li
                      :class="
                        page == total + 1 ? 'page-item disabled' : 'page-item'
                      "
                    >
                      <a class="page-link" @click="nextPage(total + 1)"
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

      <MixinsSpinner
        v-show="loading"
        class="text-center bg-info text-light"
        dir="rtl"
      >
      </MixinsSpinner>
    </div>
  </div>
</template>

<script>
import MixinsSpinner from "../spinner/mixinsSpinner";
export default {
  components: { MixinsSpinner },
  created() {
    if (!User.loggedIn()) {
      this.$router.push("newBill");
    }
    this.allworkers();
  },
  data() {
    return {
      workers: {},
      searchTerm: "",
      loading: true,
      total: 1,
      page: 1,
      current_page: "",
    };
  },
  computed: {
    filterSearch() {
      return this.workers.length > 0
        ? this.workers.filter((worker) => {
            return worker.name.match(this.searchTerm);
          })
        : "";
    },
  },
  methods: {
    allworkers() {
      axios
        .get("/api/workers?page=" + this.page)
        .then(({ data }) => {
          if (data.data.length >= 0 || !data.data.isEmpty) {
            this.loading = false;
            this.total = parseInt(data.total / data.per_page);
            this.workers = data.data;
            this.current_page = data.current_page;
          }
        })
        .catch((error) => console.log(error));
    },

    nextPage(i) {
      this.page = i;
      this.allworkers();
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
            .delete("/api/workers/" + id)
            .then(() => {
              this.workers = this.workers.filter((worker) => {
                return worker.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "workers" });
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
