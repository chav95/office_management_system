<template>
  <div class="container">
    <div class="modal fade" id="CreateRoom" ref="modal" tabindex="-1" role="dialog" aria-labelledby="CreateRoomLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="CreateRoomLabel">Add New Room</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label for="name">Room Name</label>
                  <input type="text" v-model="postToRoom.name" class="form-control" id="name"  placeholder="Room Name">

                  <label for="capacity">Room Capacity</label>
                  <input type="number" v-model="postToRoom.capacity" class="form-control" id="capacity"  placeholder="Room Capacity">
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" @click="submitNewRoom()" class="btn btn-primary">Create</button>
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
    data(){
      return{
        id,
        en,

        postToRoom: {
          action: 'create_room',
          name: '',
          capacity: 0,
        }
      }
    },
    computed: {
      completed(){
        if(this.postToRoom.name !== '' && this.postToRoom.capacity > 0){
          return true
        }
        return false
      }
    },
    methods: {
      submitNewRoom(){
        if(this.completed === true){          
          axios.post(window.location.origin+'/api/room', this.postToRoom)
            .then(res => {
              if(res.data.success === true){
                this.$emit('success')
                this.$alert('Add New Room Success', '', 'success')
                $('#CreateRoom').modal('hide');

                this.postToRoom.name = ''
                this.postToRoom.capacity = ''
              }else{ //console.log(res)
                const data = res.data
                this.$alert(data.msg, '', 'warning')
              }
            })
            .catch((error) => {
              this.$alert(error, '', 'error')
            });
        }else{
          this.$alert('All Data Must Be Filled', '', 'error');
        }
      }
    }
  }
</script>

<style lang="scss" scoped>

</style>