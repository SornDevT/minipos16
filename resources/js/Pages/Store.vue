<template lang="">
    <div class="card">
  <h5 class="card-header">ລາຍການສິນຄ້າ</h5>
  <div class="card-body">

    <div v-if="ShowForm">
        {{FormStore}}
        <div class=" d-flex justify-content-end">
            <button type="button" class="btn btn-success me-2" :disabled="CheckForm" @click="SaveStore()">ບັນທຶກ</button>
            <button type="button" class="btn btn-danger" @click="CancelStore()">ຍົກເລີກ</button>
        </div>
        <div class="row">
            <div class="col-md-4">img</div>
            <div class="col-md-8">
                <div>

          <label  class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
          <input type="text" class="form-control mb-2" v-model="FormStore.name" placeholder="..." >

          <label  class="form-label fs-6">ຈຳນວນ:</label>
          <cleave :options="options" class="form-control mb-2" v-model="FormStore.qty"  placeholder="..." />

          <div class="row">
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຊື້:</label>
                    <cleave :options="options" class="form-control mb-2" v-model="FormStore.price_buy" placeholder="..." />
            </div>
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຂາຍ:</label>
                    <cleave :options="options" class="form-control mb-2" v-model="FormStore.price_sell"  placeholder="..." />
            </div>
          </div>
          
        </div>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2 cursor-pointer" @click="ChangeSort()">
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                </div>
                <select class="form-select" v-model="perpage" @change="GetStore()" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class="form-control me-2" v-model="Search" @keyup.enter="GetStore()" placeholder="ຄົ້ນຫາ...">
                <button type="button" class="btn btn-primary" @click="AddStore()" >ເພີ່ມຂໍ້ມູນ</button>
            </div>
        </div> 
        <!-- {{ StoreData}} -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th class="text-center">ລາຄາຊື້</th>
            <th class="text-center">ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id }} </td>
            <td> {{ list.image }} </td>
            <td>
             {{ list.name }}
            </td>
            <td class="text-end">{{ formatPrice(list.price_buy) }} ກີບ</td>
            <td class="text-center">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)" ><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DelStore(list.id)" ><i class="bx bx-trash me-1"></i> ລຶບ</a>
                </div>
              </div>
            </td>
          </tr>
          
          
        </tbody>
      </table>
      <button @click="showAlert">Hello world</button>

      <Pagination :pagination="StoreData" :offset="4" @paginate="GetStore($event)" />

    </div>
  </div>
</div>
</template>
<script>
import { useStore } from '../Store/auth';
import axios from 'axios';
export default {
    setup(){
        const store = useStore();
        return { store }
    },
    data() {
        return {
            StoreData:[],
            FormStore:{
                name:'',
                image:'',
                qty:'',
                price_buy:'',
                price_sell:''
            },
            ShowForm:false,
            FormType:true,
            EditID:'',
            Sort:'asc',
            perpage:5,
            Search:'',
            options: {
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: ',',
                  delimiter: '.'
                }
        }
    },
    computed:{
        CheckForm(){
            if(this.FormStore.name == "" || this.FormStore.qty == "" || this.FormStore.price_buy == "" || this.FormStore.price_sell == ""){
                return true
            } else {
                return false
            }
        }
    },
    methods:{
        showAlert() {
        // Use sweetalert2
        this.$swal({
            title: "res.data.message",
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
            });
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        ChangeSort(){
            if(this.Sort == 'asc'){
                this.Sort = 'desc'
            } else {
                this.Sort = 'asc'
            }
            this.GetStore()
        },
        AddStore(){
            this.ShowForm = true
            this.FormType = true
            this.FormStore.name = ""
            this.FormStore.image = ""
            this.FormStore.qty = ""
            this.FormStore.price_buy = ""
            this.FormStore.price_sell = ""
        },
        EditStore(id){
            this.FormType = false
            this.EditID = id
            console.log(id)
            
            // axios.get("api/store/edit/"+id)
            axios.get(`api/store/edit/${id}`,{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{

                // console.log(res.data)
                this.FormStore = res.data
                this.ShowForm = true

            }).catch((error)=>{
                console.log(error)
                if(error.response.status == 401){
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem('web_user')
                            localStorage.removeItem('web_token')
                            this.$router.push('/login')
                            console.log('clear')
                            }
            })
        },
        DelStore(id){


            this.$swal({
                    title: "ທ່ານແນ່ໃຈບໍ່?",
                    text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ຕົກລົງ!",
                    cancelButtonText:"ຍົກເລີກ"
                    }).then((result) => {
                    if (result.isConfirmed) {


                        axios.delete(`api/store/delete/${id}`,{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                                if(res.data.success){
                                    this.GetStore()
                                    this.$swal({
                                        title: "ການລຶບຂໍ້ມູນ!",
                                        text: res.data.message,
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer:3500
                                        });
                                } else {
                                    this.$swal({
                                        title: res.data.message,
                                        showConfirmButton: false,
                                        icon:"error",
                                        timer:3500
                                    });
                                }
                            }).catch((error)=>{
                                console.log(error)
                                if(error.response.status == 401){
                                            this.store.remove_token()
                                            this.store.remove_user()
                                            localStorage.removeItem('web_user')
                                            localStorage.removeItem('web_token')
                                            this.$router.push('/login')
                                            console.log('clear')
                                            }
                            })
                    
                        
                    }
                    });

            
            
        },
        CancelStore(){
            this.ShowForm = false
        },
        SaveStore(){
                if(this.FormType){
                    // add 
                    axios.post('api/store/add',this.FormStore, { headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                        if(res.data.success){

                            this.ShowForm = false
                            this.GetStore()

                            this.$swal({
                                position:'top-end',
                                toast:true,
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"success",
                                timer:2500
                            });

                        } else {

                            this.$swal({
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
                            });
                            
                        }
                    }).catch((error)=>{
                        console.log(error)
                        if(error.response.status == 401){
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem('web_user')
                            localStorage.removeItem('web_token')
                            this.$router.push('/login')
                            console.log('clear')
                            }
                    })


                } else {
                    // update
                    axios.post(`api/store/update/${this.EditID}`,this.FormStore, { headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                        if(res.data.success){

                                this.ShowForm = false
                                this.GetStore()

                                this.$swal({
                                position:'top-end',
                                toast:true,
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"success",
                                timer:2500
                            });

                                } else {
                                    this.$swal({
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"error",
                                timer:3500
                            });
                                }
                        }).catch((error)=>{
                        console.log(error)
                        if(error.response.status == 401){
                            this.store.remove_token()
                            this.store.remove_user()
                            localStorage.removeItem('web_user')
                            localStorage.removeItem('web_token')
                            this.$router.push('/login')
                            console.log('clear')
                            }
                    })

                }
        },
        GetStore(page){
            axios.get(`api/store?page=${page}&sort=${this.Sort}&perpage=${this.perpage}&search=${this.Search}`,{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                this.StoreData = res.data
            }).catch((error)=>{
                console.log(error.response.status)
                // ກວດເບີ່ງ statis code ຖ້າເປັນ 401 ໃຫ້ໄປໜ້າ Login
                if(error.response.status == 401){

                    this.store.remove_token()
                    this.store.remove_user()
                    localStorage.removeItem('web_user')
                    localStorage.removeItem('web_token')
                    this.$router.push('/login')
                    console.log('clear')
                }

            })
        }
    },
    created(){
        this.GetStore()
    },
    watch:{
        Search(){
            if(this.Search == ''){
                this.GetStore()
            }
        }
    }
}
</script>
<style lang="">
    
</style>