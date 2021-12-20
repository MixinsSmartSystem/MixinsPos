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
              to="/create/type"
              >إضافة</router-link
            >
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
            <h6 class="m-0 font-weight-bold text-primary float-left">
              <div id="search">
                <input
                  id="filter"
                  v-model="typeName"
                  @keyup="findTypeByLike"
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
                      <th class="col-header" style="width: 15%">
                        باركود الصنف
                      </th>
                      <th class="col-header" style="width: 25%">
                        اسم الصنف عربي
                      </th>
                      <th class="col-header" style="width: 20%">
                        اسم الصنف انجليزي
                      </th>
                      <th class="col-header" style="width: 10%">صورة الصنف</th>
                      <th class="col-header" style="width: 10%">سعر الشراء</th>
                      <th class="col-header" style="width: 20%">سعر البيع</th>
                      <th class="col-header" style="width: 10%">
                        أقل سعر البيع
                      </th>
                      <th class="col-header" style="width: 10%">نسبة الخصم</th>
                      <th class="col-header" style="width: 10%">قيمة الخصم</th>
                      <th class="col-header" style="width: 10%">المخزون</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="type in types" class="ErrorRow">
                      <td v-if="!isNewbill">
                        <router-link
                          :to="{
                            name: 'edit-type',
                            params: { id: type.type_id },
                          }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          class="btn btn-sm btn-danger"
                          @click="deleteType(type.type_id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td v-else="">
                        <button
                          type="button"
                          class="btn btn-sm btn-primary"
                          @click="addToCart(type)"
                        >
                          <i class="fa fa-plus"></i>
                        </button>
                      </td>
                      <td class="sorting_1">{{ type.type_id }}</td>
                      <td class="">{{ type.type_barcode }}</td>
                      <td class="" style="overflow: auto">
                        {{ type.type_name_ar }}
                      </td>
                      <td>{{ type.type_name_en }}</td>
                      <td class="">
                        <!-- Button trigger modal -->
                        <button
                          v-show="
                            type.type_icon !== '' || type.type_icon != null
                          "
                          :data-target="'#exampleModalCenter-' + type.type_id"
                          class="btn btn-sm btn-primary"
                          data-toggle="modal"
                          type="button"
                        >
                          <i class="fa fa-search"></i>
                        </button>
                        <div
                          :id="'exampleModalCenter-' + type.type_id"
                          aria-hidden="true"
                          aria-labelledby="exampleModalCenterTitle"
                          class="modal fade"
                          role="dialog"
                          tabindex="-1"
                        >
                          <div
                            class="modal-dialog modal-dialog-centered"
                            role="document"
                          >
                            <div class="modal-content" style="width: 500px">
                              <div class="modal-body" style="width: 500px">
                                <img
                                  :src="type.type_icon"
                                  style="width: 100%; height: 100%"
                                />
                              </div>
                              <div class="modal-footer py-1">
                                <button
                                  class="btn-sm btn btn-secondary"
                                  data-dismiss="modal"
                                  type="button"
                                >
                                  إغلاق
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="">{{ type.type_purchases_price }}</td>
                      <td class="">{{ type.type_sill_price }}</td>
                      <td class="">{{ type.minimum_sill_price }}</td>
                      <td class="">{{ type.type_discount_percent }}</td>
                      <td class="">{{ type.type_discount_value }}</td>
                      <td>
                        {{
                          type.type_stock
                            ? type.type_stock.mixins_type_stock
                            : 0
                        }}
                      </td>
                    </tr>
                  </tbody>
                  <tfoot></tfoot>
                </table>
                <div v-show="types.length > 0" class="row text-center">
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

      <div v-show="loading" class="text-center" dir="rtl">
        <Spinner></Spinner>
      </div>
    </div>
    <Security v-else></Security>
  </div>
</template>

<script>
import Spinner from "../spinner/mixinsSpinner.vue";
import Security from "../spinner/security";

export default {
  components: { Security, Spinner },
  props: {
    isNewbill: Boolean,
    addToCart: Function,
  },

  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
    this.allTypes();
  },
  data() {
    return {
      hasRole: this.$root.$data.roles.includes(1),
      types: [],
      searchTerm: "",
      loading: true,
      total: 1,
      page: 1,
      current_page: "",
      typeName: "",
    };
  },
  computed: {
    filterSearch() {
      return this.types.filter((type) => {
        return type.type_name_ar.match(this.searchTerm);
      });
    },
  },
  methods: {
    findTypeByLike() {
      axios
        .get("/api/action/like/" + this.typeName)
        .then(({ data }) => {
          this.types = data;
        })
        .catch((error) => console.log(error));
    },
    allTypes() {
      axios
        .get("/api/types?page=" + this.page)
        .then(({ data }) => {
          if (data.data.length >= 0) {
            this.loading = false;
            this.total = parseInt(data.total / data.per_page);
            this.types = data.data;
            this.current_page = data.current_page;
          }
        })
        .catch((error) => console.log(error));
    },

    nextPage(i) {
      this.page = i;
      this.allTypes();
    },
    deleteType(id) {
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
            .delete("/api/types/" + id)
            .then(() => {
              this.types = this.types.filter((type) => {
                return type.type_id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "types" });
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
