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
          <h4 class="mb-2 text-center">ສະບາຍດີ! 👋</h4>
          <p class="mb-4 text-center">ກະລຸນາເຂົ້າສູ່ລະບົບ</p>

         
            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" v-model="email" id="email" name="email-username" placeholder="...." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
            
              </div>
              <div class="input-group input-group-merge">
                <input :type="sh_pw" id="password" v-model="password" @keyup.enter="Login()" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer" @click="sh_pw=='password'?sh_pw='text':sh_pw='password'" >
                  <i class="bx bx-hide" v-if="sh_pw=='password'"></i>
                  <i class="bx bx-show"  v-if="sh_pw=='text'"></i>
                </span>
              </div>
            </div>

            <div class="alert alert-warning" role="alert" v-if="text_error || text_error_email || text_error_pass">
              {{text_error}} {{text_error_email}} {{text_error_pass}}
          </div>
          
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" :disabled="check_from_login" @click="Login()" type="submit">ເຂົ້າສູ່ລະບົບ</button>
            </div>
         

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີຜູ້ໃຊ້?</span>
            <router-link to="/register">
              <span>ລົງທະບຽນ</span>
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
// if else ແບບຫຍໍ້
// sh_pw=='password'?sh_pw='text':sh_pw='password'

// ອະທິບາຍ ເງື່ອນໄຂ if else ແບບເຕົມ
// if(sh_pw=='password'){
//   sh_pw='text'
// } else {
//   sh_pw='password'
// }

import axios from 'axios';
export default {
    data() {
      return {
        email:'',
        password:'',
        text_error:'',
        text_error_email:'',
        text_error_pass:'',
        sh_pw:'password',
      }
    },
    computed:{
      check_from_login(){
          // ກວດ ອີເມວລ໌
          const EmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

          if(this.email){
            if(EmailRegex.test(this.email)){
              this.text_error_email = ""
            } else {
              this.text_error_email = "ອີເມວລ໌ບໍ່ຖຶກຕ້ອງ"
            }
          } else {
            this.text_error_email = ""
          }

          /// ກວດລະຫັດຜ່ານ
          if(this.password){
            if(this.password.length<=3){
              this.text_error_pass = " ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 4 ຕົວອັກສອນ"
            } else {
              this.text_error_pass = ""
            }
          } else {
            this.text_error_pass = ""
          }

          // ກວດຄວາມຖຶກຕ້ອງ, ປິດປຸ່ມ
          if(!EmailRegex.test(this.email) || this.password.length<=3){
            return true
          } else {
            return false
          }
      }
    },
    methods:{
      Login(){
          if(this.email !="" && this.password != ""){
              axios.post('api/login',{
                login_email: this.email,
                login_password: this.password
              }).then((res)=>{

                if(res.data.success){
                  this.text_error = ''

                  this.email = ''
                  this.password = ''

                  // ບັນທຶກ Token ແລະ ຂໍ້ມູນ User
                  localStorage.setItem('web_token',res.data.token)
                  localStorage.setItem('web_user',JSON.stringify(res.data.user_data))

                  this.$router.push('/')

                  console.log(res)

                } else {
                  this.text_error = res.data.message
                }

              }).catch((error)=>{
                console.log(error)
              })
          }
      }
    }
}
</script>
<style lang="">
    
</style>