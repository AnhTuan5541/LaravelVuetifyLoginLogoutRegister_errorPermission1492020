<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="#">Home</a>
              </li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- <div class="card card-primary collapsed-card">
          <div class="card-header">
            <h3 class="card-title">General</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputAddName">Name</label>
                  <input type="text" id="inputAddName" class="form-control" v-model="addname" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="inputAddPrice">Price</label>
                  <input type="text" id="inputAddPrice" class="form-control" v-model="addprice" />
                </div>
              </div>
            </div>

            <button class="btn btn-success float-right" @click="createProduct()">Create</button>
            <button class="btn btn-secondary float-right" @click="cancel()">Cancel</button>
          </div>
        </div> -->
        <v-app id="inspire">
          <v-main>
            <!-- <v-container class="fill-height" fluid> -->
            <v-card>
              <v-card-title>
                User
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table :headers="headers" :items="userList" :search="search">

                <template v-slot:top>
                  <v-toolbar flat color="white">
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="900px">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on" @click="addItem">New Item</v-btn>
                      </template>
                      <v-card>
                        <v-card-title>
                          <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                          <v-container>
                            <v-row>
                              <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                              </v-col>
                              <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                              </v-col>

                              <v-col cols="12" sm="12" md="12">
                                <v-card-title>
                                    Role
                                    <v-spacer></v-spacer>
                                    <v-text-field
                                    v-model="searchRole"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                    ></v-text-field>
                                </v-card-title>
                                <template>
                                <v-data-table
                                    v-model="selectedRole"
                                    :headers="headerRoles"
                                    :items="roleList"
                                    :search="searchRole"
                                    :single-select="singleSelectRole"
                                    item-key="name"
                                    show-select
                                    class="elevation-1"
                                >
                                    <template v-slot:top>
                                    <v-switch v-model="singleSelectRole" label="Single select role" class="pa-3"></v-switch>
                                    </template>
                                </v-data-table>
                                </template>             
                              </v-col>

                              <v-col cols="12" sm="12" md="12">
                                <v-card-title>
                                    Permission
                                    <v-spacer></v-spacer>
                                    <v-text-field
                                    v-model="searchPermission"
                                    append-icon="mdi-magnify"
                                    label="Search"
                                    single-line
                                    hide-details
                                    ></v-text-field>
                                </v-card-title>
                                <template>
                                <v-data-table
                                    v-model="selectedPermission"
                                    :headers="headerPermissions"
                                    :items="permissionList"
                                    :search="searchPermission"
                                    :single-select="singleSelectPermission"
                                    item-key="name"
                                    show-select
                                    class="elevation-1"
                                >
                                    <template v-slot:top>
                                    <v-switch v-model="singleSelectPermission" label="Single select permission" class="pa-3"></v-switch>
                                    </template>
                                </v-data-table>
                                </template>             
                              </v-col>
                            </v-row>
                          </v-container>
                        </v-card-text>

                        <v-card-actions>
                          <v-spacer></v-spacer>
                          <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                          <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </v-toolbar>
                </template>

                <template v-slot:[`item.actions`]="{ item }">
                  <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
                  <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
                </template>
              </v-data-table>
            </v-card>
            <!-- </v-container> -->
          </v-main>
        </v-app>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      // headers: [
      //   { text: "Id", value: "id" },
      //   {
      //     text: "Name",
      //     align: "start",
      //     sortable: false,
      //     value: "name",
      //   },
      //   { text: "Email", value: "email" },
      //   { text: "Created At", value: "created_at" },
      //   { text: "Actions", value: "actions", sortable: false },
      // ],
      // computed: {
      //   userList: {
      //     get() {
      //       return this.$store.state.user.users;
      //     },
      //   },
      // },
      // created() {
      //   this.$store.dispatch("user/getUsers");
      // },
      // methods: {
      //   editItem(item) {
      //     console.log(item);
      //   },
      // },

      //User
      search: "",
      dialog: false,
      headers: [
        { text: 'Id', value: 'id' },
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Email', value: 'email' },
        { text: 'Created At', value: 'created_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      editedIndex: -1,
      editedItem: {
        name: '',
        email: '',
      },
      defaultItem: {
        name: '',
        email: '',
      },

      //Role
      searchRole: "",
      singleSelectRole: false,
      selectedRole: [],
      headerRoles: [
          { text: 'Id', value: 'id' },
          {
          text: 'Name',
          align: 'start',
          value: 'name',
          },
      ],

      // Permission
      searchPermission: '',
      singleSelectPermission: false,
      selectedPermission: [],
      headerPermissions: [
          { text: 'Id', value: 'id' },
          {
          text: 'Name',
          align: 'start',
          value: 'name',
          },
      ],
    };
  },

  computed: {
    userPermissions: {
      get() {
        return this.$store.state.currentUser.permissions;
      }
    },
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    userList: {
      get() {
        return this.$store.state.user.users;
      },
    },
    roleList: {
      get() {
        return this.$store.state.role.roles;
      },
    },
    permissionList: {
      get() {
        return this.$store.state.permission.permissions;
      },
    },
  },
  watch: {
    dialog (val) {
      val || this.close()
    },
  },
  beforeMount() {
    for ( let i = 0; i < this.userPermissions.length; i++) {
      if ( this.userPermissions[i].name === "add users") {
        this.isAdd = true;
      }
    }
  },
  created () {
    this.$store.dispatch("user/getUsers");
    this.$store.dispatch("role/getRoles");
    this.$store.dispatch("permission/getPermissions");
  },
  beforeCreate() {
    this.userPermissions;
  },
  methods: {
    addItem() {
      this.selectedRole = []
      this.selectedPermission = []
    },
    editItem (item) {
      this.editingItem = item
      this.editedIndex = this.userList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
      this.selectedRole = []
      this.selectedPermission = []
      axios.get('api/v1/user/permission/' + item.id)
      .then(response => {
        console.log(response.data)
        this.selectedRole = response.data.roles
        this.selectedPermission = response.data.permissions
      })
    },
    deleteItem (item) {
      const index = this.userList.indexOf(item)
      axios.delete('api/v1/user/destroy/' + item.id, {
        oldName : item.name
      })
      .then(response => {
          this.userList.splice(index, 1)
      })
      .catch(error => {
          this.errors = error.response.data.errors.name
      })
    },
    close () {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },
    save () {
      // edit item
      if (this.editedIndex > -1) {
        const index = this.editedIndex
        axios.put('api/v1/user/update/' + this.editedItem.id, {
          oldName : this.editingItem.name,
          name : this.editedItem.name,
          email : this.editedItem.email,
          role : this.selectedRole,
          permission : this.selectedPermission,
        })
        .then((response) => {
          Object.assign(this.userList[index], response.data.user)
        })
        .catch((error) => {
          console.log(error.response.data.errors.name)
        })
      } 
      
      // add item
      else {
        axios.post('api/v1/user/store', {
          name : this.editedItem.name,
          email : this.editedItem.email,
          role : this.selectedRole,
          permission : this.selectedPermission,
        })
        .then((response) => {
          this.userList.unshift(response.data.user)
        })
        .catch((error) => {
          console.log(error.response.data.errors.name)
        })
      }
      this.close()
    },
  },
};
</script>