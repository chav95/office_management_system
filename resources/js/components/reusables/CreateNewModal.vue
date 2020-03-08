<template>
  <div class="container">
    <div class="modal fade" id="CreateModel" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateModelLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateModelLabel">{{model_title}}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body" v-if="$route.path === '/manage-rooms' || $route.path === '/manage-rooms/booking-list'">
              <div class="form-group">
                <div class="form-group">
                  <input type="number" class="form-control" placeholder="Number of Participants"/>
                  <select class="form-control">
                    <option disabled selected>Choose Room</option>
                    <option>Meeting Room A</option>
                    <option>Meeting Room B</option>
                    <option disabled>Meeting Room C</option>
                  </select>
                  <input type="text" class="form-control" placeholder="Booking Purpose"/>
                  <datepicker :language="id" placeholder="Choose Booking Date"
                    input-class="room-datepicker" wrapper-class="room-datepicker-div"
                  ></datepicker>
                  <select class="form-control" style="display: inline-block; width: 95px">
                    <option disabled selected>Hour</option>
                    <option>9.00</option>
                    <option>10.00</option>
                    <option>11.00</option>
                    <option>12.00</option>
                    <option>13.00</option>
                    <option>14.00</option>
                    <option>15.00</option>
                    <option>16.00</option>
                    <option>17.00</option>
                  </select>
                  <select class="form-control" style="display: inline-block; width: 95px">
                    <option disabled selected>Hour</option>
                    <option>10.00</option>
                    <option>11.00</option>
                    <option>12.00</option>
                    <option>13.00</option>
                    <option>14.00</option>
                    <option>15.00</option>
                    <option>16.00</option>
                    <option>17.00</option>
                    <option>18.00</option>
                  </select>
                  <div style="padding-left: 15px; text-align: left">
                    <span style="margin-right: 20px">Options:</span>
                    <input type="checkbox" id="snack"/> <label for="snack" style="margin-right: 15px">Snacks</label>
                    <input type="checkbox" id="projector"/> <label for="projector">Projector</label>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-body" v-else-if="$route.path === '/manage-rooms/settings'">
              <div class="form-group">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Room Name"/>
                  <input type="number" class="form-control" placeholder="Room Capacity"/>
                </div>
              </div>
            </div>

            <div class="modal-body" v-else-if="$route.path === '/manage-cars' || $route.path === '/manage-cars/booking-list'">
              <div class="form-group">
                <div class="form-group">
                  <select class="form-control">
                    <option disabled selected>-Choose Car-</option>
                    <option>Toyota Avanza (B 5213 BMD)</option>
                    <option>Daihatsu Xenia (B 1977 TYZ)</option>
                  </select>
                  <input type="text" class="form-control" placeholder="Destination"/>
                  <input type="text" class="form-control" placeholder="Booking Purpose"/>
                  <datepicker :language="id" placeholder="Choose Booking Date"
                    input-class="car-datepicker" wrapper-class="car-datepicker-div"
                  ></datepicker>
                  <select class="form-control" style="display: inline-block; width: 95px">
                    <option disabled selected>Hour</option>
                    <option>9.00</option>
                    <option>10.00</option>
                    <option>11.00</option>
                    <option>12.00</option>
                    <option>13.00</option>
                    <option>14.00</option>
                    <option>15.00</option>
                    <option>16.00</option>
                    <option>17.00</option>
                  </select>
                  <select class="form-control" style="display: inline-block; width: 95px">
                    <option disabled selected>Hour</option>
                    <option>10.00</option>
                    <option>11.00</option>
                    <option>12.00</option>
                    <option>13.00</option>
                    <option>14.00</option>
                    <option>15.00</option>
                    <option>16.00</option>
                    <option>17.00</option>
                    <option>18.00</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="modal-body" v-else-if="$route.path === '/manage-cars/settings'">
              <div class="form-group">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Car Model"/>
                  <input type="text" class="form-control" placeholder="Police Number"/>
                  <input type="number" class="form-control" placeholder="Car Capacity"/>
                  <datepicker :language="id" placeholder="Vehicle Registration Schedule"
                    input-class="input-datepicker" wrapper-class="input-datepicker-div"
                  ></datepicker>
                </div>
              </div>
            </div>

            <div class="modal-body" v-if="$route.path === '/manage-docs'">
              <div class="form-group">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Document Name"/>
                  <input type="text" class="form-control" placeholder="Document Number"/>
                  <datepicker :language="id" placeholder="Date of Issue"
                    input-class="input-datepicker" wrapper-class="input-datepicker-div"
                  ></datepicker>
                  <input type="text" class="form-control half" placeholder="Extra Detail Label"/>
                  <input type="text" class="form-control half" placeholder="Extra Detail Value"/>
                  <button class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add More Details
                  </button>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Create</button>
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

  export default{
    components: {
      Datepicker
    },
    props: {
      model_title: {
        type: String,
        default: 'Create New',
      }
    },
    data(){
      return{
        id: id,
        en: en
      }
    },
    methods:{
      resetModal(){
        this.form = new Form;
      },
    },
    computed: {
        
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
</style>