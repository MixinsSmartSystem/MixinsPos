class AppStorage {
    storeToken(token) {
        localStorage.setItem("token", token);
    }

    storeUser(user) {
        localStorage.setItem("user", user);
    }
    storeId(id) {
        localStorage.setItem("user_id", id);
    }

    store(token, user, id) {
        this.storeToken(token);
        this.storeUser(user);
        this.storeId(id);
    }

    clear() {
        localStorage.removeItem("token");
        localStorage.removeItem("user");
        localStorage.removeItem("user_id");
        localStorage.removeItem("vat");
    }

    getToken() {
        localStorage.getItem("token");
    }

    getUser() {
        localStorage.getItem("user");
    }
}

export default AppStorage = new AppStorage();
