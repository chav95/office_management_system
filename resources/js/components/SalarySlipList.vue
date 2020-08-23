<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <create-employee :selected_employee="selected_employee" @success="loadEmployeeList()"></create-employee>
          <div class="card-header">
            <h3 class="card-title"><strong>Salary Slip List</strong></h3>
            <button class="btn btn-primary" style="float: right" @click="createEmployee()">Add New Employee</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>NIK</th>
                  <th>NPWP</th>
                  <th>Start Working From</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in employee_list.data" :key="item.id">
                  <td><router-link :to="`/hrd/salary-slip/${item.id}`" title="See Salary Slip">{{item.name}}</router-link></td>
                  <td>{{item.nik}}</td>
                  <td>{{item.npwp}}</td>
                  <td>{{formatDate(item.entry_date)}}</td>
                  <td>
                    <div class="modify_box">
                      <a class="modify-btn" @click="editEmployee(item)" title="Edit Slip">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem(item)" title="Delete Slip">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="employee_list" @pagination-change-page="employeePageContent"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import moment from 'moment'
  import CreateEmployee from './modals/CreateEmployee.vue'

  export default {
    components: {
      CreateEmployee,
    },
    data(){
      return{
        employee_list: {data: []},
        selected_employee: {
          action: '',
          id: 0,
          nik: '',
          name: '',
          npwp: '',
          entry_date: '',
          gaji_tunjangan: 0,
          terima_pph: 0,
          total_terima_lain: 0,
          total_potongan_lain: 0,
          total_potongan_pph: 0,
          jumlah_penerimaan: 0,
          jumlah_potongan: 0,
          penerimaan_bersih: 0,
          pengurang: 0,
          penerimaan: 0,
        },
      }
    },
    methods:{
      formatDate(datetime){
        return moment(String(datetime)).format('ll')
      },

      createEmployee(){
        this.selected_employee = {
          action: 'create',
          id: 0,
          nik: '',
          name: '',
          npwp: '',
          entry_date: '',
          gaji_tunjangan: 0,
          terima_pph: 0,
          total_terima_lain: 0,
          total_potongan_lain: 0,
          total_potongan_pph: 0,
          jumlah_penerimaan: 0,
          jumlah_potongan: 0,
          penerimaan_bersih: 0,
          pengurang: 0,
          penerimaan: 0,
        }
        $('#CreateEmployee').modal('show');
      },
      editEmployee(item){
        this.selected_employee = item
        this.selected_employee.action = 'edit'
        $('#CreateEmployee').modal('show');
      },
      deleteItem(item){
        this.$confirm(`Delete Employee ${item.name}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/employee/${item.id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadEmployeeList()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              });
          })
          .catch(error => console.error(error));
      },
      
      loadEmployeeList(){
        axios.get(window.location.origin+'/api/employee/getEmployeeList')
          .then(({data}) => {
            this.employee_list = data
          })
      },
      employeePageContent(page = 1) {
        axios.get(window.location.origin+'/api/employee/getEmployeeList?page=' + page)
          .then(response => {
            this.employee_list = response.data
          })
      },
    },
    watch: {
      // '$route.params.playlist_id': function(playlist_id){
      //   this.loadWishlist()
      // }
    },
    mounted() {
      this.loadEmployeeList()
    }
  }
</script>

<style lang="scss" scoped>
  .card-tools{
    text-align: right;
  }

  .modify_box{
    width: 52px;
    margin-bottom: 10px;
  }
</style>