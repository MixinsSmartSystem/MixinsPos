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
            <h6 class="m-0 font-weight-bold text-primary">كل المنتجات</h6>
            <router-link
              class="m-0 font-weight-bold text-primary"
              to="/create/offer"
              >إضافة</router-link
            >
            <button
              class="btn btn-primary"
              onclick="download('xlsx','offers');"
              type="submit"
            >
              <i class="fa fa-file-excel"></i>
            </button>
          </div>
          <div class="w-100 dragscroll table-wrapper">
            <div id="pagewrap" class="row">
              <div id="body" class="col-sm-12">
                <table id="offers" class="text-center table-bordered">
                  <thead>
                    <tr>
                      <th class="col-header" style="width: 15%">إعدادات</th>
                      <th class="col-header" style="width: 15%">كود</th>
                      <th class="col-header" style="width: 15%">
                        اسم الصنف الرئيسي
                      </th>
                      <th class="col-header" style="width: 15%">
                        اسم صنف العرض
                      </th>
                      <th class="col-header" style="width: 15%">
                        نسبة الخصم على صنف العرض
                      </th>
                      <th class="col-header" style="width: 15%">
                        عدد الصنف الرئيسي
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="offer in offers" class="ErrorRow">
                      <td>
                        <router-link
                          :to="{ name: 'edit-offer', params: { id: offer.id } }"
                          class="btn btn-sm btn-primary"
                          ><i class="fa fa-edit"></i>
                        </router-link>
                        <a
                          class="btn btn-sm btn-danger"
                          @click="deleteAction(offer.id)"
                          ><i class="fa fa-trash"></i
                        ></a>
                      </td>
                      <td>{{ offer.id }}</td>
                      <td>{{ offer.main_offer_type.type_name_ar }}</td>
                      <td>{{ offer.offer_type.type_name_ar }}</td>
                      <td>{{ offer.offer_discount_percent }}</td>
                      <td>{{ offer.main_type_count }}</td>
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
      this.$router.push("/");
    }
    this.alloffers();
  },
  data() {
    return {
      offers: [],
      searchTerm: "",
      loading: true,
    };
  },
  computed: {
    filterSearch() {
      return this.offers.length > 0
        ? this.offers.filter((offer) => {
            return offer.id.match(this.searchTerm);
          })
        : "";
    },
  },
  methods: {
    alloffers() {
      axios
        .get("/api/offers")
        .then(({ data }) => {
          if (!data.isEmpty) {
            this.loading = false;

            this.offers = data;
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
            .delete("/api/offers/" + id)
            .then(() => {
              this.offers = this.offers.filter((offer) => {
                return offer.id != id;
              });
            })
            .catch(() => {
              this.$router.push({ name: "offers" });
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
