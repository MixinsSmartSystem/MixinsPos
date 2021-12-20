<template>
  <div>
    <div class="row my-3">
      <div class="card-header text-center mb-2">
        <h5>الصفحة الرئيسية</h5>
      </div>
      <div
        class="col-md-2 col-sm-4"
        v-show="$root.$data.mixins.bill_type == 1"
      >
        <router-link
          class="card text-center p-0 w-100"
          to="/bill"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/invoices.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فاتورة جديدة</h5>
        </router-link>
      </div>
      <div
        class="col-md-2 col-sm-4"
        v-show="$root.$data.mixins.bill_type == 2"
      >
        <router-link
          class="card text-center p-0 w-100"
          to="/alert"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/invoices.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فاتورة جديدة</h5>
        </router-link>
      </div>
      <div
        class="col-md-2 col-sm-4"
        v-show="$root.$data.mixins.bill_type == 3"
      >
        <router-link
          class="card text-center p-0 w-100"
          to="/billWithUnits"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/invoices.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فاتورة جديدة</h5>
        </router-link>
      </div>
      <div
        class="col-md-2 col-sm-4"
        v-show="$root.$data.mixins.bill_type == 4"
      >
        <router-link
          class="card text-center p-0 w-100"
          to="/billWithUnitsAndAlert"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/invoices.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فاتورة جديدة</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(8)">
        <router-link
          class="card text-center p-0 w-100"
          to="/bills"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/bills.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">الفواتير</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(1)">
        <router-link
          class="card text-center p-0 w-100"
          to="/types"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/types.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">الأصناف</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/return"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/return.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">مرتجع بيع</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/offers"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/offer.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">عروض أصناف</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(7)">
        <router-link
          class="card text-center p-0 w-100"
          to="/purchase-bills"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/purchases.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فاتورة شراء</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(7)">
        <router-link
          class="card text-center p-0 w-100"
          to="/allPurchaseBills"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/bills-1.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">فواتير الشراء</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/suppliers"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/suppliers.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">الموردون</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/expenses"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/expenses.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">المصروفات</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(10)">
        <router-link
          class="card text-center p-0 w-100"
          to="/customers"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/customers.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">العملاء</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(10)">
        <router-link
          class="card text-center p-0 w-100"
          to="/cash"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/cash.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">صرف وتوريد نقدية</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/workers"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/worker.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">الموظفون</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/mainTypes"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/menu.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">التصنيفات</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(11)">
        <router-link
          class="card text-center p-0 w-100"
          to="/users"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/users.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">المستخدمون</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link
          class="card text-center p-0 w-100"
          to="/report"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/menu/reports.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">التقارير</h5>
        </router-link>
      </div>

      <div class="col-md-2 col-sm-4" v-if="$root.$data.roles.includes(2)">
        <router-link to="/mixins">
          <img
            class="card-img-top w-100"
            src="backend/img/menu/settings.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">الاعدادات</h5>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style scoped>
a,
h1,
h2,
h3,
h4,
h5,
h6,
span,
p,
input,
.btn,
li,
td,
th,
tr {
  font-family: var(--font-family-monospace) !important;
}

:root {
  --secondary: linear-gradient(221deg, #8743ff, #4136f1 60%);
  --body: #eaf2ff;
  --card: #fff;
  --text: #000;
  --price: #4136f1;
}
a:hover {
  color: #222;
}
.card {
  background: var(--body);
  border-radius: 20px;
  padding: 10px;
  font-family: sans-serif;
  display: flex;
  color: var(--text);
  transition: transform 0.3s, background 0.3s;
  margin-bottom: 15px;
}
.card:hover {
  transform: scale(1.09);
}
.card img {
  width: 160px;
  min-height: 160px;
  border-radius: 14px;
  object-fit: cover;
}
h5.card-header {
  background: darkmagenta;
  color: #fff;
  font-weight: bolder;
  border-radius: 0;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
}
</style>
