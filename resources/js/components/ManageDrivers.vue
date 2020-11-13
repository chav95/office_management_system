<template>
  <div class="container">
    <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title"><strong>Driver List</strong></h3>
            <button class="btn btn-primary createBtn" style="float: right" id="createUserBtn" @click="createUser()">Create New Driver</button>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0" style="height: 100%;">
            <table class="table table-head-fixed">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Assigned Car</th>
                  <th>Registered At</th>
                  <th v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="driver.data.length > 0">
                  <tr  v-for="user in driver.data" :key="user.id" hover:bg-blue px-4 py2>
                    <!-- <td>{{user.name | ucwords}}</td> -->
                    <td>{{user.name}}</td>
                    <td>  
                      {{user.car == null 
                        ? '-'
                        : `${user.car.type} (${user.car.police_number})`
                      }}
                    </td>
                    <td>{{formatDatetime(user.created_at)}}</td>
                    <td v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">
                      <div class="modify_box">
                        <a class="modify-btn" title="Edit" v-on:click="editDriver(user.id, user.name, user.car === null ? 0 : user.car.id)">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" title="Delete" v-on:click="deleteDriver(user.id, user.name)">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h3 class="text-center">No Registered Driver</h3></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="driver" @pagination-change-page="getResults"></pagination>
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
                  <label>Driver Name</label>
                  <input v-model="form.name" type="text" name="name" placeholder="Driver Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Assign To Car</label>
                  <select v-model="form.car" name="car" class="form-control" :class="{ 'is-invalid': form.errors.has('car') }">
                    <option value="0" disabled>Select Car</option>
                    <option v-for="item in car_list" :key="item.id" :value="item.id">{{item.type}} ({{item.police_number}})</option>
                  </select>
                  <has-error :form="form" field="car"></has-error>
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
          action: String,
          id: Number,
          name: String,
          car: Number,
          // hak_akses: String,
        }),
        driver: {data: {}},
        car_list: {},
        modalTitle: '',
        modalBtnText: '',
        // action: '',
      }
    },
    mounted(){
      this.loadUserlogin()
      this.loadAllDriver()
      this.loadCarList()
    },
    methods: {
      loadUserlogin(){
        axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
          this.userLogin = data;
        })
      },
      loadAllDriver(){
        axios.get(window.location.origin+'/api/driver/getDriverList').then(({data}) => (this.driver = data));
      },
      loadCarList(){
        axios.get(window.location.origin+'/api/car/getCarList')
          .then(({data}) => {
            this.car_list = data
          })
      },
      formatDatetime(datetime){
        return moment(String(datetime)).format('llll');
      },
      getResults(page = 1) {
        axios.get(window.location.origin+'/api/driver/getDriverList?page=' + page)
          .then(response => {
              this.driver = response.data;
          });
      },
      createUser(){
        this.modalTitle = 'Create New User'
        this.modalBtnText = 'Create New'
        this.form.id = 0
        this.form.action = 'create_driver'
        this.form.name = ''
        this.form.car = 0
        $('#modifyModal').modal('show');
      },
      editDriver(id, name, car){
        this.modalTitle = 'Edit User'
        this.modalBtnText = 'Submit Edit'
        this.form.id = id
        this.form.action = 'edit_driver'
        this.form.name = name
        this.form.car = car
        $('#modifyModal').modal('show');
      },
      submitUser(){
        this.form.post(window.location.origin+'/api/driver')
          .then(({response}) => {
            $('#modifyModal').modal('hide');
            this.$alert(`${this.modalTitle} Successful`, '', 'success')
            this.loadUserlogin()
            this.loadAllDriver()
          })
          .catch(err => this.$alert('Invalid Data', '', 'error'));
      },
      deleteDriver(user_id, user_name){
        this.$confirm('Permanently delete driver '+user_name+'?', '', 'question')
          .then( () => {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( () => {
                axios.delete(window.location.origin+'/api/driver/'+user_id)
                  .then(({response}) => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadAllDriver();
                  })
                  .catch(({error}) => this.$alert(error.message, '', 'error'));
              });
          })
          .catch(error => console.error(error));
      },
    },
  }
</script>

<style scoped>
  .modify_box{
    width: 52px;
    margin-bottom: 10px;
  }
</style>