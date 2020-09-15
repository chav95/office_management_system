<template>
  <div class="container">
    <div class="modal fade" id="UploadSalary" ref="modal" tabindex="-1" role="dialog" aria-labelledby="UploadSalaryLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <form @submit.prevent>
            <div class="modal-header">
              <h5 class="modal-title font-weight-bold" id="UploadSalaryLabel">Import From Excel</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="form-group">
                <div class="form-group">
                  <label class="form-control-label"  for="input-file-import">Upload Excel File</label>
                  <input type="file" class="form-control" :class="{ ' is-invalid' : error.message }" id="input-file-import" name="file_import" ref="import_file"  @change="onFileChange">
                  <div v-if="error.message" class="invalid-feedback"></div>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="reset" :disabled="loading" @click="resetFile()" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" :disabled="loading" @click="proceedAction()" class="btn btn-primary">
                {{loading
                  ? 'Please Wait...' 
                  : 'Import'
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
  export default {
    data() {
      return {
        error: {},
        import_file: '',
        
        loading: false,
      }
    },
    methods: {
      onFileChange(e) {
        this.import_file = e.target.files[0];
      },
      resetFile(){
        this.$refs.import_file.value = '';
      },

      proceedAction() {
        this.loading = true

        let formData = new FormData()
        formData.append('action', 'import')
        formData.append('import_file', this.import_file)

        axios.post(window.location.origin+'/api/employee', formData, {
          headers: { 'content-type': 'multipart/form-data' }
        })
        .then(response => {
          this.loading = false

          if(response.status === 200) {
            // this.$alert(response.message, '', 'success')
            this.$alert('Import Successful', '', 'success')
            $('#UploadSalary').modal('hide')
            this.$emit('success')
          }
        })
        .catch(error => {
          this.loading = false

          this.uploading = false
          this.error = error.response.data
          console.log('check error: ', this.error)

          this.$alert(this.error.message, '', 'error')
        });
      },
    }
  }
</script>