<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card" v-if="$route.path == '/manage-cars' || $route.path == '/manage-cars/booking-list' || $route.path == '/manage-cars/pending-list' || $route.path == '/manage-cars/history'">
          <book-car 
            :bookingItem="selected_booking"
            :carData="total_car" 
            @success="$route.path == '/manage-cars/pending-list' ? loadPendingBooking() : loadBookingData()"
          />
          <export-filter :module="exportModule"/>
          <assign-car 
            :bookingItem="selected_booking" 
            :carData="total_car" 
            :driverData="driver_list" 
            @success="assignSuccess()"
          />
          <div class="card-header">
            <h3 class="card-title">
              <strong>{{$route.path == '/manage-cars/pending-list' 
                ? 'Pending' 
                : $route.path == '/manage-cars/history'
                  ? 'History'
                  : ''
              }} Booking Car List</strong></h3>
            <button v-if="$route.path !== '/manage-cars/history'" class="btn btn-primary" style="float: right" @click="createBooking()">Book Car</button>
            <button v-else-if="$route.path == '/manage-cars/history'" class="btn btn-primary" style="float: right" @click="exportToExcel()">Export Booking</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Car Model / Police Number</th>
                  <th>Driver</th>
                  <th>Book Date</th>
                  <th>Destination</th>
                  <th>Purpose</th>
                  <th>User</th>
                  <th class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="booking_list.data.length > 0">
                  <tr v-for="(booking) in booking_list.data" :key="booking.id">
                    <td v-if="booking.car_id == 0"><i>Not Yet Assigned</i></td>
                    <td v-else>{{booking.car == null ? 'Car Deleted' : booking.car.type}} / {{booking.car == null ? '' : booking.car.police_number}}</td>
                    
                    <td v-if="booking.driver_id == 0"><i>Not Yet Assigned</i></td>
                    <td v-else>{{booking.driver == null ? 'Driver Deleted' : booking.driver.name}}</td>

                    <td>{{booktime(booking)}}</td>
                    <td>{{booking.destination}}</td>
                    <td>{{booking.purpose}}</td>
                    <!-- <td>{{formatDatetime(booking.tanggal)}} - {{booking.jam_awal}}.00 s/d {{booking.jam_akhir}}.00</td> -->
                    <td>
                      {{booking.user == null ? 'User Deleted' : booking.user.name}}
                      <span class="d-block"><i>({{fullDatetime(booking.created_at)}})</i></span>
                    </td>
                    <td class="no-print">
                      <template v-if="$route.path == '/manage-cars/pending-list' && booking.status == 0">
                        <div class="modify_box" v-if="booking.user.id == userLogin.id">
                          <a class="modify-btn" @click="editBooking(booking)" title="Edit Booking">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('booking_list', booking)" title="Delete Booking">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div>
                        <div class="modify_box" v-if="userLogin.id == 6 || userLogin.id == 20">
                          <a class="modify-btn" title="Assign Car & Driver" @click="assign(booking)">
                            <i class="fa fa-thumbtack color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" title="Reject Booking" @click="reject(booking)">
                            <i class="fa fa-window-close color-red fa-fw fa-lg"></i>
                          </a>
                        </div>
                      </template>
                      <template v-if="$route.path == '/manage-cars/pending-list' && booking.status == -1">
                        <div>
                          <span class="status status-rejected">Rejected</span>
                          <button class="btn btn-primary notes-btn" title="Reason For Rejection" @click="$alert(booking.notes)">
                            Notes
                          </button>
                          <button v-if="userLogin.id == 6 || userLogin.id == 20"
                            class="btn btn-danger notes-btn" title="Cancel Booking" 
                            @click="cancelReject(booking)"
                          >Cancel Reject</button>
                        </div>
                      </template>
                      <template v-if="$route.path != '/manage-cars/pending-list'">
                        <div class="text-center">
                          <span v-if="booking.status == -2" class="status status-rejected">Canceled</span>
                          <span v-else-if="booking.status == 2" class="status status-finished">Finished</span>

                          <button v-if="booking.notes !== null" class="btn btn-primary notes-btn" title="See Notes" @click="$alert(booking.notes)">
                            Notes
                          </button>

                          <template v-if="booking.status == 1 && $route.path != '/manage-cars/history'">
                            <template v-if="userLogin.id == booking.booked_by">  
                              <button class="btn btn-success notes-btn" title="Finish Booking" @click="finish(booking)">
                                Finish
                              </button>
                              <button class="btn btn-danger notes-btn" title="Cancel Booking" @click="cancel(booking)">
                                Cancel
                              </button>
                            </template>
                            <button class="btn btn-info notes-btn" title="Change Driver / Car" @click="assign(booking)" v-if="userLogin.id == 6 || userLogin.id == 20">
                              Edit Assign
                            </button>
                          </template>
                        </div>
                      </template>
                    </td>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">No Booking</h5></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="booking_list" @pagination-change-page="bookingPageContent"></pagination>
          </div>
        </div>

        <div class="card" v-else-if="$route.path === '/manage-cars/settings'">
          <create-car 
            :action="action" 
            :selected_car="selected_car" 
            :company_data="company_list" 
            :driver_data="driver_list" 
            :vendor_data="vendor_list" 
            :division_data="division_list" 
            @success="loadCarData()"
          />
          <div class="card-header">
            <h3 class="card-title"><strong>Car List</strong></h3>
            <button class="btn btn-primary" style="float: right" @click="createCar()">Create Car</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Company</th>
                  <th>Car Model</th>
                  <th>Engine</th>
                  <th>Police Number</th>
                  <!-- <th>Driver</th> -->
                  <th>STNK / Lease Timeline</th>
                  <th>Vendor</th>
                  <th>User</th>
                  <th v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">Action</th>
                </tr>
              </thead>
              <tbody>
                <template v-if="car_list.data.length > 0">
                  <tr v-for="(car) in car_list.data" :key="car.id">
                    <template v-if="car.police_number !== '-'">
                      <td>{{car.company.name}}</td>
                      <td>{{car.type}}</td>
                      <td>{{car.engine_cc}}</td>
                      <td>{{car.police_number}}</td>
                      <!-- <td>{{car.driver.name}}</td> -->

                      <td>
                        {{car.lease_start == '1970-01-01' ? '-' : formatDatetime(car.lease_start)}} 
                        s/d 
                        {{car.lease_due == '1970-01-01' ? '-' : formatDatetime(car.lease_due)}}
                      </td>
                      
                      <td>{{car.vendor == null ? '-' : car.vendor.name}}</td>
                      <td>{{car.division == null ? '-' : car.division.name}}</td>
                      <td v-if="userLogin.privilege == 'admin' || userLogin.privilege == 'super_admin'" class="no-print">
                        <div class="modify_box">
                          <a class="modify-btn" @click="editCar(car)" title="Edit Car">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('car_list', car)" title="Delete Car">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div>
                      </td>
                    </template>
                  </tr>
                </template>
                <template v-else>
                  <tr><td colspan="100%"><h5 class="text-center">No Available Car</h5></td></tr>
                </template>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="car_list" @pagination-change-page="carPageContent"></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
  import moment from 'moment'
  import BookCar from './modals/BookCar'
  import AssignCar from './modals/AssignCar'
  import CreateCar from './modals/CreateCar'
  import ExportFilter from './modals/ExportFilter'

  export default {
    components: {
      BookCar, AssignCar, CreateCar, ExportFilter
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },

        booking_list: {data: []},
        selected_booking: {
          action: '',
          id: 0,
          tanggal: '',
          jam_awal: -1,
          jam_akhir: 0,
          destination: '',
          purpose: '',
          user: {
            id: '',
            name: '',
          },
        },
        car_list: {data: []},
        total_car: [],

        company_list: [],
        driver_list: [],
        vendor_list: [],
        division_list: [],

        action: '',
        selected_car: {
          id: 0,
          company_id: 0,
          type: '',
          engine_cc: 0,
          police_number: '',
          driver_id: 0,
          lease_start: '',
          lease_due: '',
          lease_price: 0,
          vendor_id: 0,
          division_id: 0,
        },

        exportModule: '',
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      })
      
      if(this.$route.path == '/manage-cars/pending-list'){
        this.loadPendingBooking()
      }else if(this.$route.path == '/manage-cars/history'){
        this.loadBookingHistory()
      }else{
        this.loadBookingData()
      }

      this.loadCarData()
      this.loadCarList()

      this.loadCompanyData()
      this.loadDriverData()
      this.loadVendorData()
      this.loadDivisionData()
    },
    computed:{
      car_content(){
        return this.car_id == 0
          ? '-'
          : `${this.car.type} / ${this.car.police_number}`                      
      }
    },
    watch:{
      '$route.path'(newVal, oldVal){
        if(this.$route.path == '/manage-cars/pending-list'){
          this.loadPendingBooking()
        }else if(this.$route.path == '/manage-cars/history'){
          this.loadBookingHistory()
        }else{
          this.loadBookingData()
        }
      },
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },
      formatTime(datetime){
        moment.locale('id');
        return moment(String(datetime)).format('LT');
      },
      booktime(item){
        if(item.jam_akhir == null){
          return `${this.formatDatetime(item.tanggal)} - ${item.jam_awal}.00`
        }
        return `${this.formatDatetime(item.tanggal)} - ${item.jam_awal}.00 s/d ${this.formatTime(item.jam_akhir)}`
      },
      fullDatetime(datetime){
        moment.locale('id');
        return moment(String(datetime)).format('lll');
      },

      exportToExcel(){
        this.exportModule = 'car_booking'

        $('#ExportFilter').modal('show');
      },
      
      createCar(){
        this.action = 'create'
        this.selected_car = {
          id: 0,
          company_id: 0,
          type: '',
          engine_cc: 0,
          police_number: '',
          driver_id: 0,
          lease_start: '',
          lease_due: '',
          lease_price: 0,
          vendor_id: 0,
          division_id: 0,
        }
        $('#CreateCar').modal('show');
      },
      editCar(item){
        this.action = 'edit'
        this.selected_car = item
        $('#CreateCar').modal('show');
      },
      assign(item){
        this.selected_booking = item
        $('#AssignCar').modal('show');
      },
      assignSuccess(){
        this.loadPendingBooking()
        this.loadCarData()
      },
      reject(item){
        this.$prompt('State Reason For Rejection')
          .then(reject_notes => {
            this.$confirm(`Confirm Reject '${item.purpose}' Booking?`, '', 'warning')
              .then(()=> {
                let reject_data = {
                  action: 'reject',
                  booking_id: item.id,
                  notes: reject_notes
                }
                axios.post(`${window.location.origin}/api/car`, reject_data)
                  .then(res => {
                    this.$alert('Reject Successful', '', 'success');
                    this.loadPendingBooking()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              })
          })
          .catch(err => {
            this.$alert('Reason For Rejection Cannot Be Empty', '', 'error')
          })
      },
      finish(item){
        this.$confirm(`Confirm Finish '${item.purpose}' Booking?`, '', 'warning')
          .then(()=> {
            let finish_data = {
              action: 'finish',
              booking_id: item.id,
            }
            axios.post(`${window.location.origin}/api/car`, finish_data)
              .then(res => {
                this.$alert('Mark Booking As Finished', '', 'success');
                this.loadBookingData()
              })
              .catch(err => {
                this.$alert(err, '', 'error')
              })
          })
      },
      cancel(item){
        this.$prompt('State Reason For Cancel Booking')
          .then(cancel_notes => {
            this.$confirm(`Confirm Cancel '${item.purpose}' Booking?`, '', 'warning')
              .then(()=> {
                let cancel_data = {
                  action: 'cancel',
                  booking_id: item.id,
                  notes: cancel_notes
                }
                axios.post(`${window.location.origin}/api/car`, cancel_data)
                  .then(res => {
                    this.$alert('Cancel Successful', '', 'success')
                    this.loadBookingData()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              })
          })
          .catch(err => {
            this.$alert('Reason For Cancel Booking Cannot Be Empty', '', 'error')
          })
      },
      cancelReject(item){
        this.$confirm(`Cancel Reject '${item.purpose}' Booking?`, '', 'warning')
          .then(()=> {
            let cancel_data = {
              action: 'cancel_reject',
              booking_id: item.id,
            }
            axios.post(`${window.location.origin}/api/car`, cancel_data)
              .then(res => {
                this.$alert('Rejection Has Been Canceled', '', 'success')
                this.loadPendingBooking()
              })
              .catch(err => {
                this.$alert(err, '', 'error')
              })
          })
      },

      createBooking(){
        this.selected_booking = {
          action: 'create_booking',
          id: 0,
          tanggal: '',
          jam_awal: -1,
          jam_akhir: 0,
          destination: '',
          purpose: '',
          user: {
            id: '',
            name: '',
          },
        }
        $('#CreateCarBooking').modal('show');
      },
      editBooking(item){
        this.selected_booking = item
        this.selected_booking.action = 'edit_booking'
        $('#CreateCarBooking').modal('show');
      },
      deleteItem(collection, item){
        let text = ''
        let url = ''

        if(collection === 'booking_list'){
          text = `Booking ${item.purpose}`
          url = 'booking'
        }else if(collection === 'car_list'){
          text = `Car ${item.type}`
          url = 'car'
        } console.log(text)
        this.$confirm(`Delete ${text}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/car/${url}-${item.id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    collection === 'booking_list' ? this.loadPendingBooking() : this.loadCarData()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
              });
          })
          .catch(error => console.error(error));
      },
      
      loadBookingData(){
        axios.get(window.location.origin+'/api/car/getBookingData')
          .then(({data}) => {
            this.booking_list = data
          })
      },
      loadPendingBooking(){
        axios.get(window.location.origin+'/api/car/getPendingBooking')
          .then(({data}) => {
            this.booking_list = data
          })
      },
      loadBookingHistory(){
         axios.get(window.location.origin+'/api/car/getBookingHistory')
          .then(({data}) => {
            this.booking_list = data
          })
      },
      bookingPageContent(page = 1) {
        let content = ''
        if(this.$route.path == '/manage-cars/pending-list'){
          content = 'getPendingBooking'
        }else if(this.$route.path == '/manage-cars/history'){
          content = 'getBookingHistory'
        }else{
          content = 'getBookingData'
        }
        
        axios.get(window.location.origin+'/api/car/'+content+'?page=' + page)
          .then(response => {
            this.booking_list = response.data
          });
      },
      loadCarList(){
        axios.get(window.location.origin+'/api/car/getCarList')
          .then(({data}) => {
            this.total_car = data
          })
          // .catch(err => location.reload())
      },
      loadCarData(){
        axios.get(window.location.origin+'/api/car/getCarData')
          .then(({data}) => {
            this.car_list = data
          })
          // .catch(err => location.reload())
      },
      carPageContent(page = 1) {
        axios.get(window.location.origin+'/api/car/getCarData?page=' + page)
          .then(response => {
            this.car_list = response.data
          });
      },
      loadCompanyData(){
        axios.get(window.location.origin+'/api/company/getCompanyData')
          .then(({data}) => {
            this.company_list = data
          })
      },
      loadDriverData(){
        axios.get(window.location.origin+'/api/driver/getDriverData')
          .then(({data}) => {
            this.driver_list = data
          })
      },
      loadVendorData(){
        axios.get(window.location.origin+'/api/vendor/getVendorData')
          .then(({data}) => {
            this.vendor_list = data
          })
      },
      loadDivisionData(){
        axios.get(window.location.origin+'/api/division/getDivisionData')
          .then(({data}) => {
            this.division_list = data
          })
      },
    },
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

  .notes-btn{
    display: block;
    width: 65px;
    padding: 0.25rem 0.5rem;
    margin-bottom: 5px;
    color: white;
    /* background-color: cornflowerblue; */
  }

  .status{
    display: block;
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;

    &-rejected{
      color: crimson;
    }
    &-finished{
      color: green;
    }
  }
</style>