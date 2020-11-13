<template>
  <div class="container">
    <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><strong>Vendor List</strong></h3>
            <button v-if="can_modify" class="btn btn-primary createBtn" style="float: right" id="createItemBtn" @click="createItem()">Create New Vendor</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 100%;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th>Vendor</th>
                  <th>Registered At</th>
                  <th v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="vendor_list.data.length > 0">
                  <tr  v-for="item in vendor_list.data" :key="item.id" hover:bg-blue px-4 py2>
                    <!-- <td>{{item.name | ucwords}}</td> -->
                    <td>{{item.name}}</td>
                    <td>{{formatDatetime(item.created_at)}}</td>
                    <td v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">
                      <div v-if="can_modify" class="modify-btn-container">
                        <a class="modify-btn" title="Edit" v-on:click="editItem(item.id, item.name)">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" title="Delete" v-on:click="deleteItem(item.id, item.name)">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h3 class="text-center">Vendor Is Empty</h3></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="vendor_list" @pagination-change-page="getResults"></pagination>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form @submit.prevent="submitUser">
              <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">{{modalTitle}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="form-group">
                  <label>Vendor Name</label>
                  <input v-model="form.name" type="text" name="name" placeholder="Vendor Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">{{modalBtnText}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div></div>
  </div>
</template>

<script>
  import Form from 'vform';
  import moment from 'moment';

  export default {
    data(){
      return{
        userLogin: {
          id: 0,
        },

        form: new Form({
          act: String,
          id: Number,
          name: String,
        }),
        vendor_list: {data: {}},
        modalTitle: '',
        modalBtnText: '',
      }
    },
    mounted(){
      this.loadUserlogin()
      this.loadVendorList()
    },
    computed:{
      can_modify(){
        if(this.userLogin.privilege == 'super_admin' || this.userLogin.privilege == 'admin'){
          return true
        }
        return false
      }
    },
    methods: {
      loadUserlogin(){
        axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
          this.userLogin = data;
        })
      },
      loadVendorList(){
        axios.get(window.location.origin+'/api/vendor/getVendorList')
          .then(({data}) => {
            this.vendor_list = data
          })
      },
      formatDatetime(datetime){
        return moment(String(datetime)).format('llll');
      },
      getResults(page = 1) {
        axios.get(window.location.origin+'/api/vendor/getVendorList?page=' + page)
          .then(response => {
              this.vendor_list = response.data;
          });
      },
      createItem(){
        this.modalTitle = 'Create New Vendor'
        this.modalBtnText = 'Create New'
        this.form.id = 0
        this.form.act = 'create'
        this.form.name = ''
        $('#modifyModal').modal('show');
      },
      editItem(id, name){
        this.modalTitle = 'Edit Vendor'
        this.modalBtnText = 'Submit Edit'
        this.form.id = id
        this.form.act = 'edit'
        this.form.name = name
        $('#modifyModal').modal('show');
      },
      submitUser(){
        this.form.post(window.location.origin+'/api/vendor')
          .then(({response}) => {
            $('#modifyModal').modal('hide');
            this.$alert(`${this.modalTitle} Successful`, '', 'success')
            this.loadVendorList()
          })
          .catch(err => this.$alert('Invalid Data', '', 'error'));
      },
      deleteItem(item_id, item_name){
        this.$confirm('Permanently delete vendor '+item_name+'?', '', 'question')
          .then( () => {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( () => {
                axios.delete(window.location.origin+'/api/vendor/'+item_id)
                  .then(({response}) => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadVendorList();
                  })
                  .catch(({error}) => this.$alert(error.message, '', 'error'));
              });
          })
          .catch(error => console.error(error));
      },
    },
  }
</script>