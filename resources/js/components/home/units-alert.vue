<template>
    <div>
        <Spinner v-show="loading"></Spinner>

        <div v-show="!loading">
            <!--        Search -->
            <div :class="showSearchTypeModal?'modal fade show d-block modaldrg':'modal fade modaldrg'"
                 aria-hidden="true"
                 aria-labelledby="exampleModalLabel" role="dialog"
                 tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                     role="document">
                    <div class="modal-content m-auto" style="min-width: 850px;">
                        <div class="modal-header">
                            <h5 class="modal-title" i>{{ bill.bill_total }}</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true" @click="searchTypes=[];typeName='';showSearchTypeModal=false">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body min-h-50" style="min-height:500px;overflow: auto">
                            <input v-model="typeName" class="form-control-sm"
                                   placeholder="اسم الصنــــــف "
                                   type="search"
                            >
                            <button class="btn btn-sm btn-info" @click="findTypeByLike()"><i
                                class="fa fa-search font-weight-bold text-light"></i></button>
                            <table class="text-center "
                                   style="position: absolute; z-index: 999;overflow: auto">
                                <thead>
                                <tr>
                                    <th style="width:10%">كود الصنف</th>
                                    <th style="width:50%;">اسم الصنف</th>
                                    <th style="width:10%">السعر</th>
                                    <th style="width:10%">اضافة</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(searchType,index) in searchTypes" :key="index">
                                    <td>{{ searchType.type_id }}</td>
                                    <td>{{ searchType.type_name_ar }}</td>
                                    <td>{{ searchType.type_sill_price }}</td>
                                    <td>
                                        <i class="fa fa-plus btn-sm  btn-success font-weight-bold text-light"
                                           @click="addToCart(searchType)"></i>
                                    </td>

                                </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal"
                                    type="button"
                                    @click="searchTypes=[];typeName='';showSearchTypeModal=false">إغلاق
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--   END     Search -->
            <!--Start Calculation-->

            <div class="card-header " style="overflow-x:auto">
                <form class="w-100 " direction="rtl" @submit.prevent="saveBill">
                    <table class="table-bordered text-lighten-1 text-center font-weight-bold">
                        <tbody>
                        <tr>
                            <td style="width:10%">كود العميل</td>
                            <td style="width:10%"><input v-model="search" class="form-control-sm"
                                                         type="text"
                                                         @keyup="findCustomer"></td>
                            <td style="width:10%">اسم العميل</td>
                            <td style="width:10%"><input :value="customer.cust_name"
                                                         class=" form-control-sm "

                                                         type="text"></td>
                            <td style="width:10%"><a :title="customer.cust_balance"
                                                     class="btn btn-info btn-sm text-light "
                                                     data-target="#exampleModal" data-toggle="modal"
                                                     @click="allCustomers();"><i
                                class=" fas fa-search font-weight-bold text-light"></i></a></td>
                            <td style="width:10%">طريقة الدفع</td>
                            <td style="width:10%"><select id="inputState" v-model="form.pay"
                                                          class="form-control form-control-sm float-left text-center"
                                                          @change="calcTotal()">
                                <option v-for="(pay,index) in payMethods" :key="index" :value="pay.id">
                                    {{ pay.pay_method_name }}
                                </option>
                            </select></td>
                            <td style="width:10%">المدفوع</td>

                            <td style="width:10%"><input
                                v-model="form.paid"
                                class="form-control form-control-sm  float-left text-center"
                                @keyup="calcRemain()"/></td>
                            <td>المتبقي</td>

                            <td style="width:10%">
                                <input
                                    v-model="form.remain"
                                    class="form-control form-control-sm  float-left text-center"
                                    readonly
                                />
                            </td>
                            <td style="width:10%">
                                <button :disabled="form.total<=0 || cart.length<=0"
                                        class="btn  btn-outline-success font-weight-bold text-dark"
                                        type="submit">حفظ
                                </button>
                            </td>

                        </tr>

                        <tr>
                            <td style="width:10%">المجموع</td>
                            <td style="width:10%"><input
                                v-model="form.sum"
                                class="form-control form-control-sm  float-left text-center"
                                readonly
                            /></td>
                            <td v-show="$root.$data.roles.includes(12)" style="width:10%">الخصم:{{
                                    this.isPercentDiscount ? '%' : ''
                                }}
                            </td>

                            <td v-show="$root.$data.roles.includes(12)" style="width:10%"><input
                                v-model="form.discount"
                                class="form-control form-control-sm  float-left text-center"
                                @keyup="calcTotal()"/></td>
                            <td>الاضافي</td>

                            <td style="width:10%"><input
                                v-model="form.extra"
                                class="form-control form-control-sm  float-left text-center"
                                @keyup="calcTotal()"/></td>
                            <td> الضريبة</td>

                            <td style="width:10%">
                                <input
                                    v-model="form.vat"
                                    class="form-control form-control-sm  float-left text-center"
                                    readonly
                                /></td>
                            <td>صافي الاجمالي</td>

                            <td style="width:10%">

                                <input
                                    v-model="form.total"
                                    class="form-control form-control-sm  float-left text-center"
                                    readonly
                                />
                            </td>

                            <td style="width:100%">
                                <input v-model="form.note" class="form-control-sm"
                                       placeholder="ملاحظات الفاتورة"/>
                            </td>
                            <td>
                                <a class="btn font-weight-bold btn-outline-warning text-dark"
                                   @click="clearAll()">استعادة</a>
                            </td>

                        </tr>
                        </tbody>

                    </table>


                </form>
                <div>

                    <input v-model="barcode" class=" form-control-sm"
                           placeholder="بـــــــاركود  "
                           type="search"
                           @change="findType()">

                    <input v-model="id" class=" form-control-sm "
                           placeholder="كـــود الصنــــــف "
                           type="search"
                           @change="findTypeByCodeOrId()">
                    <button class="btn btn-sm btn-info" @click="showSearchTypeModal=true"><i
                        class="fa fa-search font-weight-bold text-light"></i></button>


                </div>

            </div>
            <!--Start Calculation-->
            <div class="row mb-3 newBill">
                <div :class="mixins.bill_with_main_type?'col-md-6':'col-md-12 float-right'">
                    <!--Start Selected Items-->

                    <div class="selected text-center w-100">

                        <div style="min-height:50vh;">
                            <div class="w-100  table-wrapper">

                                <div id="pagewrap" class="row">
                                    <div id="body" class="col-sm-12 ">
                                        <table class="text-center font-weight-bold"
                                               style="overflow-x:auto">
                                            <thead>
                                            <tr>
                                                <th style="width:40%">اسم الصنف</th>
                                                <th style="width: 10%">الوحدة</th>
                                                <th style="width:10%">العدد</th>
                                                <th style="width:10%">السعر</th>
                                                <th v-show="!$root.$data.mixins.bill_with_main_type" style="width:10%">
                                                    ق.الخصم
                                                </th>
                                                <th v-show="!$root.$data.mixins.bill_with_main_type" style="width:10%">
                                                    ن.الخصم
                                                </th>
                                                <th style="width:10%">الاجمالي</th>
                                                <th v-show="!$root.$data.mixins.bill_with_main_type" style="width:25%">
                                                    ملاحظات
                                                </th>

                                            </tr>
                                            </thead>
                                            <tbody v-if="cart.length>0">

                                            <tr v-for="(product ,index) in cart" :key="product.id"
                                                :style="findTypeStock(type)<=0?'color:red!important':''"
                                            >
                                                <td :style="product.has_Offer?'color:red!important':''"
                                                    class="font-weight-bold "
                                                    @dblclick="addToExitStock(type)">
                                                    {{ product.type_name_ar }}
                                                </td>
                                                <td>
                                                    <select v-model="product.sell_unit" class="form-control-sm"
                                                            @change="calcTotalTypeCost(product)">
                                                        <option v-for="(unit,index) in product.units"
                                                                :key="index"
                                                                :selected="unit.type_unit_id===product.sell_unit"
                                                                :value="unit.type_unit_id">
                                                            {{ unit.unit.unit_ar_name }}
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>

                                                    <a v-if="product.type_count===1" class="btn mx-2 btn-danger"
                                                       @click="removeFromCart(product,index)"><i
                                                        class="fa fa-trash text-light"></i> </a>
                                                    <button v-else :disabled="product.has_Offer"
                                                            class="btn mx-2 btn-warning"
                                                            @click="decrement(product)">-
                                                    </button>
                                                    <input
                                                        v-model="product.type_count" :readonly="product.has_Offer"
                                                        class="btn"
                                                        style="width: 50px"
                                                        @keyup="onChangeCount(product)"/>

                                                    <button :disabled="product.has_Offer" class="btn mx-2 btn-success"
                                                            @click="increment(product)">+
                                                    </button>


                                                </td>
                                                <td>
                                                    <input v-model="product.type_sill_price"
                                                           :readonly="!$root.$data.roles.includes(22) || product.has_Offer"
                                                           class="btn text-bold"
                                                           style="width: 100px"
                                                           @keyup="onChangeTypeCost(product)">
                                                </td>
                                                <td v-show="!$root.$data.mixins.bill_with_main_type">
                                                    <input v-model="product.type_discount_value"
                                                           :readonly="product.type_discount_percent>0"
                                                           class="btn text-bold"
                                                           style="width: 100px"
                                                           @keyup="onChangeTypeCost(product)">
                                                </td>
                                                <td v-show="!$root.$data.mixins.bill_with_main_type">
                                                    <input v-model="product.type_discount_percent"
                                                           :readonly="product.type_discount_value>0"
                                                           class="btn text-bold"
                                                           style="width: 100px"
                                                           @keyup="onChangeTypeCost(product)">
                                                </td>
                                                <td>

                                                    {{
                                                        Number(product.total_type_cost).toFixed(2)
                                                    }}
                                                </td>
                                                <td v-show="!$root.$data.mixins.bill_with_main_type">
                                                    <input v-model="product.type_note"

                                                           class="btn text-bold"
                                                           placeholder="ملاحظــــــــات">
                                                </td>

                                            </tr>

                                            </tbody>
                                            <tbody v-else>
                                            <tr class=" w-100">
                                                <td class="m-auto font-weight-light" colspan="8">لا توجد أصناف</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- End Selected Items-->


                </div>

                <!--Start  All Products -->
                <div v-if="mixins.bill_with_main_type" class="col-md-6">

                    <div>
                        <ul id="pills-tab" class="nav nav-pills  w-100" role="tablist"
                            style="overflow: auto;border: 1px solid #ddd">
                            <li v-for="(cat,index) in categories" :id="'cat-'+index" :key="index"
                                class="cat-0 nav-item mx-1 my-1 "
                                role="presentation" style="overflow: auto;border: 1px solid #ddd">
                                <a :id="'pills-'+cat.main_type_id+'-tab'"
                                   :aria-controls="'pills-'+category.main_type_id"
                                   :class="cat===category?'nav-link active' :'nav-link' "
                                   :data-bs-target="'#pills-'+cat.main_type_id"
                                   aria-selected="true" class="btn  btn-outline-primary font-weight-bold text-dark"
                                   data-bs-toggle="pill" role="tab"
                                   type="button" @click="category=cat">
                                    {{ cat.main_type_title_ar }}
                                </a>
                            </li>
                        </ul>

                    </div>

                    <div :id="'pills-'+category.main_type_id"
                         :aria-labelledby="'pills-'+category.main_type_id+'-tab'"
                         class="tab-pane fade show active"
                         role="tabpanel">
                        <div id="pills-tabContent" class="tab-content">
                            <div class="row">
                                <div v-for="product in category.products" :key="product.id" class="col-4"
                                     @click="addToCart(product)">
                                    <div class="card text-center">
                                        <img :alt="product.type_name_ar"
                                             :src="product.type_icon!=null &&product.type_icon !='' ?product.type_icon:'backend/products/product.png'"
                                             class="w-100"/>
                                        <div class="card__shop card-header py-0">
                                            <b class="card__shop__price mt-1 font-weight-bold text-light badge badge-info">{{
                                                    Number(product.type_sill_price).toFixed(2)
                                                }}</b>
                                            <h2 class="card__title w-100 font-weight-bold ">{{
                                                    product.type_name_ar
                                                }}</h2>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!--  End All Products -->

            </div>


            <div id="exampleModal" aria-hidden="true" aria-labelledby="exampleModalLabel" class="modal fade"
                 role="dialog"
                 tabindex="-1">
                <div class=" modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content m-auto" style="min-width: 850px;">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{ bill.bill_total }}</h5>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-12 mb-4">
                                <div class="table-responsive w-100">
                                    <label>Search:<input v-model="searchName" aria-controls="dataTable"
                                                         class="form-control form-control-sm"
                                                         type="search"></label>
                                    <table class="table align-items-center ">
                                        <thead>
                                        <tr>
                                            <th class="col-header" style="width:50%">كود العميل</th>
                                            <th class="col-header" style="width:30%">اسم العميل</th>
                                            <th class="col-header" style="width:10%">هاتف العميل</th>
                                            <th class="col-header" style="width:10%">رصيد العميل</th>
                                            <th class="col-header" style="width:10%"> تحديد</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(customer,index) in filterSearch" :key="index">
                                            <td>{{ customer.cust_id }}</td>
                                            <td>{{ customer.cust_name }}</td>
                                            <td>{{ customer.cust_mobile }}</td>
                                            <td>{{ customer.cust_balance }}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm" data-dismiss="modal"
                                                        @click="selectCustomer(customer)"><i
                                                    class="fa fa-plus  font-weight-bold text-light"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>

                <Printer :bill="bill" :qr="qr"/>

            </div>
        </div>

    </div>
