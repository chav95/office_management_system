<template>
  <div class="container">
    <div class="container-fluid">
      <div class="row justify-content-center mt-4 mb-4 h-100">
        <div class="col-12">
          <div class="card" v-if="$route.path === '/manage-rooms' || $route.path === '/manage-rooms/booking-list'">
            <create-modal model_title="Book Room"></create-modal>
            <div class="card-header">
              <h3 class="card-title"><strong>Booking Room List</strong></h3>
              <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">Book Room</button>
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
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Meeting Room A</td>
                    <td>Weekly Marketing Meeting</td>
                    <td>7 people</td>
                    <td>28 Feb 2020 <br> <i>(10.00 - 13.00)</i></td>
                    <td>
                      <ul>
                        <li>Projector</li>
                        <li>Snacks</li>
                      </ul>
                    </td>
                    <td>Budi Suharjo</td>
                  </tr>
                  <tr>
                    <td>Meeting Room B</td>
                    <td>Vendor Meeting</td>
                    <td>3 people</td>
                    <td>28 Feb 2020 <br> <i>(15.00 - 16.00)</i></td>
                    <td>
                      <ul>
                        <li>Projector</li>
                      </ul>
                    </td>
                    <td>Nadia Hutagalung</td>
                  </tr>
                  <tr>
                    <td>Meeting Room A</td>
                    <td>Finance Gathering</td>
                    <td>9 people</td>
                    <td>28 Feb 2020 <br> <i>(15.00 - 18.00)</i></td>
                    <td>-</td>
                    <td>Raka</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="card" v-else-if="$route.path === '/manage-rooms/settings'">
            <create-modal model_title="Add New Room"></create-modal>
            <div class="card-header">
              <h3 class="card-title"><strong>Booking Room List</strong></h3>
              <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#CreateModel">Add New Room</button>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Room</th>
                    <th>Capacity</th>
                    <th>Last Booked</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Meeting Room A</td>
                    <td>10 people</td>
                    <td>27 Feb 2020 (16.00 - 18.00)</td>
                    <td class="text-green"><b>Available</b></td>
                    <td>
                      <div>
                        <a class="modify-btn" title="Edit Room">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem('Meeting Room A')" title="Delete Room">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Meeting Room B</td>
                    <td>5 people</td>
                    <td>25 Feb 2020 (17.30 - 18.00)</td>
                    <td class="text-indigo"><b>In Use</b></td>
                    <td>
                      <div>
                        <a class="modify-btn" title="Edit Room">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem('Meeting Room B')" title="Delete Room">
                          <i class="fa fa-trash color-red fa-fw fa-lg"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Meeting Room C</td>
                    <td>15 people</td>
                    <td>-</td>
                    <td class="text-red"><b>Not Available</b></td>
                    <td>
                      <div>
                        <a class="modify-btn" title="Edit Room">
                          <i class="fa fa-edit color-blue fa-fw fa-lg"></i>
                        </a>
                        <a class="modify-btn" @click="deleteItem('Meeting Room C')" title="Delete Room">
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