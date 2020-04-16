<template>
  <div class="container">
    <div class="container-fluid">
      <div class="row justify-content-center mt-4 mb-4 h-100">
        <div class="col-12">
          <div class="card" v-if="$route.path === '/manage-rooms' || $route.path === '/manage-rooms/booking-list'">
            <book-room model_title="Book Room" :roomData="room_list" @success="loadBookingData()" v-show="can_create"/>
            <div class="card-header">
              <h3 class="card-title"><strong>Booking Room List</strong></h3>
              <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateRoomBooking"
                v-if="userLogin.privilege == 'super_admin' || userLogin.id == 3 || userLogin.id == 4 || userLogin.id == 5 || userLogin.id == 6"
              >Book Room</button>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Purpose</th>
                    <th>Participant</th>
                    <th>Book Time</th>
                    <th>Extra(s)</th>
                    <th>Booked By</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="booking_list.length > 0">
                    <tr v-for="(booking, index) in booking_list" :key="booking.id">
                      <td>{{booking.room.name}}</td>
                      <td>{{booking.purpose}}</td>
                      <td>{{booking.participant}}</td>
                      <td>{{formatDatetime(booking.tanggal)}} - {{booking.jam_awal}}.00 s/d {{booking.jam_akhir}}.00</td>
                      <td>
                        <ul v-if="booking.options.length > 0">
                          <li v-for="(option, index) in booking.options" :key="index">{{option}}</li>
                        </ul>
                        <span v-else>-</span>
                      </td>
                      <td>{{booking.user.name}}</td>
                      <td>
                        <div>
                          <!-- <a class="modify-btn" title="Edit Room">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a> -->
                          <a class="modify-btn" @click="deleteItem('booking_list', index, booking.id)" title="Delete Room">
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

          <div class="card" v-else-if="$route.path === '/manage-rooms/settings'">
            <!-- <create-modal model_title="Add New Room"></create-modal> -->
            <div class="card-header">
              <h3 class="card-title"><strong>Booking Room List</strong></h3>
              <!-- <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateRoom">Add New Room</button> -->
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="room_list.length > 0">
                    <tr v-for="room in room_list" :key="room.id">
                      <td>{{room.name}}</td>
                      <td>{{room.capacity}}</td>
                      <td class="text-green"><b>Available</b></td>
                      <td>
                        <!-- <div>
                          <a class="modify-btn" title="Edit Room">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('Meeting Room C')" title="Delete Room">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div> -->
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr><td colspan="100%"><h5 class="text-center">No Available Room</h5></td></tr>
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
  import BookRoom from './modals/BookRoom.vue'

  export default {
    components: {
      BookRoom
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },
        booking_list: [],
        room_list: [],
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      });
      this.loadBookingData();
      this.loadRoomData();
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
        axios.get(window.location.origin+'/api/room/getBookingData')
          .then(({data}) => {
            data.forEach(item => {
              item.options = item.options != '' && item.options !== null ? item.options.split(',') : []
            });
            this.booking_list = data
          })
      },
      loadRoomData(){
        axios.get(window.location.origin+'/api/room/getRoomData')
          .then(({data}) => {
            this.room_list = data;
          })
          // .catch(err => location.reload())
      },
      deleteItem(collection, index, id){
        let text = ''
        if(collection === 'booking_list'){
          text = `Booking ${this.booking_list[index].purpose}`
        }else{
          text = `Room ${this.room_list.name}`
        } console.log(text)
        this.$confirm(`Delete ${text}?`, '', 'question')
          .then( ()=> {
            // this.$confirm('This delete action cannot be undone!', '', 'warning')
            //   .then( ()=> {
                axios.delete(`${window.location.origin}/api/room/booking-${id}`)
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