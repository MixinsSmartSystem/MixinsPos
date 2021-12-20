let login = require("./components/auth/login.vue").default;
let register = require("./components/auth/register.vue").default;
let home = require("./components/menu.vue").default;

let logout = require("./components/auth/logout.vue").default;
//supplier
let suppliers = require("./components/supplier/index.vue").default;
let editSupplier = require("./components/supplier/edit.vue").default;
let createSupplier = require("./components/supplier/create.vue").default;

//bills
let bills = require("./components/bills/index.vue").default;

//purchaseBills
let purchaseBills = require("./components/purchase/purchase.vue").default;
let allPurchaseBills = require("./components/purchase/index.vue").default;

//Mixins
let mixins = require("./components/settings/index.vue").default;

//worker
let createWorker = require("./components/workers/create.vue").default;
let workers = require("./components/workers/index.vue").default;
let editWorker = require("./components/workers/edit.vue").default;

//Customers
let createCustomer = require("./components/customers/create.vue").default;
let customers = require("./components/customers/index.vue").default;
let editCustomer = require("./components/customers/edit.vue").default;
//Users
let createUser = require("./components/users/create.vue").default;
let users = require("./components/users/index.vue").default;
let editUser = require("./components/users/edit.vue").default;
let addRoles = require("./components/users/roles.vue").default;

//Types
let createType = require("./components/types/create.vue").default;
let types = require("./components/types/index.vue").default;
let editType = require("./components/types/edit.vue").default;
//mainTypes
let editMainType = require("./components/category/edit.vue").default;
let mainTypes = require("./components/category/index.vue").default;
let createMainType = require("./components/category/create.vue").default;

//Reports
let reportsMenu = require("./components/reportsMenu.vue").default;
let report = require("./components/reports/report.vue").default;
let customerReport = require("./components/reports/customer.vue").default;
let searchReport = require("./components/reports/search.vue").default;

let requests = require("./components/request/index.vue").default;
let cash = require("./components/cash/index.vue").default;
//Offers
let editOffer = require("./components/offers/edit.vue").default;
let offers = require("./components/offers/index.vue").default;
let createOffer = require("./components/offers/create.vue").default;
//Return Bills
let returnBill = require("./components/return/index.vue").default;
//BillsHome
let bill = require("./components/home/index.vue").default;
let alert = require("./components/home/alert.vue").default;
let billWithUnits = require("./components/home/units.vue").default;
let billWithUnitsAndAlert =
    require("./components/home/units-alert.vue").default;

//Expenses
let expenses = require("./components/expenses/index.vue").default;
let editExpenses = require("./components/expenses/edit.vue").default;
let createExpenses = require("./components/expenses/create.vue").default;
export const routes = [
    //Expenses
    {
        path: "/create/expense",
        component: createExpenses,
        name: "create-expense",
    },
    { path: "/expenses", component: expenses, name: "expenses" },
    {
        path: "/edit/expense/:id",
        component: editExpenses,
        name: "edit-expense",
    },

    //BillsHome
    { path: "/bill", component: bill, name: "bill" },
    { path: "/alert", component: alert, name: "alert" },
    { path: "/billWithUnits", component: billWithUnits, name: "billWithUnits" },
    {
        path: "/billWithUnitsAndAlert",
        component: billWithUnitsAndAlert,
        name: "billWithUnitsAndAlert",
    },

    //Return Bills
    { path: "/return", component: returnBill, name: "return" },

    //Offers
    { path: "/create/offer", component: createOffer, name: "create-offer" },
    { path: "/offers", component: offers, name: "offers" },
    { path: "/edit/offer/:id", component: editOffer, name: "edit-offer" },

    { path: "/cash", component: cash, name: "cash" },

    { path: "/", component: login, name: "/" },
    { path: "/home", component: home, name: "home" },
    { path: "/mixins", component: mixins, name: "mixins" },

    { path: "/register", component: register, name: "register" },
    { path: "/logout", component: logout, name: "logout" },
    //bills
    { path: "/bills", component: bills, name: "bills" },
    //purchaseBills
    {
        path: "/purchase-bills",
        component: purchaseBills,
        name: "purchaseBills",
    },
    //purchaseBills
    {
        path: "/allPurchaseBills",
        component: allPurchaseBills,
        name: "allPurchaseBills",
    },
    //Workers
    { path: "/create/worker", component: createWorker, name: "create-worker" },
    { path: "/workers", component: workers, name: "workers" },
    { path: "/edit/worker/:id", component: editWorker, name: "edit-worker" },
    //Suplliers
    {
        path: "/create/supplier",
        component: createSupplier,
        name: "create-supplier",
    },
    { path: "/suppliers", component: suppliers, name: "suppliers" },
    {
        path: "/edit/supplier/:id",
        component: editSupplier,
        name: "edit-supplier",
    },
    //Customers
    {
        path: "/create/customer",
        component: createCustomer,
        name: "create-customer",
    },
    { path: "/customers", component: customers, name: "customers" },
    {
        path: "/edit/customer/:id",
        component: editCustomer,
        name: "edit-customer",
    },
    //Users
    { path: "/create/user", component: createUser, name: "create-user" },
    { path: "/users", component: users, name: "users" },
    { path: "/add/roles/:id", component: addRoles, name: "add-roles" },
    { path: "/edit/user/:id", component: editUser, name: "edit-user" },
    //Types
    { path: "/create/type", component: createType, name: "create-type" },
    { path: "/types", component: types, name: "types" },
    { path: "/edit/type/:id", component: editType, name: "edit-type" },

    //mainTypes
    {
        path: "/create/mainType",
        component: createMainType,
        name: "create-mainType",
    },
    { path: "/mainTypes", component: mainTypes, name: "mainTypes" },
    {
        path: "/edit/mainType/:id",
        component: editMainType,
        name: "edit-mainType",
    },

    //    Reports
    { path: "/report", component: reportsMenu, name: "reportsMenu" },
    { path: "/bills/report/:period", component: report, name: "report" },
    { path: "/bills/report", component: report, name: "bills-report" },
    { path: "/requests", component: requests, name: "requests" },
    {
        path: "/customers/report",
        component: customerReport,
        name: "customers-report",
    },
    { path: "/search", component: searchReport, name: "search-report" },
];
