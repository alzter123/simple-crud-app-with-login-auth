<template>
  <div v-if="this.accessType === '1'">
      <h3>Welcome, Admin!</h3>
      <q-btn @click="createUser" color="primary" label="Create User" />
      <br/>
      <br/>
      <q-btn to="/logout" color="primary" label="Logout" />
      <br/>
      <br/>
       <q-table
              :data="userList"
              :columns="columns"
              row-key="userId"
              selection="single"
              :selected.sync="selected"
            >
              <template v-slot:top-left>
                <b style="font-size: 25px">List of Users</b>
              </template>
              <template v-slot:top-right>
                <q-btn
                  color="primary"
                  @click.native="gatherUserData(selected)"
                >
                  <q-tooltip
                    content-style="font-size: 16px;"
                    content-class="bg-blue"
                    >Edit User</q-tooltip
                  >
                  <span class="material-icons" style="font-size: 25px"
                    >create</span
                  > </q-btn
                >&nbsp;
                <q-btn color="red" @click.native="delUser(selected)">
                  <q-tooltip
                    content-style="font-size: 16px;"
                    content-class="bg-red"
                    >Delete User</q-tooltip
                  >
                  <span class="material-icons" style="font-size: 25px"
                    >delete</span
                  > </q-btn
                >&nbsp;
              </template>
            </q-table>
            <q-dialog v-model="confirmDel" persistent>
            <q-card>
              <q-card-section class="row items-center">
                <p>
                  <b style="font-size: 25px; color: red"
                    >Are you sure you want to delete this user?</b
                  >
                </p>
              </q-card-section>
              <q-card-section class="row items-center">
                <span class="q-ml-sm"></span>
              </q-card-section>

              <q-card-actions align="right">
                <q-btn label="Yes" color="red" @click="deleteUser" />
                <q-btn label="No" color="primary" v-close-popup />
              </q-card-actions>
            </q-card>
          </q-dialog>
       <q-dialog v-model="activateAdd" persistent>
            <q-card style="width: 600px; height: 750px" align="center">
              <h4>Add User</h4>
              <q-input
                label="Username"
                outlined
                v-model="addUser.user"
                style="width: 400px"
                counter
                maxlength="50"
              />
              <q-input
                label="Password"
                outlined
                v-model="addUser.pass"
                style="width: 400px"
                counter
                maxlength="100"
              />
              <q-input
                label="First Name"
                outlined
                v-model="addUser.fname"
                style="width: 400px"
                counter
                maxlength="50"
              />
              <q-input
                label="Last Name"
                outlined
                v-model="addUser.lname"
                style="width: 400px"
                counter
                maxlength="50"
              />
              <br />
              <q-card-actions align="center">
                <q-btn
                  label="Save"
                  @click.prevent="addThisUser"
                  color="primary"
                />&nbsp;
                <q-btn label="Cancel" v-close-popup color="primary" />
              </q-card-actions>
            </q-card>
          </q-dialog>
          <q-dialog v-model="showUsers" persistent>
          <q-card style="width: 600px; height: 400px" align="center">
            <h4>Update User</h4>
            <q-input
              label="Subject ID"
              filled
              v-model="editUserData.userId"
              class="hidden"
            />
            <q-input
                label="Username"
                outlined
                v-model="editUserData.user"
                style="width: 400px"
                counter
                maxlength="50"
              />
              <q-input
                label="Password"
                outlined
                v-model="editUserData.pass"
                style="width: 400px"
                counter
                maxlength="100"
              />
            <q-input
              label="First Name"
              outlined
              v-model="editUserData.fname"
              style="width: 300px"
              counter
              maxlength="40"
            />
            <q-input
              label="Last Name"
              outlined
              v-model="editUserData.lname"
              style="width: 300px"
              counter
              maxlength="40"
            />
            <br />

            <q-card-actions align="center">
              <q-btn
                label="Update"
                @click="updateUser"
                color="primary"
              />&nbsp;
              <q-btn label="Cancel" v-close-popup color="primary" />
            </q-card-actions>
          </q-card>
        </q-dialog>

  </div>
</template>

<script>
import axios from "axios";

export default {
  name: 'PageIndex',
  data(){
    return {
    accessType: "",
    token: this.$store.state.token,
    activateAdd: false,
    addUser: {
        user: "",
        pass: "",
        fname: "",
        lname: ""
    },
    userList: [],
     columns: [
        {
          label: "First Name",
          align: "center",
          name: "fname",
          field: "fname",
          sortable: true,
        },
        {
          label: "Last Name",
          align: "center",
          name: "lname",
          field: "lname",
          sortable: true,
        },
      ],
      selected: [],
      showUsers: false,
      delUserData: {
          userId: ""
      },
      editUserData: {
          userId: "",
          user: "",
          pass: "",
          fname: "",
          lname: ""
      },
      
      confirmDel: false
  }
  },
  methods: {
      gatherUserData(selected){
        this.showUsers = true;
      this.editUserData.userId = selected[0].userId;
      this.editUserData.user = selected[0].user;
      this.editUserData.pass = selected[0].pass;
      this.editUserData.fname = selected[0].fname;
      this.editUserData.lname = selected[0].lname;
      },
      updateUser() {
      this.$store
        .dispatch("UPDATE_USER", {
          userId: this.editUserData.userId,
          user: this.editUserData.user,
          pass: this.editUserData.pass,
          fname: this.editUserData.fname,
          lname: this.editUserData.lname,
        })
        .then((res) => {
            this.showUsers = false;
                       this.$q.notify({
            message: res.data,
            color: "primary",
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
           setTimeout(function () {
            window.location.reload();
          }, 3000);
          })
       },
       
      delUser(selected){
        this.confirmDel = true;
        this.delUserData.userId = selected[0].userId;
      },
      deleteUser(){
        this.$store
        .dispatch("DELETE_USER", {
          userId: this.delUserData.userId,
        })
        .then((res) => {
          this.confirmDel = false;
            this.$q.notify({
            message: res.data,
            color: "primary",
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
           setTimeout(function () {
            window.location.reload();
          }, 3000);
          })
          
      },
       getAdminAccess(){
         axios.get('http://localhost/myvuebackend/', {
            params: {
                getId: 1,
                token: this.token
            }
         }).then(res => {
             for(var a = 0; a < res.data.length; a++){
                 this.accessType = res.data[a].AccessId;
             }
         })
     },
     getUserList(){
         axios.get('http://localhost/myvuebackend/', {
            params: {
                getId: 2,
                token: this.token
            }
         }).then(response => {
             for(var b = 0; b < response.data.length; b++){
                 this.userList.push({
                userId: response.data[b].UserId,
                user: response.data[b].Username,
                pass: response.data[b].Password,
              fname: response.data[b].FirstName,
              lname: response.data[b].LastName
                  });
         }
         })
     },
     addThisUser(){
         this.$store.dispatch('ADD_USER', {
             username: this.addUser.user,
             password: this.addUser.pass,
             fname: this.addUser.fname,
             lname: this.addUser.lname
         }).then(res => {
            this.$q.notify({
            message: res.data,
            color: "primary",
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
           setTimeout(function () {
            window.location.reload();
          }, 3000);
         })
         
             
     },
     createUser(){
         this.activateAdd = true;
     },
     logout(){
         this.$store.dispatch
     }

    
  },
  created(){
      this.getAdminAccess();
      this.getUserList();
  }
}
</script>
