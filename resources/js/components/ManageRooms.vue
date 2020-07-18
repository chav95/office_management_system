<template>
  <div class="container">
    <div class="container-fluid">
      <div class="row justify-content-center mt-4 mb-4 h-100">
        <div class="col-12">
          <div class="card" v-if="$route.path == '/manage-rooms' || $route.path == '/manage-rooms/booking-list' || $route.path == '/manage-rooms/pending-list'">
            <book-room 
              :bookingItem="selected_booking" 
              :roomData="total_room" 
              :divisionList="division_list" 
              @success="$route.path == '/manage-rooms/pending-list' ? loadPendingBooking() : loadBookingData()"
            />
            <assign-room 
              :bookingItem="selected_booking" 
              :roomData="total_room" 
              @success="assignSuccess()"
            />
            <div class="card-header">
              <h3 class="card-title"><strong>{{$route.path == '/manage-rooms/pending-list' ? 'Pending' : ''}} Booking Room List</strong></h3>
              <button class="btn btn-primary" style="float: right" @click="createBooking()">Book Room</button>
            </div>

            <div class="card-body">
              <table id="booking_list" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Book Time</th>
                    <th>Purpose</th>
                    <th>Participants</th>
                    <th>User</th>
                    <th>Extra(s)</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="booking_list.data.length > 0">
                    <tr v-for="(booking) in booking_list.data" :key="booking.id">
                      <td>{{booking.room.name}}</td>
                      <td>{{formatDatetime(booking.tanggal)}} - {{booking.jam_awal}}.00 s/d {{booking.jam_akhir}}.00</td>
                      <td>{{booking.purpose}}</td>
                      <td>{{booking.participant}} People <i>({{booking.division.name}} Division)</i></td>
                      <td>
                        {{booking.user.name}}
                        <span class="d-block"><i>({{fullDatetime(booking.created_at)}})</i></span>
                      </td>
                      <td>
                        <ul v-if="booking.options.length > 0">
                          <li v-for="(option, index) in booking.options" :key="index">{{option}}</li>
                        </ul>
                        <span v-else>-</span>
                      </td>
                      <td>
                        <template v-if="$route.path == '/manage-rooms/pending-list' && booking.status == 0">
                          <div class="modify_box" v-if="booking.user.id == userLogin.id">
                            <a class="modify-btn" @click="editBooking(booking)" title="Edit Booking">
                              <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                            </a>
                            <a class="modify-btn" @click="deleteItem('booking_list', booking)" title="Delete Room">
                              <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                            </a>
                          </div>
                          <div class="modify_box" v-if="userLogin.id == 6">
                            <a class="modify-btn" title="Assign Room" @click="assign(booking)">
                              <i class="fa fa-thumbtack color-blue fa-fw fa-lg"></i>
                            </a>
                            <a class="modify-btn" title="Reject Booking" @click="reject(booking)">
                              <i class="fa fa-window-close color-red fa-fw fa-lg"></i>
                            </a>
                          </div>
                        </template>
                        <template v-if="$route.path == '/manage-rooms/pending-list' && booking.status == -1">
                          <div>
                            <span class="status status-rejected">Rejected</span>
                            <button class="btn btn-primary notes-btn" title="Reason For Rejection" @click="$alert(booking.notes)">
                              Notes
                            </button>
                            <button v-if="userLogin.id == 6"
                              class="btn btn-danger notes-btn" title="Cancel Booking" 
                              @click="cancelReject(booking)"
                            >Cancel Reject</button>
                          </div>
                        </template>
                        <template v-if="$route.path != '/manage-rooms/pending-list'">
                          <div class="text-center">
                            <span v-if="booking.status == -2" class="status status-rejected">Canceled</span>
                            <!-- <span v-else-if="booking.status == 2" class="status status-finished">Finished</span> -->

                            <button v-if="booking.notes !== null" class="btn btn-primary notes-btn" title="See Notes" @click="$alert(booking.notes)">
                              Notes
                            </button>

                            <template v-if="userLogin.id == booking.booked_by && booking.status == 1">
                              <!-- <button class="btn btn-success notes-btn" title="Finish Booking" @click="finish(booking)">
                                Finish
                              </button> -->
                              <button class="btn btn-danger notes-btn" title="Cancel Booking" @click="cancel(booking)">
                                Cancel
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

          <div class="card" v-else-if="$route.path === '/manage-rooms/settings'">
            <create-room :action="action" :selected_room="selected_room" @success="loadRoomData()"/>
            <div class="card-header">
              <h3 class="card-title"><strong>Booking Room List</strong></h3>
              <button class="btn btn-primary" style="float: right" @click="createRoom()">Add New Room</button>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-if="room_list.data.length > 0">
                    <tr v-for="(room) in room_list.data" :key="room.id">
                      <td>{{room.name}}</td>
                      <td>{{room.capacity}}</td>
                      <td class="text-green"><b>Available</b></td>
                      <td>
                        <div>
                          <a class="modify-btn" @click="editRoom(room)" title="Edit Room">
                            <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                          </a>
                          <a class="modify-btn" @click="deleteItem('room_list', room)" title="Delete Room">
                            <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr><td colspan="100%"><h5 class="text-center">No Available Room</h5></td></tr>
                  </template>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <pagination :data="room_list" @pagination-change-page="roomPageContent"></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import moment from 'moment'
  import BookRoom from './modals/BookRoom'
  import AssignRoom from './modals/AssignRoom'
  import CreateRoom from './modals/CreateRoom'

  export default {
    components: {
      BookRoom, AssignRoom, CreateRoom
    },
    data(){
      return{
        userLogin: {
          id: 0,
          privilege: ''
        },

        booking_list: {data: []},
        room_list: {data: []},
        total_room: [],
        division_list: [],
        
        selected_booking: {
          action: '',
          tanggal: '',
          jam_awal: -1,
          jam_akhir: -1,
          participant: 0,
          id: 0,
          purpose: '',
          options: [],
          room: {
            id: 0,
          },
          division: {
            id: 0,
            name: '',
          },
          user: {
            name: '',
          },
        },

        action: '',
        selected_room: {
          id: 0,
          name: '',
          capacity: 0,
        }
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      })
      this.$route.path == '/manage-rooms/pending-list' ? this.loadPendingBooking() : this.loadBookingData()
      this.loadRoomData()
      this.loadRoomList()
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
      }
    },
    watch:{
      '$route.path'(newVal, oldVal){
        this.$route.path == '/manage-rooms/pending-list' ? this.loadPendingBooking() : this.loadBookingData()
      },
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },
      fullDatetime(datetime){
        moment.locale('id');
        return moment(String(datetime)).format('lll');
      },

      loadPendingBooking(){
        axios.get(window.location.origin+'/api/room/getPendingBooking')
          .then(response => {
            response.data.data.forEach(item => {
              item.options = item.options != '' && item.options !== null ? item.options.split(',') : []
            });
            this.booking_list = response.data
          })
      },
      loadBookingData(){
        axios.get(window.location.origin+'/api/room/getBookingData')
          .then(response => {
            response.data.data.forEach(item => {
              item.options = item.options != '' && item.options !== null ? item.options.split(',') : []
            });
            this.booking_list = response.data
          })
      },
      bookingPageContent(page = 1) {
        let content = this.$route.path == '/manage-rooms/pending-list' ? 'getPendingBooking' : 'getBookingData'
        axios.get(window.location.origin+'/api/room/'+content+'?page=' + page)
          .then(response => {
            response.data.data.forEach(item => {
              item.options = item.options != '' && item.options !== null ? item.options.split(',') : []
            });
            this.booking_list = response.data
          });
      },
      loadRoomList(){
        axios.get(window.location.origin+'/api/room/getRoomList')
          .then(({data}) => {
            this.total_room = data
          })
      },
      loadRoomData(){
        axios.get(window.location.origin+'/api/room/getRoomData')
          .then(({data}) => {
            this.room_list = data
          })
          // .catch(err => location.reload())
      },
      roomPageContent(page = 1) {
        axios.get(window.location.origin+'/api/room/getRoomData?page=' + page)
          .then(response => {
            this.room_list = response.data
          });
      },
      loadDivisionData(){
        axios.get(window.location.origin+'/api/division/getDivisionData')
          .then(({data}) => {
            this.division_list = data
          })
      },

      createRoom(){
        this.action = 'create'
        this.selected_room = {
          id: 0,
          name: '',
          capacity: 0,
        }
        $('#CreateRoom').modal('show');
      },
      editRoom(item){
        this.action = 'edit'
        this.selected_room = item
        $('#CreateRoom').modal('show');
      },

      createBooking(){
        this.selected_booking = {
          action: 'create_booking',
          tanggal: '',
          jam_awal: -1,
          jam_akhir: -1,
          participant: '',
          id: 0,
          purpose: '',
          options: [],
          room: {
            id: 0,
          },
          division: {
            id: 0,
            name: '',
          },
          user: {
            name: '',
          },
        }
        $('#CreateRoomBooking').modal('show')
      },
      editBooking(item){
        this.selected_booking = item
        this.selected_booking.action = 'edit_booking'
        $('#CreateRoomBooking').modal('show')
      },

      assign(item){
        this.selected_booking = item
        // this.selected_booking.options = this.selected_booking.options != '' && this.selected_booking.options !== null ? this.selected_booking.options.split(',') : []
        $('#AssignRoom').modal('show');
      },
      assignSuccess(){
        this.loadPendingBooking()
        this.loadRoomData()
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
                axios.post(`${window.location.origin}/api/room`, reject_data)
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
            axios.post(`${window.location.origin}/api/room`, finish_data)
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
                axios.post(`${window.location.origin}/api/room`, cancel_data)
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
            axios.post(`${window.location.origin}/api/room`, cancel_data)
              .then(res => {
                this.$alert('Rejection Has Been Canceled', '', 'success')
                this.loadPendingBooking()
              })
              .catch(err => {
                this.$alert(err, '', 'error')
              })
          })
      },
      deleteItem(collection, item){
        let text = ''
        let url = ''

        if(collection === 'booking_list'){
          text = `Booking ${item.purpose}`
          url = 'booking'
        }else if(collection === 'room_list'){
          text = `Room ${item.name}`
          url = 'room'
        }
        this.$confirm(`Delete ${text}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                axios.delete(`${window.location.origin}/api/room/${url}-${item.id}`)
                  .then(res => {
                    this.$alert('Delete Successful', '', 'success');
                    if(collection == 'booking_list'){
                      this.loadPendingBooking()
                    }else{
                      this.loadRoomData()
                    }
                  })
                  .catch(err => {
                    this.$alert(err, '', 'error')
                  })
                
              });
            })
          .catch(error => console.error(error));
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