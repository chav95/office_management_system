<template>
<div class="container">
  <div class="container-fluid">
    <div class="row justify-content-center mt-4 mb-4 h-100">
      <div class="col-12">
        <div class="card" v-if="$route.path === '/manage-cars' || $route.path === '/manage-cars/booking-list'">
          <create-modal model_title="Book Car"></create-modal>
          <div class="card-header">
            <h3 class="card-title"><strong>Booking Car List</strong></h3>
            <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">Book Room</button>
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
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Toyota Avanza / B 5213 BMD</td>
                  <td>Pondok Indah Mall</td>
                  <td>Meeting event partnership</td>
                  <td>28 Feb 2020 <br> <i>(10.00 - 13.00)</i></td>
                  <td>Andi Mawardi</td>
                </tr>
                <tr>
                  <td>Daihatsu Xenia / B 1977 TYZ</td>
                  <td>Rosalyn Citta Jewellery</td>
                  <td>Sales meeting</td>
                  <td>28 Feb 2020 <br> <i>(15.00 - 16.00)</i></td>
                  <td>Stefani</td>
                </tr>
                <tr>
                  <td>Toyota Avanza / B 5213 BMD</td>
                  <td>Kantor HOOQ</td>
                  <td>Media partner meeting</td>
                  <td>28 Feb 2020 <br> <i>(15.00 - 18.00)</i></td>
                  <td>David Agustinus</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="card" v-else-if="$route.path === '/manage-cars/settings'">
          <create-modal model_title="Add New Car"></create-modal>
          <div class="card-header">
            <h3 class="card-title"><strong>Car List</strong></h3>
            <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">Add New Car</button>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Car Model</th>
                  <th>Police Number / Year</th>
                  <th>Capacity</th>
                  <th>Next Vehicle Registration</th>
                  <th>Status</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Toyota Avanza</td>
                  <td>B 5213 BMD / 2015</td>
                  <td>5 people</td>
                  <td>May 2020 </td>
                  <td class="text-indigo"><b>Available</b></td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Car">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('Toyota Avanza (B 5213 BMD)')" title="Delete Car">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Daihatsu Xenia</td>
                  <td>B 1977 TYZ / 2018</td>
                  <td>5 people</td>
                  <td>Sep 2023</td>
                  <td class="text-indigo"><b>Available</b></td>
                  <td>
                    <div>
                      <a class="modify-btn" title="Edit Car">
                        <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                      </a>
                      <a class="modify-btn" @click="deleteItem('Daihatsu Xenia (B 1977 TYZ)')" title="Delete Car">
                        <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                      </a>
                    </div>
                  </td>
                </tr>
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

  export default {
    components: {
      CreateModal,
    },
    data(){
      return{
        
      }
    },
    methods:{
      deleteItem(name){
        this.$confirm(`Delete ${name}?`, '', 'question')
          .then( ()=> {
            this.$confirm('This delete action cannot be undone!', '', 'warning')
              .then( ()=> {
                this.$alert('Delete Successful', '', 'success');
                this.loadMusics();
              });
            })
          .catch(error => console.error(error));
      }
    },
    watch: {
      // '$route.params.playlist_id': function(playlist_id){
      //   this.loadWishlist();
      // }
    },
    mounted() {
      
    }
  }
</script>

<style scoped>
  .card-tools{
    text-align: right;
  }
</style>