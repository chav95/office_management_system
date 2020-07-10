<template>
  <div class="container">
    <div class="modal fade" id="AssignRoom" ref="modal" tabindex="-1" role="dialog" aria-labelledby="AssignRoomLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="AssignRoomLabel">Assign Room</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-sm-4">
                  <strong>Book Time</strong> <br>
                  <strong>Purpose</strong> <br>
                  <strong>Participants</strong> <br>
                  <strong>Division</strong> <br>
                  <strong>Booked By</strong> <br>
                  <strong>Exta(s)</strong>
                </div>

                <div class="col-sm-8">
                  {{formatDatetime(bookingItem.tanggal)}} - {{bookingItem.jam_awal}}.00 s/d {{bookingItem.jam_akhir}}.00 <br>
                  {{bookingItem.purpose}} <br>
                  {{bookingItem.participant}} People <br>
                  {{bookingItem.division.name}} Division <br>
                  {{bookingItem.user.name}} <br>
                  <ul v-if="bookingItem.options.length > 0">
                    <li v-for="(option, index) in bookingItem.options" :key="index">{{option}}</li>
                  </ul>
                  <span v-else>-</span>
                </div>
              </div>
                  
              <div class="row">
                <div class="col-sm-12">
                  <label for="room_select">Select Room To Assign</label>
                  <select v-model="room_id" class="form-control" id="room_select">
                    <option value="0" disabled>{{available_room.length > 0 ? 'Choose Room' : 'No Room Available'}}</option>
                    <option v-for="room in available_room" :key="room.id" :value="room.id">{{room.name}} (Capacity: {{room.capacity}})</option>
                  </select>
                  <label for="notes">Notes (Optional)</label>
                  <textarea v-model="notes" id="notes" class="form-control" rows="4" placeholder="Notes (Optional)"></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="assignRoom()" class="btn btn-primary">
                {{loading 
                  ? 'Please Wait...' 
                  : 'Assign'
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
  import Datepicker from 'vuejs-datepicker';
  import {id, en} from 'vuejs-datepicker/dist/locale'
  import moment from 'moment'
  
  export default {
    components: {
      Datepicker
    },
    props: {
      bookingItem: {
        type: Object,
      },
      roomData: {
        type: Array,
        default: [],
      },
    },
    data(){
      return{
        id,
        en,

        bookingList: [],
        available_room: [],

        room_id: 0,
        notes: '',

        loading: false,
      }
    },
    watch: {
      bookingItem: {
        handler: function(newVal, oldVal) { console.log('triggered')
          this.fill_available_room()
          this.room_id = this.bookingItem.room.id
        },
        immediate: true,
        deep: true,
      },
      // available_room(){
      //   let valid = false
      //   this.available_room.forEach(item => {
      //     if(item.id == this.bookingItem.room){
      //       valid = truea
      //     }
      //   });

      //   if(valid === false){
      //     this.bookingItem.room = 0
      //   }
      // }
    },
    computed: {
      completed(){
        if(this.room_id > 0){
          return true
        }
        return false
      },
    },
    methods: {
      formatDatetime(datetime){
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
      
      assignRoom(){
        if(this.completed === true){
          this.loading = true

          let postToRoom = {
            action: 'assign',
            booking_id: this.bookingItem.id,
            room_id: this.room_id,
            notes: this.notes,
          }
          
          axios.post(window.location.origin+'/api/room', postToRoom)
            .then(res => {
              this.loading = false

              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Assign Room Success', '', 'success')
                $('#AssignRoom').modal('hide');
                
                this.room_id = 0
                this.driver_id = 0
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
              this.$alert(error, '', 'error')
            });
        }else{
          this.$alert('Room Cannot Be Empty', '', 'error');
        }
      },
      
      loadBookingData(){
        axios.get(window.location.origin+'/api/room/getBookingData')
          .then(({data}) => {
            this.booking_data = data
          })
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>