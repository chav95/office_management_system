<template>
  <div class="container">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div>
            <img :src="'./storage/app_image/logo.png'" alt="Office Management Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Office Management System</span>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fab fa-ello color-indigo mr-2"></i> Welcome, <strong>{{userLogin.name}}</strong></h5>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    data(){
      return{
        userLogin: {
          name: ''
        }
      }
    },
    mounted() {
      axios.get(window.location.origin+'/api/user/getUserLogin').then(({data}) => {
        this.userLogin = data;
      });
    }
  }
</script>

<style scoped>
  .brand-image{
    height: 100px;
    margin-right: 20px;
  }
  .brand-text{
    font-size: 35px;
  }
</style>