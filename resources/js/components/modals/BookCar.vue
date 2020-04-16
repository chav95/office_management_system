<template>
  <div class="container">
    <div class="modal fade" id="CreateCarBooking" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateCarBookingLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateCarBookingLabel">{{model_title}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <datepicker v-model="postToCar.tanggal" placeholder="Choose Booking Date" 
                    :language="id" :disabledDates="{to: new Date(new Date().setDate(new Date().getDate() - 1))}"
                    input-class="car-datepicker" wrapper-class="car-datepicker-div"
                  ></datepicker>
                  <select v-model="postToCar.jam_awal" class="form-control" style="display: inline-block; width: 95px">
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
                  <select v-model="postToCar.jam_akhir" class="form-control" style="display: inline-block; width: 95px">
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
                  <input v-model="postToCar.destination" type="text" class="form-control" placeholder="Destination"/>
                  <input v-model="postToCar.purpose" type="text" class="form-control" placeholder="Booking Purpose"/>
                  <select v-model="postToCar.car" v-show="show_car_select" class="form-control car-select">
                    <option value="0" disabled>{{available_car.length > 0 ? 'Choose Car' : 'No Car Available'}}</option>
                    <option v-for="car in available_car" :key="car.id" :value="car.id">{{car.model}} / {{car.police_number}}</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" @click="submitBooking" class="btn btn-primary">Create</button>
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
      carData: {
        type: Array
      },
      model_title: {
        type: String,
        default: 'Create New',
      },
      module: {
        type: String,
        default: ''
      }
    },
    data(){
      return{
        id,
        en,

        available_car: [],
        
        postToCar: {
          action: 'create_booking',
          tanggal: '',
          jam_awal: 0,
          jam_akhir: 0,
          destination: '',
          purpose: '',
          car: 0
        }
      }
    },
    mounted(){
      
    },
    watch: {
      postToCar: {
        handler: function(newVal, oldVal) { //console.log('triggered')
          this.fill_available_car()
        },
        deep: true
      },
      'postToCar.tanggal'(newVal, oldVal) { //console.log(newVal)
        this.postToCar.tanggal = moment(String(newVal)).format('YYYY-MM-DD');
      },
      available_car(){
        let valid = false
        this.available_car.forEach(item => {
          if(item.id == this.postToCar.car){
            valid = true
          }
        });

        if(valid === false){
          this.postToCar.car = 0
        }
      }
    },
    computed: {
      show_car_select(){
        if(
          this.postToCar.tanggal != '' 
          && this.postToCar.jam_awal > 0 
          && this.postToCar.jam_akhir > 0 
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
      fill_available_car(){
        let arr = []
        if(
          (this.postToCar.jam_akhir != 0 && this.postToCar.jam_akhir != 0) 
          && parseInt(this.postToCar.jam_akhir) <= parseInt(this.postToCar.jam_awal)
        ){
          this.$alert('Jam Akhir Tidak Boleh Lebih Kecil / Sama Dengan Jam Awal Booking', '', 'error')
          this.postToCar.jam_akhir = 0
        }else{
          this.carData.forEach(item => {
            if(item.police_number === '-'){
              arr.push(item)
            }else if(item.today_booking.length > 0){
              item.today_booking.forEach(booking => {
                if(booking.tanggal != this.postToCar.tanggal){
                  arr.push(item)
                }else if(this.postToCar.jam_awal >= booking.jam_akhir + 1){
                  arr.push(item)
                }
              });
            }else{ /* if(item.capacity >= parseInt(this.postToCar.participant)){ */
              arr.push(item)
            }
          });
        }
        this.available_car = arr;
      },
      submitBooking(){
        if(this.postToCar.tanggal === ''){
          this.$alert('Booking Date Cannot Be Empty', '', 'warning');
        }else if(this.postToCar.jam_awal == 0 || this.postToCar.jam_akhir == 0){
          this.$alert('Booking Time Cannot Be Empty', '', 'warning');
        }else if(this.postToCar.destination == ''){
          this.$alert('Booking Destination Cannot Be Empty', '', 'warning');
        }else if(this.postToCar.purpose === ''){
          this.$alert('Booking Purpose Cannot Be Empty', '', 'warning');
        }else if(this.postToCar.car == 0 && this.available_car.length > 0){
          this.$alert('Please Choose A car To Book', '', 'warning');
        }else if(this.available_car.length == 0){
          this.$alert('No car Available For Choosen Date & Time', '', 'error');
        }else{
          axios.post(window.location.origin+'/api/car', this.postToCar)
            .then(res => {
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Book Car Success', '', 'success')
                $('#CreateCarBooking').modal('hide');

                this.postToCar.tanggal = ''
                this.postToCar.jam_awal = 0
                this.postToCar.jam_akhir = 0
                this.postToCar.destination = ''
                this.postToCar.purpose = ''
                this.postToCar.car = 0
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
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

  .car-select{
    border: 2px solid cornflowerblue;
  }

  .car-select{
    border: 2px solid cornflowerblue;
  }
</style>