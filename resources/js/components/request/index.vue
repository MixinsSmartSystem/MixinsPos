<template>
  <div>
    <div class="row">
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
              @submit.prevent="allRequests"
            >
              <div class="form-row">
                <div class="col-md-5">
                  <div class="input-group">
                    <div class="input-group-prepend">
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
                    <div class="input-group-prepend float-right">
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
                      <th class="col-header" style="width: 5%">كود الصنف</th>
                      <th class="col-header" style="width: 10%">اسم الصنف</th>
                      <th class="col-header" style="width: 10%">
                        تاريخ الاضافة
                      </th>
                      <th class="col-header" style="width: 10%">طلب الصنف</th>
                      <th class="col-header" style="width: 5%">حذف</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="type in requetsts" class="ErrorRow">
                      <td>{{ type.type_request }}</td>
                      <td>{{ type.type.type_name_ar }}</td>
                      <td>{{ type.added_request_date }}</td>
                      <td>{{ type.add_to_request }}</td>
                      <td>{{ type.type_request }}</td>
                    </tr>
                  </tbody>
                </table>
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
  created() {
    if (!User.loggedIn()) {
      this.$router.push("newBill");
    }
    this.calcDate();
    this.allRequests();
  },
  data() {
    return {
      requetsts: [],
      searchTerm: "",
      period: false,
      reportName: "",
      hideMe: false,
      total: 1,
      page: 1,
      current_page: "",
      status: 1,
      reportPeriod: {
        to: null,
        from: null,
      },
    };
  },
  computed: {
    filterSearch() {
      return this.requetsts.length > 0
        ? this.requetsts.filter((requetst) => {
            return requetst.mixins_item_request_id.match(this.searchTerm);
          })
        : "";
    },
  },
  methods: {
    nextPage(i) {
      this.page = i;
      this.allRequests();
    },
    allRequests() {
      axios
        .get(
          "/api/item/request/report/" +
            this.reportPeriod.from +
            "/" +
            this.reportPeriod.to +
            "/" +
            this.status
        )
        .then(({ data }) => {
          if (data.length >= 0) {
            // this.loading = false;
            this.requetsts = data;
          }
        })
        .catch((error) => console.log(error));
    },

    calcDate() {
      var lastDate = new Date();
      lastDate.setDate(lastDate.getDate() - 1);
      this.reportPeriod.from = lastDate
        .toJSON()
        .slice(0, 10)
        .replace(/-/g, "-");
      this.reportPeriod.to = new Date()
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
