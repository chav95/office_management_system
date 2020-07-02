<template>
  <div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User's Profile</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Main content -->
            <div class="doc-container p-3 mb-3">

            <!-- <template v-if="$route.params.id == 1"> -->
              <div class="row">
                <div class="col-12" style="font-size: 1.15em">
                  <h4><strong>{{userLogin.name}}</strong></h4>
                  <hr class="header-line-top">
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->

              <div class="row doc-header">
                <div class="col-sm-3 doc-col" style="font-size: 1.1em">
                  Email <span style="float: right">:</span><br>
                  Division <span style="float: right">:</span><br>
                </div>
                <!-- /.col -->
                <div class="col-sm-9 doc-col" style="font-size: 1.1em">
                  <strong>{{userLogin.email}}</strong> <br>
                  <strong>{{userLogin.division.name}}</strong> <br>
                </div>
              </div>

              <div class="row no-print">
                <div class="col-12">
                  <button class="btn btn-primary" @click="open_modal()">
                    <i class="fas fa-key"></i>
                    Change Password
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent="change_password">
            <div class="modal-header">
              <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <label>Current Password</label>
                <input v-model="form.current_password" type="password" name="current_password" placeholder="Type Your Current Password"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('current_password') }">
                <has-error :form="form" field="current_password"></has-error>
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input v-model="form.new_password" type="password" name="new_password" placeholder="Type Your New Password"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('new_password') }">
                <has-error :form="form" field="new_password"></has-error>
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input v-model="form.confirm_new_password" type="password" name="confirm_new_password" placeholder="Confirm Your New Password"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('confirm_new_password') }">
                <has-error :form="form" field="confirm_new_password"></has-error>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Form from 'vform';
  
  export default {
    data(){
      return {
        userLogin: {
          id: 0,
          name: '',
          division: {
            name: '',
          },
        },
        form: new Form({
          act: 'change_password',
          id: 0,
          current_password: '',
          new_password: '',
          confirm_new_password: '',
        }),
      }
    },
    mounted(){
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      })
    },
    methods: {
      open_modal(){
        this.form.id = this.userLogin.id
        $('#changePassword').modal('show')
      },
      change_password(){
        this.form.post(window.location.origin+'/api/user')
          .then(response => {
            if(response.data.success == true){
              $('#changePassword').modal('hide');
              this.$alert(`Change Password Successful`, '', 'success')
            }else{
              this.$alert(response.data.message, '', 'warning')
            }
          })
          .catch(err => this.$alert('Invalid Data', '', 'error'));
      }
    },
  }
</script>

<style lang="scss" scoped>
  .doc-container{
    background: #fff;
    border: 1px solid rgba(0,0,0,.125);
    position: relative;
  }

  h4{
    text-align: left;
    margin-bottom: 0;
  }

  h5, h6{
    margin-left: 20px;
    text-align: left;
  }
  h6{
    margin-bottom: 0px;
    padding: 0 25px;
  }

  .row{
    .doc-header{
      padding: 5px;
    }
    .doc-info{
      margin-bottom: 12px;
    }
  }

  .col-6 > .col-6, .col-6 > .col-5{
    display: inline-block;
  }

  .header-line-top{
    border-bottom: 2px solid #212529;
  }
  .header-line-bot{
    border-bottom: 2px solid #212529;
  }
  .header-line-top.thin-margin, .header-line-bot.thin-margin{
    margin: 0;
  }

  .section-container{
    width: 100%;

    .total{
      margin: 12px 0;
    }
  }
  .total div{
    margin: 0;
  }

  .total-container{
    margin-bottom: 20px;
  }

  .section{
    display: inline-block;
    vertical-align: top;
    text-align: center;
    margin-top: 10px;
    max-width: 49.5%;
    padding: 0 10px;
  }

  .section-left{
    text-align: left;
  }
  .section-left, .section-right{
    display: inline-block;
    vertical-align: top;
    margin-bottom: 15px;
    font-size: .95em;

    ul{
      margin: 0;
      padding-left: 8px;
      list-style-type: none;
    }
  }
  .section-right{
    text-align: right;
  }

  .section-line{
    border-top: 1px solid #212529;
    margin: 5px 0;
  }

  .rincian{
    width: 800px;
    max-width: 49%;
    padding: 0 10px;
  }
  .v-line{
    width: 5px;
    height: 150px;
    border-right: 1px solid #212529;
    display: inline-block
  }
</style>