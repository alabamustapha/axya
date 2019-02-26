<template>
  <div class="text-center" v-show="loading">
    <span class="d-inline-block fa-1x h6">
      <i class="fas fa-sync fa-spin"></i>
    </span>
  </div>
</template>

<script>
  export default { 
    // props: ['spinnerLoading'],

    // data() {
    //   return {
    //     loading : this.spinnerLoading,
    //   }
    // },
  }
</script>