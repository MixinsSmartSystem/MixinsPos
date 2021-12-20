<template>
  <div>
    <div class="row my-3">
      <div class="card-header text-center mb-2">
        <h5>التقارير</h5>
      </div>
      <div class="col-2">
        <router-link
          class="card text-center p-0 w-100"
          :to="{ name: 'report', params: { period: 'daily' } }"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/reports/bill.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">تقرير اليوم</h5>
        </router-link>
      </div>
      <div class="col-2">
        <router-link
          class="card text-center p-0 w-100"
          :to="{ name: 'report', params: { period: 'monthly' } }"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/reports/bills.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">تقرير الشهر</h5>
        </router-link>
      </div>
      <div class="col-2">
        <router-link
          class="card text-center p-0 w-100"
          to="/bills/report"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/reports/report.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">تقرير الفترة</h5>
        </router-link>
      </div>
      <div class="col-2">
        <router-link
          class="card text-center p-0 w-100"
          to="/customers/report"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/reports/customer-reposrt.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">تقرير العملاء</h5>
        </router-link>
      </div>
      <div class="col-2">
        <router-link
          class="card text-center p-0 w-100"
          to="/search"
          style="text-decoration: none; text-align: center"
        >
          <img
            class="card-img-top w-100"
            src="backend/img/reports/search.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">تقرير البحث</h5>
        </router-link>
      </div>
      <div class="col-md-2 col-sm-4">
        <router-link to="/requests">
          <img
            class="card-img-top w-100"
            src="backend/img/menu/note.png"
            alt="Card image cap"
          />
          <h5 class="text-center my-0 card-header">النواقص</h5>
        </router-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {};
</script>
<style scoped>
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
