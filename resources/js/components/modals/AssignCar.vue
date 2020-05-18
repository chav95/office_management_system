<template>
  <div class="container">
    <div class="modal fade" id="AssignCar" ref="modal" tabindex="-1" role="dialog" aria-labelledby="AssignCarLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="AssignCarLabel">Assign Car</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-sm-3">
                  <strong>Book Time</strong> <br>
                  <strong>Destination</strong> <br>
                  <strong>Purpose</strong> <br>
                  <strong>Booked By</strong> <br>
                </div>

                <div class="col-sm-9">
                  {{formatDatetime(bookingItem.tanggal)}} - {{bookingItem.jam_awal}}.00 s/d {{bookingItem.jam_akhir}}.00 <br>
                  {{bookingItem.destination}} <br>
                  {{bookingItem.purpose}} <br>
                  {{bookingItem.user.name}} <br>
                </div>
              </div>
                  
              <div class="row">
                <div class="col-sm-12">
                  <label for="car_select">Select Car To Assign</label>
                  <select v-model="car_id" class="form-control" id="car_select">
                    <option value="0" disabled>{{available_car.length > 0 ? 'Choose Car' : 'No Car Available'}}</option>
                    <option v-for="car in available_car" :key="car.id" :value="car.id">{{car.type}} / {{car.police_number}}</option>
                  </select>
                  <label for="driver_select">Select Driver To Assign</label>
                  <select v-model="driver_id" class="form-control" id="driver_select">
                    <option value="0" disabled>{{available_driver.length > 0 ? 'Choose Driver' : 'No Driver Available'}}</option>
                    <option v-for="driver in available_driver" :key="driver.id" :value="driver.id">{{driver.name}}</option>
                  </select>
                  <label for="notes">Notes (Optional)</label>
                  <textarea v-model="notes" id="notes" class="form-control" rows="4" placeholder="Notes (Optional)"></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" @click="assignCar()" class="btn btn-primary">Create</button>
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
      carData: {
        type: Array,
        default: [],
      },
      driverData: {
        type: Array,
        default: [],
      },
    },
    data(){
      return{
        id,
        en,

        bookingList: [],
        available_car: [],
        available_driver: [],

        car_id: 0,
        driver_id: 0,
        notes: '',
      }
    },
    watch: {
      bookingItem: {
        handler: function(newVal, oldVal) { //console.log('triggered')
          this.fill_available_car()
          this.fill_available_driver()
        },
        immediate: true,
        deep: true,
      },
      car_id: function(){
        this.available_car.forEach(car => {
          if(this.car_id == car.id){
            this.available_driver.forEach(driver => {
              if(car.driver.id == driver.id){
                this.driver_id = car.driver.id
              }              
            });
          }
        })
      },
      // available_car(){
      //   let valid = false
      //   this.available_car.forEach(item => {
      //     if(item.id == this.bookingItem.car){
      //       valid = truea
      //     }
      //   });

      //   if(valid === false){
      //     this.bookingItem.car = 0
      //   }
      // }
    },
    computed: {
      completed(){
        if(this.car_id > 0 && this.driver_id > 0){
          return true
        }
        return false
      },
    },
    methods: {
      formatDatetime(datetime){
        return moment(String(datetime)).format('ll');
      },

      fill_available_car(){
        let arr = []
        this.carData.forEach(item => {
          if(item.police_number === '-'){
            arr.push(item)
          }else if(item.today_booking.length > 0){
            item.today_booking.forEach(booking => {
              if(booking.tanggal != this.bookingItem.tanggal){
                arr.push(item)
              }else if(this.bookingItem.jam_awal > booking.jam_akhir){
                arr.push(item)
              }else if(this.bookingItem.jam_akhir < booking.jam_awal){
                arr.push(item)
              }
            });
          }else{
            arr.push(item)
          }
          });
        this.available_car = arr;
      },
      fill_available_driver(){
        let arr = []
        this.driverData.forEach(item => {
          if(item.today_booking.length > 0){
            item.today_booking.forEach(booking => {
              if(booking.tanggal != this.bookingItem.tanggal){
                arr.push(item)
              }else if(this.bookingItem.jam_awal > booking.jam_akhir){
                arr.push(item)
              }else if(this.bookingItem.jam_akhir < booking.jam_awal){
                arr.push(item)
              }
            });
          }else{
            arr.push(item)
          }
          });
        this.available_driver = arr;
      },
      
      assignCar(){
        if(this.completed === true){
          let postToCar = {
            action: 'assign',
            booking_id: this.bookingItem.id,
            car_id: this.car_id,
            driver_id: this.driver_id,
            notes: this.notes,
          }
          
          axios.post(window.location.origin+'/api/car', postToCar)
            .then(res => {
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Assign Car Success', '', 'success')
                $('#AssignCar').modal('hide');

                this.car_id = 0
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
          this.$alert('Car & Driver Cannot Be Empty', '', 'error');
        }
      },
      
      loadBookingData(){
        axios.get(window.location.origin+'/api/car/getBookingData')
          .then(({data}) => {
            this.booking_data = data
          })
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>