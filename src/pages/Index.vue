<template>
  <div align="center">
    <h3>User Management System</h3>
    <h4 style="margin-top: 50px;">Login Portal</h4>
    <b>Username:</b>
    <q-input filled v-model="user" style="width:500px;" required />
    <br/>
    <b>Password: </b>
    <q-input filled v-model="pass" style="width:500px;" required />
    <br/>
    <q-btn label="LOGIN" @click="logMeIn" />
  </div>
</template>

<script>

export default {
  name: 'PageIndex',
  data(){
    return {
    user: "",
    pass: ""
  }
  },
  methods: {
     logMeIn(){
    //    if(this.pass == "" && this.user == ""){
    //     this.$q.notify({
    //           message: "Empty fields. Please enter a username and a password!",
    //           color: "red",
    //           actions: [
    //             {
    //               label: "Dismiss",
    //               color: "white",
    //               handler: () => {
    //                 /* ... */
    //               },
    //             },
    //           ],
    //         });
    //   }
      // else if(this.user == ""){
      //      this.$q.notify({
      //         message: "Empty username. Please try again!",
      //         color: "red",
      //         actions: [
      //           {
      //             label: "Dismiss",
      //             color: "white",
      //             handler: () => {
      //               /* ... */
      //             },
      //           },
      //         ],
      //       });
      // } else if(this.pass == ""){
      //   this.$q.notify({
      //         message: "Empty password. Please try again!",
      //         color: "red",
      //         actions: [
      //           {
      //             label: "Dismiss",
      //             color: "white",
      //             handler: () => {
      //               /* ... */
      //             },
      //           },
      //         ],
      //       });
      // } 
     
      this.$store.dispatch("LOGIN_USER", {
        user: this.user,
        pass: this.pass
      }).then(response => {
      if(response.data.includes("Fail1")){
            this.$q.notify({
              message: "Invalid Username. Please try again!",
              color: "red",
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
        } else if(response.data.includes("Fail2")){
            this.$q.notify({
              message: "Invalid password. Please try again!",
              color: "red",
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
        } else if(response.data.includes("Fail3")){
            this.$q.notify({
              message: "Empty username field. Please try again!",
              color: "red",
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
        } else if(response.data.includes("Fail4")){
            this.$q.notify({
              message: "Empty password field. Please try again!",
              color: "red",
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
        } else if(response.data.includes("Fail5")){
        this.$q.notify({
              message: "Empty fields. Please enter a username and a password!",
              color: "red",
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
      }

        for(var i = 0; i < response.data.length; i++){
        if(response.data[i].AccessId === "1"){
          console.log("HELLO!");
          this.$router.push("/adminpage");
        } else if(response.data[i].AccessId === "2"){
          this.$router.push("/userpage");
        }
        }

      }).catch((error) => {
          console.log(error);
        });
    }
  }
}
</script>
