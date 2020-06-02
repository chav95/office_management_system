<template>
  <div class="container">
    <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><strong>User List</strong></h3>
            <button class="btn btn-primary createBtn" style="float: right" id="createUserBtn" @click="createUser()">Create New User</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 100%;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Division</th>
                  <th>User Type</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="allUser.data.length > 0">
                  <tr  v-for="user in allUser.data" :key="user.id" hover:bg-blue px-4 py2>
                    <td>{{user.name | ucwords}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.division.name}}</td>
                    <td>{{user.privilege.replace('_', ' ') | ucwords}}</td>
                    <td>{{formatDatetime(user.created_at)}}</td>
                    <td>
                      <div class="modify-btn-container">
                        <a class="modify-btn" title="Edit" v-on:click="editUser(user.id, user.name, user.email, user.division_id, user.privilege)">
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
            <form @submit.prevent="submitUser">
              <div class="modal-header">
                <h5 class="modal-title" id="modifyModalLabel">{{modalTitle}}</h5>
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
                  <label>Division</label>
                  <select v-model="form.division" name="division" class="form-control" :class="{ 'is-invalid': form.errors.has('division') }">
                    <option value="0" disabled>User Division</option>
                    <option v-for="item in division_list" :key="item.id" :value="item.id">{{item.name}}</option>
                  </select>
                  <has-error :form="form" field="division"></has-error>
                </div>
                <div class="form-group">
                  <label>User Type</label>
                  <select v-model="form.privilege" name="privilege" class="form-control" :class="{ 'is-invalid': form.errors.has('privilege') }">
                    <option value="" disabled>User Access Type</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                  </select>
                  <has-error :form="form" field="privilege"></has-error>
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
        form: new Form({
          act: String,
          id: Number,
          name: String,
          email: String,
          division: Number,
          privilege: String,
          // hak_akses: String,
        }),
        allUser: {data: {}},
        division_list: {},
        modalTitle: '',
        modalBtnText: '',
        // action: '',
      }
    },
    methods: {
      loadAllUser(){
        axios.get(window.location.origin+'/api/user/getUserList').then(({data}) => (this.allUser = data));
      },
      loadDivisionData(){
        axios.get(window.location.origin+'/api/division/getDivisionData')
          .then(({data}) => {
            this.division_list = data
          })
      },
      formatDatetime(datetime){
        return moment(String(datetime)).format('llll');
      },
      getResults(page = 1) {
        axios.get(window.location.origin+'/api/user/getUserList?page=' + page)
          .then(response => {
              this.allUser = response.data;
          });
      },
      createUser(){
        this.modalTitle = 'Create New User'
        this.modalBtnText = 'Create New'
        this.form.id = 0
        this.form.act = 'new_user'
        this.form.name = ''
        this.form.email = ''
        this.form.division = 0
        this.form.privilege = ''
        // this.form.hak_akses = '';
        $('#modifyModal').modal('show');
      },
      editUser(id, name, email, division, privilege){
        this.modalTitle = 'Edit User'
        this.modalBtnText = 'Submit Edit'
        this.form.id = id
        this.form.act = 'edit_user'
        this.form.name = name
        this.form.email = email
        this.form.division = division
        this.form.privilege = privilege
        // this.form.hak_akses = selectedUser.hak_akses.id;
        $('#modifyModal').modal('show');
      },
      submitUser(){
        this.form.post(window.location.origin+'/api/user')
          .then(({response}) => {
            $('#modifyModal').modal('hide');
            this.$alert(`${this.modalTitle} Successful`, '', 'success');
            this.loadAllUser();
          })
          .catch(err => this.$alert('Invalid Data', '', 'error'));
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
        this.loadAllUser()
        this.loadDivisionData()
        //console.log('Component mounted.')
    }
  }
</script>