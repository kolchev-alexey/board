<template>
  <div class="fileinput-button">
    <font-awesome-icon :icon="icon"  class="icon" v-if="icon"/> {{ label }}
    <input :id="id" type="file" name="file" multiple>
  </div>
</template>

<script>
import $ from 'jquery'
import 'jquery-ui/ui/widget'
import 'blueimp-file-upload/js/jquery.fileupload'
import 'blueimp-file-upload/js/jquery.iframe-transport'

export default {
  name: 'Uploader',
  props: ['id', 'url', 'icon', 'label'],
  watch: {
    url () {
      if (!this.url) {
        return
      }

      $('#' + this.id).fileupload({
        url: this.url,
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        add: (e, data) => {
          this.$emit('uploading', data.files[0])
          data.submit()
        },
        fail: (e, data) => {
          this.$emit('failed', data._response.jqXHR.responseJSON.message)
        },
        done: (e, data) => {
          this.$emit('uploaded', data.result)
        },
        progress: (e, data) => {
          let progress = parseInt(data.loaded / data.total * 100, 10)
          this.$emit('progress', progress)
        }
      })
    }
  }
}
</script>

<style lang="scss" scoped>
@charset "UTF-8";
/*
 * jQuery File Upload Plugin CSS
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2013, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */

.fileinput-button {
  position: relative;
  overflow: hidden;
  display: inline-block;
}
.fileinput-button input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  -ms-filter: 'alpha(opacity=0)';
  font-size: 200px !important;
  direction: ltr;
  cursor: pointer;
}

/* Fixes for IE < 8 */
@media screen\9 {
  .fileinput-button input {
    filter: alpha(opacity=0);
    font-size: 100%;
    height: 100%;
  }
}
.icon {
  margin-right: .5rem;
}
</style>
