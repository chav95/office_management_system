<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card" v-if="$route.path == '/manage-cars' || $route.path == '/manage-cars/booking-list' || $route.path == '/manage-cars/pending-list'">
          <book-car 
            :bookingItem="selected_booking"
            :carData="car_list" 
            @success="$route.path == '/manage-cars/pending-list' ? loadPendingBooking() : loadBookingData()"
          />
          <assign-car 
            :bookingItem="selected_booking" 
            :carData="car_list" 
            :driverData="driver_list" 
            @success="assignSuccess()"
          />
          <div class="card-header">
            <h3 class="card-title"><strong>{{$route.path == '/manage-cars/pending-list' ? 'Pending' : ''}} Booking Car List</strong></h3>
            <button class="btn btn-primary" style="float: right" @click="createBooking()">Book Car</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Car Model / Police Number</th>
                  <th>Driver</th>
                  <th>Destination</th>
                  <th>Purpose</th>
                  <th>Book Time</th>
                  <th>Booked By</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <template v-if="booking_list.length > 0">
                  <tr v-for="(booking, index) in booking_list" :key="booking.id">
                    <td v-if="booking.car_id == 0"><i>Not Yet Assigned</i></td>
                    <td v-else>{{booking.car.type}} / {{booking.car.police_number}}</td>
                    
                    <td v-if="booking.driver_id == 0"><i>Not Yet Assigned</i></td>
                    <td v-else>{{booking.driver.name}}</td>

                    <td>{{booking.destination}}</td>
                    <td>{{booking.purpose}}</td>
                    <td>{{formatDatetime(booking.tanggal)}} - {{booking.jam_awal}}.00 s/d {{booking.jam_akhir}}.00</td>
                    <td>{{booking.user.name}}</td>
                    <td>
                      <template v-if="$route.path == '/manage-cars/pending-list' && booking.status == 0">
                        <div class="modify_box" v-if="booking.user.id == userLogin.id">
                          <a class="modify-btn" @click="editBooking(booking)" title="Edit Booking">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('booking_list', index, booking.id)" title="Delete Booking">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div>
                        <div class="modify_box" v-if="userLogin.id == 6">
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
                          <span class="rejected">Rejected</span>
                          <button class="btn notes-btn" title="Reason For Rejection" @click="$alert(booking.notes)">
                            Notes
                          </button>
                        </div>
                      </template>
                      <template v-else>
                        <div v-if="booking.notes !== null && booking.notes !== ''">
                          <button class="btn notes-btn" title="See Notes From Dian" @click="$alert(booking.notes)">
                            Notes
                          </button>
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
        </div>

        <div class="card" v-else-if="$route.path === '/manage-cars/settings'">
          <create-car :action="action" :selected_car="selected_car" :company_data="company_list" :driver_data="driver_list" 
          :vendor_data="vendor_list" :division_data="division_list" @success="loadCarData()"/>
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
                  <th>Lease Duration</th>
                  <th>Vendor</th>
                  <th>User</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <template v-if="car_list.length > 0">
                  <tr v-for="(car, index) in car_list" :key="car.id">
                    <template v-if="car.police_number !== '-'">
                      <td>{{car.company.name}}</td>
                      <td>{{car.type}}</td>
                      <td>{{car.engine_cc}}</td>
                      <td>{{car.police_number}}</td>
                      <!-- <td>{{car.driver.name}}</td> -->
                      <td>{{formatDatetime(car.lease_start)}} s/d {{car.lease_due === null ? '-' : formatDatetime(car.lease_due)}}</td>
                      <td>{{car.vendor.name}}</td>
                      <td>{{car.division.name}}</td>
                      <td>
                        <div>
                          <a class="modify-btn" @click="editCar(car)" title="Edit Car">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('car_list', index, car.id)" title="Delete Car">
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

  export default {
    components: {
      BookCar, AssignCar, CreateCar
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },

        booking_list: [],
        selected_booking: {
          action: '',
          id: 0,
          tanggal: '',
          jam_awal: 0,
          jam_akhir: 0,
          destination: '',
          purpose: '',
          user: {
            id: '',
            name: '',
          },
        },
        car_list: [],

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
        }
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      })
      this.$route.path == '/manage-cars/pending-list' ? this.loadPendingBooking() : this.loadBookingData()
      this.loadCarData()

      this.loadCompanyData()
      this.loadDriverData()
      this.loadVendorData()
      this.loadDivisionData()
    },
    computed:{
      can_create(){
        if(this.userLogin.privilege == 'super_admin' 
          || this.userLogin.id == 3 
          || this.userLogin.id == 4 
          || this.userLogin.id == 5 
          || this.userLogin.id == 6)
        {
          return true
        }
        return false
      },
      car_content(){
        return this.car_id == 0
          ? '-'
          : `${this.car.type} / ${this.car.police_number}`                      
      }
    },
    watch:{
      '$route.path'(newVal, oldVal){
        this.$route.path == '/manage-cars/pending-list' ? this.loadPendingBooking() : this.loadBookingData()
      },
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
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
      assignSuccess(){
        this.loadPendingBooking()
        this.loadCarData()
      },

      createBooking(){
        this.selected_booking = {
          action: 'create_booking',
          id: 0,
          tanggal: '',
          jam_awal: 0,
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
      deleteItem(collection, index, id){
        let text = ''
        let url = ''

        if(collection === 'booking_list'){
          text = `Booking ${this.booking_list[index].purpose}`
          url = 'booking'
        }else if(collection === 'car_list'){
          text = `Car ${this.car_list[index].type}`
          url = 'car'
        } console.log(text)
        this.$confirm(`Delete ${text}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/car/${url}-${id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    collection === 'booking_list' ? this.loadBookingData() : this.loadCarData()
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
      loadCarData(){
        axios.get(window.location.origin+'/api/car/getCarData')
          .then(({data}) => {
            this.car_list = data;
          })
          // .catch(err => location.reload())
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

<style scoped>
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
    color: white;
    background-color: cornflowerblue;
  }

  .rejected{
    display: block;
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
    color: crimson;
  }
</style>