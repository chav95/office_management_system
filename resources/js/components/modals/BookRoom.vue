<template>
  <div class="container">
    <div class="modal fade" id="CreateRoomBooking" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateRoomBookingLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateRoomBookingLabel">{{postToRoom.action == 'create_booking' ? 'Book A Room' : 'Edit Booking'}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <datepicker v-model="postToRoom.tanggal" placeholder="Choose Booking Date"
                    :language="id" :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1))}"
                    input-class="room-datepicker" wrapper-class="room-datepicker-div"
                  ></datepicker>
                  <select v-model="postToRoom.jam_awal" class="form-control" style="display: inline-block; width: 95px">
                    <option disabled value="0">Hour</option>
                    <option value="9">9.00</option>
                    <option value="10">10.00</option>
                    <option value="11">11.00</option>
                    <option value="12">12.00</option>
                    <option value="13">13.00</option>
                    <option value="14">14.00</option>
                    <option value="15">15.00</option>
                    <option value="16">16.00</option>
                    <option value="17">17.00</option>
                  </select>
                  <select v-model="postToRoom.jam_akhir" class="form-control" style="display: inline-block; width: 95px">
                    <option disabled value="0">Hour</option>
                    <option value="10">10.00</option>
                    <option value="11">11.00</option>
                    <option value="12">12.00</option>
                    <option value="13">13.00</option>
                    <option value="14">14.00</option>
                    <option value="15">15.00</option>
                    <option value="16">16.00</option>
                    <option value="17">17.00</option>
                    <option value="18">18.00</option>
                  </select>
                  <input v-model="postToRoom.participant" type="number" class="form-control" placeholder="Number of Participants"/>
                  <input v-model="postToRoom.purpose" type="text" class="form-control" placeholder="Booking Purpose"/>
                  <select v-model="postToRoom.division" class="form-control">
                    <option value="0" disabled>{{"Choose Room User's Division"}}</option>
                    <option v-for="div in divisionList" :key="div.id" :value="div.id">{{div.name}}</option>
                  </select>
                  <select v-show="show_room_select" v-model="postToRoom.room" class="form-control room-select">
                    <option value="0" disabled>{{available_room.length > 0 ? 'Choose Room' : 'No Room Available'}}</option>
                    <option v-for="room in available_room" :key="room.id" :value="room.id">{{room.name}} (Capacity: {{room.capacity}})</option>
                  </select>
                  <div style="padding-left: 15px; text-align: left">
                    <span style="margin-right: 20px">Options:</span>
                    <input v-model="options.snack" type="checkbox" id="snack"/> <label for="snack" style="margin-right: 15px">Snacks</label>
                    <input v-model="options.projector" type="checkbox" id="projector"/> <label for="projector">Projector</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="submitBooking()" class="btn btn-primary">
                {{loading 
                  ? 'Please Wait...' 
                  : postToRoom.action == 'create_booking'
                    ? 'Create'
                    : 'Submit Edit'
                }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import 'es6-promise/auto'
  import Form from 'vform'
  import Datepicker from 'vuejs-datepicker';
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'

  export default{
    components: {
      Datepicker
    },
    props: {
      roomData: {
        type: Array,
        default: []
      },
      divisionList: {
        type: Array,
        default: []
      },
      module: {
        type: String,
        default: ''
      },
      bookingItem: {
        type: Object,
      },
    },
    data(){
      return{
        id,
        en,

        available_room: [],

        options: {
          snack: false,
          projector: false,
        },
        
        postToRoom: {
          action: '',
          id: 0,
          tanggal: '',
          jam_awal: 0,
          jam_akhir: 0,
          participant: '',
          purpose: '',
          division: 0,
          room: 0,
          options: []
        },

        loading: false,
      }
    },
    watch: {
      bookingItem: {
        handler: function(newVal, oldVal) {
          this.postToRoom.action = this.bookingItem.action
          this.postToRoom.id = this.bookingItem.id
          this.postToRoom.tanggal = this.bookingItem.tanggal
          this.postToRoom.jam_awal = this.bookingItem.jam_awal
          this.postToRoom.jam_akhir = this.bookingItem.jam_akhir
          this.postToRoom.participant = this.bookingItem.participant
          this.postToRoom.purpose = this.bookingItem.purpose
          this.postToRoom.division = this.bookingItem.division.id
          this.postToRoom.room = this.bookingItem.room.id
          this.bookingItem.options.forEach(item => {
            if(item == 'projector'){
              this.options.projector = true
            }else if(item == 'snack'){
              this.options.snack = true
            }
          })
        },
        immediate: true,
        deep: true,
      },
      postToRoom: {
        handler: function(newVal, oldVal) { //console.log('triggered')
          this.fill_available_room()
        },
        deep: true
      },
      'postToRoom.tanggal'(newVal, oldVal) { //console.log(newVal)
        this.postToRoom.tanggal = moment(String(newVal)).format('YYYY-MM-DD');
      },
      available_room(){
        let valid = false
        this.available_room.forEach(item => {
          if(item.id == this.postToRoom.room){
            valid = true
          }
        });

        if(valid === false){
          this.postToRoom.room = 0
        }
      }
    },
    computed: {
      show_room_select(){
        if(
          this.postToRoom.tanggal != '' 
          && this.postToRoom.jam_awal > 0 
          && this.postToRoom.jam_akhir > 0 
          && (parseInt(this.postToRoom.participant) > 0 && this.postToRoom.participant != '')
        ){
          return true
        }
        return false
      }
    },
    methods:{
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },
      DatetimeIntegerFormat(datetime){
        return moment(String(datetime)).format('yyyy-MM-dd');
      },
      DatetimeStringFormat(datetime){
        return moment(String(datetime)).format('ll');
      },
      fill_available_room(){
        let arr = []
        this.roomData.forEach(room => {
          if(room.today_booking.length > 0){
            let valid = true
            room.today_booking.forEach(booking => {
              if(this.bookingItem.tanggal == booking.tanggal && booking.status == 1){
                if(this.bookingItem.jam_awal <= booking.jam_akhir && this.bookingItem.jam_awal >= booking.jam_awal){
                  valid = false
                }else if(this.bookingItem.jam_akhir <= booking.jam_akhir && this.bookingItem.jam_akhir >= booking.jam_awal - 1){
                  valid = false
                }else if(this.bookingItem.jam_awal < booking.jam_awal && this.bookingItem.jam_akhir > booking.jam_akhir){
                  valid = false
                }
              }else if(room.capacity < this.bookingItem.participant){
                valid = false
              }
            });

            if(valid == true){
              arr.push(room)
            }
          }else if(room.capacity >= parseInt(this.bookingItem.participant)){
            arr.push(room)
          }
        });
        this.available_room = arr;
      },
      submitBooking(){
        if(this.postToRoom.tanggal === ''){
          this.$alert('Booking Date Cannot Be Empty', '', 'warning');
        }else if(this.postToRoom.jam_awal == 0 || this.postToRoom.jam_akhir == 0){
          this.$alert('Booking Time Cannot Be Empty', '', 'warning');
        }else if(this.postToRoom.participant == 0){
          this.$alert('Number of Participants Cannot Be Empty', '', 'warning');
        }else if(this.postToRoom.purpose === ''){
          this.$alert('Booking Purpose Cannot Be Empty', '', 'warning');
        }else if(this.postToRoom.room == 0 && this.available_room.length > 0){
          this.$alert('Please Choose A Room To Book', '', 'warning');
        }else if(this.postToRoom.division == 0){
          this.$alert("Please Select Room User's Division", '', 'warning')
        }else if(this.available_room.length == 0){
          this.$alert('No Room Available For Choosen Date & Time', '', 'error');
        }else{
          this.loading = true

          for(let [key, value] of Object.entries(this.options)){
            value === true ? this.postToRoom.options.push(key) : null
          }
          this.postToRoom.options = this.postToRoom.options.join(',')
  
          axios.post(window.location.origin+'/api/room', this.postToRoom)
            .then(res => {
              this.loading = false

              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Book Room Success', '', 'success')
                $('#CreateRoomBooking').modal('hide');

                this.postToRoom.tanggal = ''
                this.postToRoom.jam_awal = 0
                this.postToRoom.jam_akhir = 0
                this.postToRoom.participant = ''
                this.postToRoom.purpose = ''
                this.postToRoom.division = 0
                this.postToRoom.room = 0
                this.postToRoom.options = []
                this.options = {
                  snack: false,
                  projector: false,
                }
              }else{ //console.log(res)
                this.postToRoom.options = this.postToRoom.options.split(',')
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
              this.loading = false
              
              this.postToRoom.options = this.postToRoom.options.split(',')
              this.$alert(error, '', 'error')
            });          
        }
      },
      resetModal(){
        this.form = new Form;
      },
    },
  }
</script>

<style scoped>
  .form-group{
    text-align: center;
  }
  .form-control.half{
    display: inline-block;
    width: 231.15px;
  }

  .room-select{
    border: 2px solid cornflowerblue;
  }
</style>