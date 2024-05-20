<template lang="">
   <div class="row d-flex justify-content-center">
    <div class="authentication-wrapper authentication-basic container-p-y col-md-4">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">


</span>
     
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2 text-center">ລົງທະບຽນ</h4>

         
            <div class="mb-3">
              <label for="user_name" class="form-label fs-6">ຊື່ຜູ້ໃຊ້:</label>
              <input type="text" class="form-control" id="user_name" name="email-username" placeholder="...." >
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" name="email-username" placeholder="...." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
            
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ຍືນຍັນລະຫັດຜ່ານ:</label>
            
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
          
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">ລົງທະບຽນ</button>
            </div>
         
          <p class="text-center">
            <span>ມີບັນຊີຜູ້ໃຊ້ແລ້ວ!</span>
            <router-link to="/login">
              <span>ເຂົ້າສູ່ລະບົບ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>