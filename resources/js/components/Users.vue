<template>
  <div class="container">
    <div class="row justify-content-center mt-4 mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <pagination :data="allUser" @pagination-change-page="getResults"></pagination>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 100%;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>User Type</th>
                  <th>Access Type</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="allUser.data.length > 0">
                  <tr  v-for="user in allUser.data" :key="user.id" hover:bg-blue px-4 py2>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.privilege}}</td>
                    <td>{{user.hak_akses}}</td>
                    <td>{{formatDatetime(user.created_at)}}</td>
                    <td>
                      <div class="modify-btn-container">
                        <a class="modify-btn" title="Edit" v-on:click="editUser(user)">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" title="Delete" v-on:click="deleteUser(user.id, user.name)">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h3 class="text-center">User Table Is Empty</h3></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="allUser" @pagination-change-page="getResults"></pagination>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="modal fade" id="modifyModal" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form @submit.prevent="submitEdit">
              <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body">
                <div class="form-group">
                  <label>User Name</label>
                  <input v-model="form.name" type="text" name="name" placeholder="User Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>User Email</label>
                  <input v-model="form.email" type="text" name="email" placeholder="User Email"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <label>User Type</label>
                  <input v-model="form.privilege" type="text" name="password" placeholder="User User Type"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('privilege') }">
                  <has-error :form="form" field="privilege"></has-error>
                </div>
                <div class="form-group">
                  <label>Access Type</label>
                  <input v-model="form.hak_akses" type="text" name="hak_akses" placeholder="User Hak Akses"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('hak_akses') }">
                  <has-error :form="form" field="hak_akses"></has-error>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Edit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import Form from 'vform';
  import moment from 'moment';

  export default {
    data(){
      return{
        selectedUserId: Number,
        form: new Form({
          name: String,
          email: String,
          privilege: String,
          hak_akses: String,
        }),
        allUser: {data: {}},
      }
    },
    methods: {
      loadAllUser(){
          axios.get(window.location.origin+'/api/user').then(({data}) => (this.allUser = data));
      },
      formatDatetime(datetime){
          return moment(String(datetime)).format('llll');
      },
      getResults(page = 1) {
          axios.get(window.location.origin+'/api/log?page=' + page)
              .then(response => {
                  this.allUser = response.data;
              });
      },
      editUser(selectedUser){ //console.log(selectedUser);
        this.selectedUserId = selectedUser.id;
        this.form.name = selectedUser.name;
        this.form.email = selectedUser.email;
        this.form.privilege = selectedUser.privilege;
        this.form.hak_akses = selectedUser.hak_akses;
        $('#modifyModal').modal('show');
      },
      submitEdit(){
        let userEdit = {
          'act': 'edit_user',
          'id': this.selectedUserId,
          'name': this.form.name,
          'email': this.form.email,
          'privilege': this.form.privilege,
          'hak_akses': this.form.hak_akses,
        };
        
        axios.post(window.location.origin+'/api/user', userEdit)
          .then(({response}) => {
            $('#modifyModal').modal('hide');
            this.$alert('Edit Successful', '', 'success');
            this.loadAllUser();
          })
          .catch(({error}) => this.$alert(error.message, '', 'error'));
      },
      deleteUser(user_id, user_name){
        this.$confirm('Permanently delete user '+user_name+'?', '', 'question')
          .then( () => {
              this.$confirm('This delete action cannot be undone!', '', 'warning')
                .then( () => {
                  axios.delete(window.location.origin+'/api/user/'+user_id)
                    .then(({response}) => {
                      this.$alert('Delete Successful', '', 'success');
                      this.loadAllUser();
                    })
                    .catch(({error}) => this.$alert(error.message, '', 'error'));
                });
          })
          .catch(error => console.error(error));
      }
    },
    mounted(){
        this.loadAllUser();
        //console.log('Component mounted.')
    }
  }
</script>