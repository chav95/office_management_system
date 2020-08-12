<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-maintenance
            :selected_maintenance="selected_maintenance"   
            @success="loadMaintenanceData()"
          />
          <import-maintenance @success="loadMaintenanceData()"/>
          <div class="card-header">
            <h3 class="card-title"><strong>Maintenance List</strong></h3>
            <button v-if="$route.path != '/maintenance/history'" class="btn btn-primary" style="float: right" @click="createItem()">New Maintenance</button>
            <button v-if="$route.path != '/maintenance/history'" class="btn btn-primary" style="float: right; margin-right: 5px" data-toggle="modal" data-target="#UploadMaintain">Import From Excel</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Name</th>
                  <!-- <th>Notification Date</th> -->
                  <th>Expire Date</th>
                  <th>Notes</th>
                  <th>Created By</th>
                  <th class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="maintenance_list.data.length > 0">
                  <tr v-for="(item) in maintenance_list.data" :key="item.id">
                    <td>{{item.name}}</td>
                    <!-- <td>{{formatDatetime(item.notif_date)}}</td> -->
                    <td>{{formatDatetime(item.due_date)}}</td>
                    <td><pre class="maintenance_description">{{item.description}}</pre></td>
                    <!-- <td>{{item.user.name | ucwords}}</td> -->
                    <td>{{item.user.name}}</td>
                    <td class="no-print">
                      <div class="modify_box" v-if="userLogin.id === item.created_by && $route.path != '/maintenance/history'">
                        <a class="modify-btn" @click="editItem(item)" title="Edit Maintenance">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem(item)" title="Delete Maintenance">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">No Maintenance</h5></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="maintenance_list" @pagination-change-page="getPageContent"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import moment from 'moment'
  import CreateMaintenance from './modals/CreateMaintenance'
  import ImportMaintenance from './modals/ImportMaintenance'

  export default {
    components: {
      CreateMaintenance, ImportMaintenance
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },
        maintenance_list: {
          data: []
        },

        selected_maintenance: {
          action: '',
          id: 0,
          name: '',
          notif_date: '',
          due_date: '',
          description: '',
        },
      }
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll')
      },
      loadMaintenanceData(){
        axios.get(window.location.origin+'/api/maintenance/getMaintenanceData')
          .then(({data}) => {
            this.maintenance_list = data
          })
      },
      loadMaintenanceHistory(){
        axios.get(window.location.origin+'/api/maintenance/getMaintenanceHistory')
          .then(({data}) => {
            this.maintenance_list = data
          })
      },

      getPageContent(page = 1) {
        let content = this.$route.path ==  '/maintenance/history' ? 'getMaintenanceHistory' : 'getMaintenanceData'
        axios.get(window.location.origin+`/api/maintenance/${content}?page=` + page)
          .then(response => {
            this.maintenance_list = response.data;
          });
      },

      createItem(){
        this.selected_maintenance = {
          action: 'create_maintenance',
          id: 0,
          name: '',
          notif_date: '',
          due_date: '',
          description: '',
        }
        $('#CreateMaintenance').modal('show')
      },
      editItem(item){
        this.selected_maintenance.id = item.id
        this.selected_maintenance.name = item.name
        this.selected_maintenance.due_date = item.due_date
        // this.selected_maintenance.notif_date = item.notif_date
        this.selected_maintenance.description = item.description
        this.selected_maintenance.action = 'edit_maintenance'
        $('#CreateMaintenance').modal('show')
      },
      deleteItem(item){
        this.$confirm(`Delete ${item.name}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/maintenance/${item.id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadMaintenanceData()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              });
          })
          .catch(error => console.error(error));
      }
    },
    mounted() {
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data
      })
      this.$route.path ==  '/maintenance/history' ? this.loadMaintenanceHistory() : this.loadMaintenanceData()
    },
    watch:{
      '$route.path'(newVal, oldVal){
        if(this.$route.path == '/maintenance/history'){
          this.loadMaintenanceHistory()
        }else{
          this.loadMaintenanceData()
        }
      },
    },
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }

  .modify_box{
    width: 52px;
    margin-bottom: 10px;
  }
  .maintenance_description{
    max-width: 350px;
    padding: 0;
    margin-bottom: 0;
    font-family: inherit;
    font-size: inherit;
  }
</style>