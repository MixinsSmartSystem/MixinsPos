<template>
  <div>
    <div class="row">
      <!-- Datatables -->
      <div class="col-lg-12">
        <div class="card mb-4" id="allReport">
          <div
            class="
              card-header
              d-flex
              flex-row
              align-items-center
              justify-content-between
              hideMeInPrint
            "
          >
            <h1 class="text-center my-0 btn-sm d-block">
              تقرير {{ reportName }}
            </h1>
            <button
              class="btn btn-primary"
              type="submit"
              onclick="download('xlsx','allReport');"
            >
              <i class="fa fa-file-excel"></i>
            </button>
            <a class="btn btn-info" href="javascript:timedRefresh(2000)">
              <i class="fa fa-sort"></i>
            </a>
            <button
              class="btn btn-success btn-sm"
              onclick="window.print()"
              type="submit"
            >
              طباعة
            </button>

            <h6 class="m-0 font-weight-bold text-primary float-left">
              <div id="search">
                <input
                  class="form-control-sm"
                  type="text"
                  name="filter"
                  value=""
                  id="filter"
                />
              </div>
            </h6>
            <form
              class="needs-validation mt-2 hideMeInPrint"
              v-show="!period"
              @submit.prevent="veiwReport"
            >
              <div class="form-row">
                <div class="col-md-5">
                  <div class="input-group">
                    <div class="input-group-prepend input-sm">
                      <span
                        class="input-group-text"
                        id="validationTooltipUsernamePrepend"
                        >من</span
                      >
                    </div>
                    <input
                      type="date"
                      class="form-control"
                      v-model="reportPeriod.form"
                      id="validationTooltipUsername"
                      placeholder="Username"
                      aria-describedby="validationTooltipUsernamePrepend"
                      required
                    />
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="input-group">
                    <div class="input-group-prepend float-right input-sm">
                      <span class="input-group-text" for="to">الى</span>
                    </div>
                    <input
                      type="date"
                      class="form-control"
                      v-model="reportPeriod.to"
                      placeholder="Username"
                      aria-describedby="validationTooltipUsernamePrepend"
                      required
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
            style="height: 100vh"
          >
            <Bills
              :bills="bills"
              @hideMeInPrint="hideMeInPrint"
              :hideMe="hideMe"
            />
            <PurachaseBills
              :purachaseBills="purachaseBills"
              @hideMeInPrint="hideMeInPrint"
              :hideMe="hideMe"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Bills from "./bills";
import PurachaseBills from "./purachaseBills";

export default {
  components: { Bills, PurachaseBills },
  created() {
    if (!User.loggedIn()) {
      this.$router.push("/");
    }
    this.period = this.$route.params.period;
    this.$route.params.period == "daily"
      ? (this.reportName = "اليوم")
      : this.$route.params.period == "monthly"
      ? (this.reportName = "الشهر")
      : (this.reportName = "الفترة");
    this.allBills();
    this.allPurachaseBills();
  },
  data() {
    return {
      bills: [],
      purachaseBills: [],
      searchTerm: "",
      period: false,
      reportName: "",
      hideMe: false,
      reportPeriod: {
        to: null,
        form: null,
      },
      total: 1,
      page: 1,
      current_page: "",
    };
  },
  methods: {
    editTodo() {
      alert("s");
    },
    nextPage(i) {
      this.page = i;
      this.allBills();
    },
    veiwReport() {
      this.allBills();
      this.allPurachaseBills();
    },
    allBills() {
      if (this.reportPeriod.form != null && this.reportPeriod.to != null) {
        axios
          .get(
            "/api/bill/report/period/" +
              this.reportPeriod.form +
              "/" +
              this.reportPeriod.to
          )
          .then(({ data }) => {
            if (data.length > 0) {
              // this.loading = false;

              this.bills = data;
            }
          })
          .catch((error) => console.log(error));
      } else {
        axios
          .get(
            "/api/bill/report/" +
              this.period +
              "/" +
              this.reportPeriod.form +
              "/" +
              this.reportPeriod.to
          )
          .then(({ data }) => {
            if (data.length > 0) {
              // this.loading = false;

              this.bills = data;
            }
          })
          .catch((error) => console.log(error));
      }
    },
    allPurachaseBills() {
      if (this.reportPeriod.form != null && this.reportPeriod.to != null) {
        axios
          .get(
            "/api/bill/purchases/report/period/" +
              this.reportPeriod.form +
              "/" +
              this.reportPeriod.to
          )
          .then(({ data }) => {
            if (data.length > 0) {
              // this.loading = false;

              this.purachaseBills = data;
            }
          })
          .catch((error) => console.log(error));
      } else {
        axios
          .get(
            "/api/bill/purchases/report/" +
              this.period +
              "/" +
              this.reportPeriod.form +
              "/" +
              this.reportPeriod.to
          )
          .then(({ data }) => {
            if (data.length > 0) {
              // this.loading = false;

              this.purachaseBills = data;
            }
          })
          .catch((error) => console.log(error));
      }
    },
    hideMeInPrint() {
      this.hideMe = !this.hideMe;
    },
  },
};
</script>
<style>
input {
  border: 1px solid #c4c4c4;
  border-radius: 5px;
  background-color: #fff;
  padding: 3px 5px;
  box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
}

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

