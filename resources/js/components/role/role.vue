<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
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
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- <div class="row"> -->
        <v-app id="inspire">
          <v-main>
            <!-- <v-container class="fill-height" fluid> -->
            <v-card>
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
              <v-data-table :headers="headerRoles" :items="roleList" :search="searchRole">
                <template v-slot:top>
                  <v-toolbar flat color="white">
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="900px">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn  color="primary" dark class="mb-2" v-bind="attrs" v-on="on" @click="addItem">New Item</v-btn>
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
                                    v-model="selected"
                                    :headers="headerPermissions"
                                    :items="permissionList"
                                    :search="searchPermission"
                                    :single-select="singleSelect"
                                    item-key="name"
                                    show-select
                                    class="elevation-1"
                                >
                                    <template v-slot:top>
                                    <v-switch v-model="singleSelect" label="Single select" class="pa-3"></v-switch>
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
        <!-- </div> -->
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</template>

<script>
// export default {
//   data() {
//     return {
//       search: "",
//       headers: [
//         { text: "Id", value: "id" },
//         {
//           text: "Name",
//           align: "start",
//           sortable: false,
//           value: "name",
//         },
//         { text: "Created At", value: "created_at" },
//         { text: "Actions", value: "actions", sortable: false },
//       ],
//     };
//   },
//   computed: {
//     roleList: {
//       get() {
//         return this.$store.state.role.roles;
//       },
//     },
//   },
//   created() {
//     this.$store.dispatch("role/getRoles");
//   },
// };
export default {
  data() {
    return {
      //Role
      searchRole: "",
      dialog: false,
      headerRoles: [
          { text: 'Id', value: 'id' },
          {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
          },
          { text: 'Created At', value: 'created_at' },
          { text: 'Actions', value: 'actions', sortable: false },
      ],
      editedIndex: -1,
      editedItem: {
          name: '',
      },
      defaultItem: {
          name: '',
      },
      editingItem: {},
      error: [],
      isAdd: false,

      // Permission
      searchPermission: '',
      singleSelect: false,
      selected: [],
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
        return this.$store.state.currentUser.user.user_permission;
      }
    },
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
//   beforeMount() {
//     for ( let i = 0; i < this.userPermissions.length; i++) {
//       if ( this.userPermissions[i].name === "add roles") {
//         this.isAdd = true;
//       }
//     }
//   },
  created () {
    this.$store.dispatch("role/getRoles");
    this.$store.dispatch("permission/getPermissions");
  },
//   beforeCreate() {
//     this.userPermissions;
//   },
  methods: {
    addItem() {
      this.selected = []
    },
    editItem (item) {
      this.editingItem = item
      this.editedIndex = this.roleList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
      this.selected = []
      axios.get('api/v1/role/permission/' + item.id)
      .then(response => {
        this.selected = response.data.permissions
      })
    },
    deleteItem (item) {
      const index = this.roleList.indexOf(item)
      axios.delete('api/v1/role/destroy/' + item.id)
      .then(response => {
          this.roleList.splice(index, 1)
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
        axios.put('api/v1/role/update/' + this.editedItem.id, {
          oldName : this.editingItem.name,
          name : this.editedItem.name,
          permission : this.selected,
        })
        .then((response) => {
          Object.assign(this.roleList[index], response.data.role)
        })
        .catch((error) => {
          console.log(error.response.data.errors.name)
        })
      } 

      // add item
      else {
        // this.roles.unshift(this.editedItem)
        axios.post('api/v1/role/store', {
          name : this.editedItem.name,
          permission : this.selected,
        })
        .then((response) => {
          this.roleList.unshift(response.data.role)
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