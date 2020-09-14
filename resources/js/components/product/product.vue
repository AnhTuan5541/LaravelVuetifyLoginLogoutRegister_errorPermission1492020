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
                Product
                <v-spacer></v-spacer>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  single-line
                  hide-details
                ></v-text-field>
              </v-card-title>
              <v-data-table :headers="headers" :items="productList" :search="search">

                <template v-slot:top>
                  <v-toolbar flat color="white">
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="600px">
                      <template v-slot:activator="{ on, attrs }">

                        <div>

                        <!-- <v-btn v-if="permission.name ==='Thêm sản phẩm' " color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item {{ userPermissions[1].name }}</v-btn> -->
                        <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
                        </div>
                      </template>
                      <v-card>
                        <v-card-title>
                          <span class="headline">{{ formTitle }}</span>
                        </v-card-title>

                        <v-card-text>
                          <v-container>
                            <v-row>
                              <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.name" label="Product name" @keyup.enter="save"></v-text-field>
                              </v-col>
                              <v-col cols="12" sm="12" md="12">
                                <v-text-field v-model="editedItem.price" label="Price 1" @keyup.enter="save"></v-text-field>
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
//         { text: "Price", value: "price" },
//         { text: "Created At", value: "created_at" },
//         { text: "Actions", value: "actions", sortable: false },
//       ],
//     };
//   },
//   computed: {
//     productList: {
//       get() {
//         return this.$store.state.product.productList;
//       },
//     },
//   },
//   created() {
//     this.$store.dispatch("product/getProducts");
//   },
// };
export default {
  data() {
    return {
      permissions: [],
      search: "",
      dialog: false,
      headers: [
        { text: 'Id', value: 'id' },
        {
          text: 'Product Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Price', value: 'price' },
        { text: 'Price', value: 'price' },
        { text: 'Price', value: 'price' },
        { text: 'Created At', value: 'created_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      editedIndex: -1,
      editedItem: {
        name: '',
        price: 0,
      },
      defaultItem: {
        name: '',
        price: 0,
      },
      error: [],
      isAdd: false,
      isEdit: false,
      isDelete: false,
    };
  },

  computed: {
    userPermissions: {
      get() {
        this.permissions = this.$store.state.currentUser.permissions;
        return this.$store.state.currentUser.permissions;
      }
    },
    formTitle () {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
    productList: {
      get() {
        return this.$store.state.product.products;
      },
    },
  },
  watch: {
    dialog (val) {
      val || this.close()
    },
  },
  // mounted() {
  //   for ( let i = 0; i < this.userPermissions.length; i++) {
  //     if ( this.userPermissions[i].name === "Thêm sản phẩm") {
  //       this.isAdd = true;
  //     }
  //     if ( this.userPermissions[i].name === "Sửa sản phẩm") {
  //       this.isEdit = true;
  //     }
  //     if ( this.userPermissions[i].name === "Xoá sản phẩm") {
  //       this.isDelete = true;
  //     }
  //   }
  // },
  beforeMount() {
    this.permissions = this.userPermissions
    console.log(this.permissions)
  },
  created () {
    this.$store.dispatch("product/getProducts");
    // this.$store.dispatch('currentUser/getUser');
  },
  // beforeCreate() {
  //   this.userPermissions;
  // },
  methods: {
    editItem (item) {
      this.editedIndex = this.productList.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },
    deleteItem (item) {
      let product = item
      const index = this.productList.indexOf(product)
      axios.delete('api/v1/product/destroy/' + product.id)
      .then(response => {
          this.productList.splice(index, 1)
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
        const price = this.editedItem.price
        axios.put('api/v1/product/update/' + this.editedItem.id, {
          name : this.editedItem.name,
          price: this.editedItem.price
        })
        .then((response) => {
          if(response.data.product) {
            Object.assign(this.productList[this.editedIndex], response.data.product)
          }
          // this.productList[index].name = name
          // this.productList[index].price = price
        })
        .catch((error) => {
          console.log(error.response.data.errors.name)
        })
      } 
      // add item
      else {
        axios.post('api/v1/product/store', {
          name : this.editedItem.name,
          price: this.editedItem.price
        })
        .then((response) => {
          if(response.data.product) {
            this.productList.unshift(response.data.product)
          }
          else {
            console.log(response.data.message)
          }
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