<template>
  <div v-if="this.accessType === '2'">
      <h3>Welcome, {{ name }}!</h3>
       <q-btn to="/logout" label="Logout" />
      <br/>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PageIndex',
  data(){
    return {
      accessType: "",
      token: this.$store.state.token,
      name: "",
  }
  },
  methods: {
   getUserAccess(){
         axios.get('http://localhost/myvuebackend/', {
            params: {
                getId: 1,
                token: this.token
            }
         }).then(res => {
             for(var a = 0; a < res.data.length; a++){
                 this.accessType = res.data[a].AccessId;
                 this.name = res.data[a].FirstName;
             }
         })
     },

    
  },
  created(){
    this.getUserAccess();
  }
}
</script>
