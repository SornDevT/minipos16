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
              <input type="text" class="form-control" id="user_name" name="email-username" v-model="user_name" placeholder="...." >
            </div>
            <div class="mb-3">
              <label for="email" class="form-label fs-6">ອີເມວລ໌:</label>
              <input type="text" class="form-control" v-model="user_email" id="email" name="email-username" placeholder="...." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ລະຫັດຜ່ານ:</label>
            
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label fs-6" for="password">ຍືນຍັນລະຫັດຜ່ານ:</label>
            
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" v-model="password2" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            

            <div class="alert alert-warning" role="alert" v-if="text_error">
              {{text_error}}
          </div>

            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit" @click="Register()">ລົງທະບຽນ</button>
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
import axios from 'axios';
export default {
    data() {
      return {
        user_name:'',
        user_email:'',
        password:'',
        password2:'',
        text_error:''
      }
    },
    methods:{
      Register(){
          if(this.user_name == "" || this.user_email == "" || this.password == ""){
            this.text_error = "ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!"
          } else {
              if(this.password == this.password2){
                this.text_error = ""
                // ກວດຂໍ້ມູນຜ່ານ
                axios.post('api/register',{
                  from_user_name: this.user_name,
                  from_user_email: this.user_email,
                  from_password: this.password,
                }).then((res)=>{

                  console.log(res)
                  if(res.data.success){
                    this.text_error = ""
                    this.user_name = ""
                    this.user_email = ""
                    this.password = ""
                    this.password2 = ""

                    /// ໄປໜ້າ login
                    this.$router.push('/login')

                  } else {
                    this.text_error = res.data.message
                  }

                }).catch((err)=>{
                  console.log(err)
                })

              } else {
                this.text_error = "ລະຫັດຜ່ານບໍ່ກົງກັນ!"
              }
            
          }
      }
    }
}
</script>
<style lang="">
    
</style>