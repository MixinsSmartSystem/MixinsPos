<template></template>
<script>
import AppStorage from "../../Helpers/AppStorage";

export default {
  created() {
    if (User.hasToken()) {
      AppStorage.clear();
      location.reload(true);
      this.$router.push("/");
    }
  },
};
</script>
