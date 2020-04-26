<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card" v-if="$route.path === '/manage-cars' || $route.path === '/manage-cars/booking-list'">
          <book-car model_title="Book Car" :carData="car_list" @success="loadBookingData()" v-show="can_create"/>
          <div class="card-header">
            <h3 class="card-title"><strong>Booking Car List</strong></h3>
            <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateCarBooking" v-show="can_create">Book Car</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Car Model / Police Number</th>
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
                    <td>{{booking.car.type}} / {{booking.car.police_number}}</td>
                    <td>{{booking.destination}}</td>
                    <td>{{booking.purpose}}</td>
                    <td>{{formatDatetime(booking.tanggal)}} - {{booking.jam_awal}}.00 s/d {{booking.jam_akhir}}.00</td>
                    <td>{{booking.user.name}}</td>
                    <td>
                      <div>
                        <!-- <a class="modify-btn" title="Edit Room">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a> -->
                        <a class="modify-btn" @click="deleteItem('booking_list', index, booking.id)" title="Delete Car Booking">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
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
          <!-- <create-modal model_title="Add New Car"></create-modal> -->
          <div class="card-header">
            <h3 class="card-title"><strong>Car List</strong></h3>
            <!-- <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">Add New Car</button> -->
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Company</th>
                  <th>Car Model</th>
                  <th>Engine</th>
                  <th>Police Number</th>
                  <th>Driver</th>
                  <th>Lease Duration</th>
                  <th>Vendor</th>
                  <th>User</th>
                  <!-- <th>Status</th> -->
                  <!-- <th></th> -->
                </tr>
              </thead>
              <tbody>
                <template v-if="car_list.length > 0">
                  <tr v-for="car in car_list" :key="car.id">
                    <template v-if="car.police_number !== '-'">
                      <td>{{car.company_name}}</td>
                      <td>{{car.type}}</td>
                      <td>{{car.engine_cc}}</td>
                      <td>{{car.police_number}}</td>
                      <td>{{car.driver_name}}</td>
                      <td>{{formatDatetime(car.lease_start)}} s/d {{car.lease_due === null ? '-' : formatDatetime(car.lease_due)}}</td>
                      <td>{{car.vendor_name}}</td>
                      <td>{{car.division_name}}</td>
                      <!-- <td class="text-green"><b>Available</b></td> -->
                      <!-- <td> -->
                        <!-- <div>
                          <a class="modify-btn" title="Edit Room">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('Meeting Room C')" title="Delete Room">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div> -->
                      <!-- </td> -->
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
  import CreateModal from './reusables/CreateNewModal.vue';
  import moment from 'moment'
  import BookCar from './modals/BookCar.vue'


  export default {
    components: {
      CreateModal, BookCar
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },
        booking_list: [],
        car_list: [],        
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      });
      this.loadBookingData();
      this.loadCarData();
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
      }
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },
      loadBookingData(){
        axios.get(window.location.origin+'/api/car/getBookingData')
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
      deleteItem(collection, index, id){
        let text = ''
        if(collection === 'booking_list'){
          text = `Booking ${this.booking_list[index].purpose}`
        }else{
          // text = `Car ${this.room_list.name}`
        } console.log(text)
        this.$confirm(`Delete ${text}?`, '', 'question')
          .then( ()=> {
            // this.$confirm('This delete action cannot be undone!', '', 'warning')
            //   .then( ()=> {
                axios.delete(`${window.location.origin}/api/car/booking-${id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    this.loadBookingData()
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
                
              // });
            })
          .catch(error => console.error(error));
      }
    },
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>