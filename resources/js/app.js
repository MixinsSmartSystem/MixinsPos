require("./bootstrap");
require("lang.js");

import Vue from "vue";
import VueRouter from "vue-router";
import VueHtmlToPaper from "vue-html-to-paper";

import { routes } from "./routes";
//Multi lang

Vue.use(VueRouter);
const options = {
    name: "_blanck",
    specs: ["fullscreen=no", "titlebar=no", "scrollbars=no"],
    styles: [
        "http://127.0.0.1:8000/backend/vendor/bootstrap/css/bootstrap.rtl.css",
        "http://127.0.0.1:8000/css/print.css",
    ],
    timeout: 0.1,
    autoClose: false,
};
Vue.use(VueHtmlToPaper, options);

// Import User Class
import User from "./Helpers/User";
window.User = User;
//Notification
import Notification from "./Helpers/Notification";

window.Notification = Notification;
//Sweet alet
import Swal from "sweetalert2";

window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

window.Toast = Toast;

//end sweet alert
const router = new VueRouter({
    routes,
    mode: "history", // short for `routes: routes`
});
window.Reload = new Vue();

const app = new Vue({
    async created() {
        if (!User.loggedIn()) {
            this.$router.push("/");
        }
        await this.findRoleByUserId(localStorage.getItem("user_id"));
        await this.getMixins();
    },
    data() {
        return {
            userRoles: [],
            roles: [],
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
        };
    },
    methods: {
        async getMixins() {
            await axios
                .get("/api/mixins/1")
                .then(({ data }) => {
                    this.mixins = data;
                })
                .catch((error) => console.log(error));
        },
        findRoleByUserId(id) {
            axios
                .get("/api/active/user/roles/" + id)
                .then(({ data }) => {
                    this.userRoles = data.user.roles;
                    let isAdmin = data.user.is_admin == 1 ? true : false;
                    this.userRoles.map((role) => {
                        this.roles.push(role.mixins_role);
                    });
                })
                .catch((error) => console.log(error));
        },
    },
    el: "#app",
    router,
});
