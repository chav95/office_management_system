<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card">
          <!-- <create-employee :selected_employee="selected_employee" @success="loadEmployeeList()"></create-employee> -->
          <import-salary @success="loadYearSelect()"/>
          <div class="card-header">
            <h3 class="card-title"><strong>Salary Slip List</strong></h3>
            <!-- <button class="btn btn-primary" style="float: right" @click="createEmployee()">Add New Employee</button> -->
            <button v-if="userLogin.privilege != 'salary'" class="btn btn-primary" style="float: right; margin-right: 5px" data-toggle="modal" data-target="#UploadSalary">Import Salary</button>
          </div>
          <div class="card-body">
            <template v-if="userLogin.privilege != 'salary'">
              <div class="form-group text-center mb-0">
                <h4 class="mb-0">Period:</h4>
                <select v-model="month_select" class="form-control month-select mr-2">
                  <option value="0" disabled>-Month-</option>
                  <option v-for="index in 12" :key="index" :value="index">{{month_arr[index]}}</option>
                </select>
                <select v-model="year_select" class="form-control year-select mr-2">
                  <option value="0" disabled>-Year-</option>
                  <option v-for="year in year_arr" :key="year" :value="year">{{year}}</option>
                </select>
                <button class="form-control btn btn-success period-search mr-2" @click="loadPeriodSlip()">Search</button>
              </div>
              <hr class="header-line-bot mt-0 mb-4">
            </template>

            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Employee Name</th>
                  <th>NIK</th>
                  <th>NPWP</th>
                  <th>Period</th>
                  <th>Start Working From</th>
                  <!-- <th>Action</th> -->
                </tr>
              </thead>
              <tbody>
                <template v-if="employee_list.data.length > 0">
                  <tr v-for="item in employee_list.data" :key="item.id">
                    <td>
                      <router-link v-if="userLogin.privilege == '!salary'" :to="`/hrd/salary-slip/${item.id}`" title="See Salary Slip">{{item.name}}</router-link>
                      <p>{{item.name}}</p>
                    </td>
                    <td>{{item.nik}}</td>
                    <td>{{item.npwp}}</td>
                    <td>
                      <router-link :to="`/hrd/salary-slip/${item.nik}`" target="_blank" title="See Salary Slip">{{periode(item.month, item.year)}}</router-link>
                    </td>
                    <td>{{formatDate(item.entry_date)}}</td>
                    <!-- <td>
                      <div class="modify_box">
                        <a class="modify-btn" @click="editEmployee(item)" title="Edit Slip">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem(item)" title="Delete Slip">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td> -->
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">{{first_load == true ? 'Search Period First' : 'Selected Period Is Empty'}}</h5></td></tr>
                </template>
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
  import ImportSalary from './modals/ImportSalary'

  export default {
    components: {
      CreateEmployee, ImportSalary
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },

        first_load: true,
        month_select: 0,
        year_select: 0,
        loading: false,

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
        month_arr: [
          '-Month-',
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ],
        year_arr: [],
      }
    },
    methods:{
      formatDate(datetime){
        return moment(String(datetime)).format('ll')
      },
      periode(month, year){
        let m = month.toString().length == 1 ? `0${month}` : month;
        return moment(new Date(`${m}-01-${year}`)).format("MMMM YYYY")
      },

      loadYearSelect(){
        // let default_val = ['-Year-']
        axios.get(`${window.location.origin}/api/employee/getYearSelect`)
          .then(({data}) => {
            // this.year_arr = [...default_val, ...data]
            this.year_arr = data
          })
      },
      loadPeriodSlip(){
        this.first_load = false

        if(this.month_select == 0){
          this.$alert('Select Month First', '', 'error');
        }else if(this.year_select == 0){
          this.$alert('Select Year First', '', 'error');
        }else{
          this.loading = true

          axios.get(`${window.location.origin}/api/employee/period-${this.month_select}-${this.year_select}`)
            .then(({data}) => {
              this.loading = false
              this.employee_list = data
            }) 
        }
      },
      loadPersonalList(){
        this.first_load = false
        this.loading = true

        axios.get(`${window.location.origin}/api/employee/${this.userLogin.username}`)
          .then(({data}) => {
            this.loading = false
            this.employee_list = data
          }) 
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
        axios.get(`${window.location.origin}/api/employee/period-${this.month_select}-${this.year_select}?page=${page}`)
          .then(({data}) => {
            this.loading = false
            this.employee_list = data
          })
      },
    },
    watch: {
      // bookingItem: {
      //   handler: function(newVal, oldVal) { //console.log('triggered')
      //     this.fill_available_room()
      //     this.room_id = this.bookingItem.room.id
      //   },
      //   immediate: true,
      //   deep: true,
    },
    mounted() {
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;

        if(data.privilege == 'salary'){
          this.loadPersonalList()
        }
      })

      // this.loadEmployeeList()
      this.loadYearSelect()
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

  .month-select{
    display: inline-block;
    width: 120px;
  }
  .year-select{
    display: inline-block;
    width: 85px;
  }
  .period-search{
    width: 80px;
    vertical-align: baseline;
  }

  .header-line-bot{
    border-bottom: 2px solid #212529;
  }
</style>