</template>

<script>
import Printer from "../printer";
import Spinner from "../spinner/mixinsSpinner.vue";
import {Invoice} from "@axenda/zatca";

export default {
    components: {Printer, Spinner},
    async created() {
        if (!User.loggedIn()) {
            await this.$router.push("/");
        }
        await this.getMixins();
        if (this.mixins.bill_with_main_type) {
            await this.allMainType();
        } else {
            this.loading = false;
        }

        await this.allPayMethods();
    },
    computed: {
        filterSearch() {
            return this.customers.length > 0
                ? this.customers.filter((customer) => {
                    return customer.cust_name.match(this.searchName);
                })
                : "";
        },
    },

    data() {
        return {
            searchTypes: [],
            showSearchTypeModal: false,
            output: null,
            qr: "",
            isNewbill: true,
            isPrint: false,
            loading: true,
            mixins: {
                bill_column_num: "",
                bill_discount: "",
                bill_with_main_type: "",
                closure_hour: "",
                contruct_no: "",
                default_lang: "",
                end_support_date: "",
                id: "",
                image_path: "",
                bill_type: "",
                item_request_qty: "",
                logo_height: "",
                logo_width: "",
                main_mixins_store: "",
                main_type_column_num: "",
                mixins_adress: "",
                mixins_font_color: "",
                mixins_font_size: "",
                mixins_logo: "",
                mixins_mac_serial: "",
                mixins_main_payment_method: "",
                mixins_mobile: "",
                mixins_name: "",
                mixins_note: "",
                mixins_price_include_vat: false,
                mixins_theme: "",
                mixins_vat_val: "",
                partition_folder: "",
                render_bill_footer_note: "",
                render_bill_img: "",
                render_bill_note: "",
                render_bill_reports: "",
                render_bills: "",
                render_cash: "",
                render_cash_point: "",
                render_en_names: "",
                render_new_bill: "",
                render_purchase_bills: "",
                render_purchase_bills_reports: "",
                render_types_note: "",
                render_withdraw_cash: "",
                show_reset_btn: "",
                type_discount: "",
                use_type_uints: "",
                active_type_offer: "",
            },
            products: [],
            payMethods: [],
            categories: [],
            category: {},
            customers: [],
            customer: {},
            search: "",
            barcode: "",
            id: "",
            searchName: "",
            typeName: "",
            isPercentDiscount: false,
            type: {},
            bill_id: 0,
            bill: {},
            cart: [],
            form: {
                user_id: null,
                note: "",
                sum: 0.0,
                discount: 0.0,
                total: 0.0,
                extra: 0.0,
                vat: 0.0,
                cart: [],
                paid: 0.0,
                remain: 0.0,
                customer: {},
                pay: 1,
            },
            typeUnit: null,
        };
    },
    methods: {
        async allMainType() {
            await axios
                .get("/api/AllCategories")
                .then(async ({data}) => {
                    this.categories = data;
                    this.loading = false;
                    this.category = this.categories[0];
                })
                .then(() => {
                })
                .catch((error) => console.log(error));
        },

        async allProducts() {
            await axios
                .get("/api/types")
                .then(({data}) => {
                    this.products = data;
                })
                .catch((error) => console.log(error));
        },
        async allPayMethods() {
            await axios
                .get("/api/payMethods")
                .then(({data}) => (this.payMethods = data))
                .catch((error) => console.log(error));
        },
        async allCustomers() {
            await axios
                .get("/api/action/all/customers")
                .then(({data}) => (this.customers = data))
                .catch((error) => console.log(error));
        },
        async findCustomer() {
            await axios
                .get("/api/customers/" + this.search)
                .then(({data}) => {
                    this.customer = data;
                    this.calcSum();
                })
                .catch((error) => console.log(error));
        },
        async findType() {
            await axios
                .get("/api/findTypeByBarcode/" + this.barcode)
                .then(async ({data}) => {
                    this.type = data;
                    if (this.type.type_id != null) {
                        await this.addToCart(this.type);
                        this.barcode = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },
        async findTypeByCodeOrId() {
            await axios
                .get("/api/action/find/" + this.id)
                .then(({data}) => {
                    this.type = data;
                    if (data.type_id != null) {
                        this.addToCart(data);
                        this.id = "";
                    } else {
                        Notification.customMsg(
                            "warning",
                            "topRight",
                            "لايوجد صنف بهذا الاسم"
                        );
                    }
                })
                .catch((error) => console.log(error));
        },

        async checkIfTypeHasOffer(product) {
            await axios
                .get("/api/action/offerType/" + product.type_id)
                .then(({data}) => {
                    console.log(data);
                    data.map((type) => {
                        if (type.main_type != null) {
                            if (product.type_count === type.main_type_count) {
                                let offer = type.offer_type;
                                offer.type_sill_price =
                                    offer.type_sill_price -
                                    (offer.type_sill_price * type.offer_discount_percent) / 100.0;
                                offer.type_count = 1;
                                offer.has_Offer = true;
                                this.cart.push(offer);

                                this.calcTotalTypeCost(offer);
                            }
                            this.id = "";
                        }
                    });
                })
                .catch((error) => console.log(error));
        },

        async findTypeByLike() {
            await axios
                .get("/api/action/like/" + this.typeName)
                .then(({data}) => {
                    this.searchTypes = data;
                })
                .catch((error) => console.log(error));
        },
        selectCustomer(customer) {
            this.customer = customer;
            this.search = customer.cust_id;
            this.calcSum();
        },
        async print(id) {
            await axios
                .get("api/bills/" + id)
                .then(async ({data}) => {
                    this.bill = data;
                    if (this.bill != null && this.bill.customer != null) {
                        const invoice = new Invoice({
                            sellerName: this.bill.customer.cust_name,
                            vatRegistrationNumber: this.mixins.contruct_no,
                            invoiceTimestamp: this.bill.bill_date,
                            invoiceTotal: this.bill.bill_total,
                            invoiceVatTotal: this.bill.bill_vat_val,
                        });
                        this.qr = await invoice.render();
                    }
                })
                .then(() => {
                    // this.$htmlToPaper('printMe')
                    $("#printer").click();
                })
                .catch((err) => console.log(err));
        },
        async getMixins() {
            await axios
                .get("/api/mixins/1")
                .then(({data}) => {
                    this.mixins = data;
                })
                .catch((error) => console.log(error));
        },
        calcIfCustomerHasDiscount() {
            if (
                this.cart.length > 0 &&
                this.form.discount == 0 &&
                this.customer != null
            )
                if (this.customer.cust_discount_val > 0) {
                    this.form.discount = this.customer.cust_discount_val;
                    return;
                }
            if (this.customer.cust_discount_percent > 0) {
                this.isPercentDiscount = true;
                this.form.discount = this.customer.cust_discount_percent;
            } else {
                this.isPercentDiscount = false;
                this.form.discount = 0.0;
            }
        },
        async addToCart(product) {
            if (
                (await this.findTypeStock(product.type_id)) <=
                this.mixins.item_request_qty
            ) {
                await axios
                    .get("/api/action/check/" + product.type_id)
                    .then(async ({data}) => {
                        if (!data) {
                            await this.addToExitStock(product);
                        }
                    })
                    .catch((error) => console.log(error));
            }
            if (this.cart.includes(product)) {
                product.type_count++;
            } else {
                product.type_count = 1;
                this.cart.push(product);
            }
            if (this.mixins.active_type_offer) {
                await this.checkIfTypeHasOffer(product);
            }
            await this.calcTotalTypeCost(product);
        },
        async removeFromCart(product, index) {
            product.type_count = 1;
            product.total_type_cost =
                product.type_count * Number(product.type_sill_price);
            this.$delete(this.cart, index);
            await this.calcSum();
        },
        async increment(product) {
            if (
                (await this.findTypeStock(product.type_id)) <=
                this.mixins.item_request_qty &&
                this.mixins.bill_type
            ) {
                await axios
                    .get("/api/action/check/" + product.type_id)
                    .then(async ({data}) => {
                        if (!data) {
                            await this.addToExitStock(product);
                        }
                    })
                    .catch((error) => console.log(error));
            }
            product.type_count++;
            await this.calcTotalTypeCost(product);
        },
        async decrement(product) {
            if (product.type_count <= 1) {
                product.type_count = 1;
            } else {
                product.type_count--;
            }
            await this.calcTotalTypeCost(product);
        },
        async onChangeCount(product) {
            if (product.type_count <= 1) {
                product.type_count = 1;
            }
            await this.calcTotalTypeCost(product);
        },
        async onChangeTypeCost(product) {
            if (product.type_sill_price < product.minimum_sill_price) {
                product.type_sill_price = product.minimum_sill_price;
            }
            await this.calcTotalTypeCost(product);
        },
        async findUnit(product) {
            await axios
                .get("/api/units/" + product.sell_unit)
                .then(({data}) => {
                    this.typeUnit = data;
                })
                .catch((error) => console.log(error));
        },
        async calcUnitPrice(product) {
            if (product.sell_unit !== null) {
                await this.findUnit(product);
                product.type_sill_price =
                    this.typeUnit.price ?? product.type_sill_price;
                if (product.type_stock !== null) {
                    if (product.type_stock.mixins_type_stock > 0) {
                        var totalNofUnit =
                            this.typeUnit.no_of_unit * product.type_stock.mixins_type_stock -
                            product.type_count;
                        product.calc_count = totalNofUnit / this.typeUnit.no_of_unit;
                    }
                }
            } else {
                product.type_sill_price = product.type_sill_price;
            }
        },
        async calcTotalTypeCost(product) {
            await this.calcUnitPrice(product);

            if (Number(product.type_discount_value) > 0) {
                product.total_type_cost =
                    product.type_count *
                    (Number(product.type_sill_price) -
                        Number(product.type_discount_value));
                await this.calcSum();
                return;
            }
            if (Number(product.type_discount_percent) > 0) {
                let price =
                    product.type_sill_price -
                    product.type_sill_price * (product.type_discount_percent / 100.0);
                product.total_type_cost = product.type_count * price;
                await this.calcSum();
                return;
            }
            product.total_type_cost =
                product.type_count * Number(product.type_sill_price);
            await this.calcSum();
        },
        async calcSum() {
            this.form.sum = 0;
            this.cart.filter((product) => {
                this.form.sum += product.total_type_cost;
            });
            if (this.mixins.mixins_price_include_vat) {
                let vatVal = this.mixins.mixins_vat_val;
                this.form.sum = this.form.sum / (1 + vatVal / 100.0);
            }

            await this.calcTotal();
        },
        async calcTotal() {
            await this.calcIfCustomerHasDiscount();
            this.form.total = 0;
            if (this.isPercentDiscount) {
                this.form.total = Number(this.form.sum) + Number(this.form.extra);
                this.form.total =
                    this.form.total -
                    (this.form.total * Number(this.form.discount)) / 100.0;
            } else {
                this.form.total =
                    Number(this.form.sum) +
                    Number(this.form.extra) -
                    Number(this.form.discount);
            }
            if (this.mixins.mixins_vat_val > 0) {
                let vatVal = this.mixins.mixins_vat_val;
                this.form.vat = (this.form.total * vatVal) / 100.0;
                this.form.total = this.form.total + this.form.vat;
            }
            //Form number
            this.form.vat = Number(this.form.vat).toFixed(2);
            this.form.sum = Number(this.form.sum).toFixed(2);
            this.form.total = Number(this.form.total).toFixed(2);
            if (this.form.pay != 3) {
                this.form.paid = this.form.total;
                this.form.remain = 0;
            } else {
                this.form.remain = this.form.total;
                this.form.paid = 0;
            }
        },
        calcRemain() {
            this.form.remain = this.form.total - this.form.paid;
            this.form.remain = Number(this.form.remain).toFixed(2);
        },
        async saveBill() {
            let isValid = true;
            if (this.cart.length <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة بدون أصناف"
                );
                return;
            }
            if (this.form.total <= 0) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "لايمكن حفظ فاتورة قيمتها صفر"
                );
                return;
            }
            if (this.form.pay == 3 && this.customer.cust_id == null) {
                isValid = false;
                Notification.customMsg(
                    "error",
                    "topRight",
                    "الفاتورة آجل! يجب اختيار عميل",
                    5000
                );
                return;
            }
            if (isValid) await this.saveValidBill();
        },
        async saveValidBill() {
            this.form.user_id = localStorage.getItem("user_id");
            this.form.cart = this.cart;
            this.form.customer = this.customer;
            if (this.form.cart.length > 0) {
                await axios
                    .post("api/bills", this.form)
                    .then((data) => {
                        Notification.success();
                        this.print(data.data);
                        $("#btn").click();
                        $("#print").click();
                        (this.isPrint = true), this.clearAll();
                    })
                    .catch((error) => console.log(error));
            } else {
                Notification.error();
            }
        },
        async addToExitStock(product) {
            if (this.mixins.bill_type) {
                await Swal.fire({
                    title: "تنبية نواقص",
                    text: "هل تريد أضافة الصنف للنواقص؟",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "نعم  !",
                    cancelButtonText: "إلغاء",
                }).then((result) => {
                    if (result.value) {
                        axios
                            .get("/api/action/" + product.type_id)
                            .then(({data}) => console.log("Done"))
                            .catch((error) => console.log(error));
                    }
                });
            }
        },
        async findTypeStock(id) {
            let stock = 0;
            if (this.mixins.bill_type) {
                await axios
                    .get("/api/typeStocks/" + id)
                    .then(({data}) => {
                        if (data.mixins_type_stock_id != null) {
                            stock = data.mixins_type_stock;
                        }
                    })
                    .catch((error) => console.log(error));
            }
            return stock;
        },

        clearAll() {
            this.cart = [];
            this.form.cart = [];
            this.customer = {};
            this.search = "";
            this.calcSum();
            (this.bill = {}), (this.isPrint = false);
        },
    },
};
</script>
<style scoped>
b.btn {
    float: right;
}

.fa {
    cursor: pointer;
}

:root {
    --secondary: linear-gradient(221deg, #8743ff, #4136f1 60%);
    --body: #eaf2ff;
    --card: #fff;
    --text: #000;
    --price: #4136f1;
}

body {
    /*background: var(--secondary);*/
    transition: background 0.3s;
    gap: 20px;
    font-family: "Poppins", sans-serif;
}

.newBill .card {
    background: var(--card);
    border-radius: 20px;
    font-family: "Poppins", sans-serif;
    display: flex;
    color: var(--text);
    flex-direction: column;
    align-items: flex-start;
    transition: transform 0.3s, background 0.3s;
}

.newBill .card-header {
    border-radius: 0;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    font-weight: bolder;
}

.tab-content .card:hover,
.selected .card .card:hover {
    transform: scale(1.09);
}

.newBill .card img {
    width: 160px;
    height: 120px;
    border-radius: 14px;
    object-fit: cover;
}

.newBill .card__title {
    margin-top: 16px;
    font-size: 15px;
    font-weight: 400;
    transition: color 0.3s;
}

.newBill .card__shop {
    width: 100%;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.newBill .card__shop__action span {
    color: #fff;
    font-size: 26px;
}
</style>
