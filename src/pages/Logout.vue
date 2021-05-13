<template>
<div>
    </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch("LOGOUT_USER").then((response) => {
      this.$q.notify({
        message: "Logged out Successfully!",
        color: "black",
        actions: [
          {
            label: "Dismiss",
            color: "white",
            handler: () => {
              /* ... */
            },
          },
        ],
      });
      this.$router.push("/");
    });
  },
};
</script>