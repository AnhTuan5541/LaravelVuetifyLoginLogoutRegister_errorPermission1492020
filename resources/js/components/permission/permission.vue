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
                Permission
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table :headers="headers" :items="permissionList" :search="search">

                <template v-slot:top>
                  <v-toolbar flat color="white">
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="600px">
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn  color="primary" dark class="mb-2" v-bind="attrs" v-on="on" v-if="isAdd">New Item</v-btn>
                      </template>
                      <v-card>
                        <v-card-title>
                          <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                          <v-container>
                            <v-row>
                              <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.name" label="Name" @keyup.enter="save"></v-text-field>
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
                  <v-icon small class="mr-2" @click="editItem(item)" v-if="isEdit">mdi-pencil</v-icon>
                  <v-icon small @click="deleteItem(item)" v-if="isDelete">mdi-delete</v-icon>
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
//     permissionList: {
//       get() {
//         return this.$store.state.permission.permissionList;
//       },
//     },
//   },
//   created() {
//     this.$store.dispatch("permission/getPermissions");
//   },
// };
export default {
  data() {
    return {
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
      error: [],
    };
  },

  computed: {
    isAdd() {
      let userPermissions = this.$store.state.currentUser.permissions;
      for ( var i = 0; i< userPermissions.length; i++) {
          if( userPermissions[i].name === "Thêm phân quyền") return true
      }
      return false
    },
    isEdit() {
      let userPermissions = this.$store.state.currentUser.permissions;
      for ( var i = 0; i< userPermissions.length; i++) {
          if( userPermissions[i].name === "Sửa phân quyền") return true
      }
      return false
    },
    isDelete() {
      let userPermissions = this.$store.state.currentUser.permissions;
      for ( var i = 0; i< userPermissions.length; i++) {
          if( userPermissions[i].name === "Xoá phân quyền") return true
      }
      return false
    },

    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
  created () {
    this.$store.dispatch("permission/getPermissions");
  },
  methods: {
    editItem (item) {
      this.editedIndex = this.permissionList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },
    deleteItem (item) {
      let permission = item
      const index = this.permissionList.indexOf(permission)
      axios.delete('api/v1/permission/destroy/' + permission.id)
      .then(response => {
          console.log(response.data.result)
          this.permissionList.splice(index, 1)
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
        const name = this.editedItem.name
        axios.put('api/v1/permission/update/' + this.editedItem.id, {
          name : this.editedItem.name,
        })
        .then((response) => {
          // Object.assign(this.permissionList[this.editedIndex], this.editedItem)
          Object.assign(this.permissionList[index], response.data.permission)
        })
        .catch((error) => {
          console.log(error.response.data.errors.name)
        })
      } 
      // add item
      else {
        // this.permissionList.unshift(this.editedItem)
        axios.post('api/v1/permission/store', {
          name : this.editedItem.name,
        })
        .then((response) => {
          this.permissionList.unshift(response.data.permission)
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