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
          <input type="text" class="form-control mb-2" v-model="FormStore.qty"  placeholder="..." >

          <div class="row">
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຊື້:</label>
                    <input type="text" class="form-control mb-2" v-model="FormStore.price_buy" placeholder="..." >
            </div>
            <div class="col-md-6">
                <label  class="form-label fs-6">ລາຄາຂາຍ:</label>
                    <input type="text" class="form-control mb-2" v-model="FormStore.price_sell"  placeholder="..." >
            </div>
          </div>
          
        </div>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap" v-if="!ShowForm">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2">
                    <i class='bx bx-sort-up fs-4'></i>
                </div>
                <select class="form-select" >
                    <option>1</option>
                    <option>2</option>
                </select>
            </div>
            <div class=" d-flex">
                <input type="text" class="form-control me-2" placeholder="ຄົ້ນຫາ...">
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
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData" :key="list.id">
            <td> {{ list.id }} </td>
            <td> {{ list.image }} </td>
            <td>
             {{ list.name }}
            </td>
            <td>{{ list.price_buy }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
          </tr>
          
          
        </tbody>
      </table>
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

                        } else {
                            
                        }
                    }).catch((error)=>{
                        console.log(error)
                    })


                } else {
                    // update
                }
        },
        GetStore(){
            axios.get(`api/store`,{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                this.StoreData = res.data
            }).catch((error)=>{
                console.log(error)
            })
        }
    },
    created(){
        this.GetStore()
    }
}
</script>
<style lang="">
    
</style>