<template lang="">

<dashgrap />

    <div class="card">
  <h5 class="card-header">ການເຄື່ອນໄຫວ ທຸລະກຳ</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2 cursor-pointer" @click="ChangeSort()">
                    <i class='bx bx-sort-up fs-4' v-if="Sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-if="Sort=='desc'"></i>
                </div>

                <select class="form-select" v-model="perpage" @change="GetTran()" >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>

            </div>
            <div class=" d-flex">
                <div class="btn-group me-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary" @click="month_type='m'"> <i class='bx bxs-chevron-right' v-if="month_type=='m'" ></i> ເດືອນ</button>
                <button type="button" class="btn btn-secondary" @click="month_type='y'" > <i class='bx bxs-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
              </div>

                <input type="date" class="form-control" v-model="dmy" >
           
            </div>
        </div> 
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ວັນທີ່</th>
            <th>ເລກທີ່ທຸລ່ະກຳ</th>
            <th>ປະເພດທຸລ່ະກຳ</th>
            <th>ລາຍລະອຽດ</th>
            <th class="text-center">ມູນຄ່າ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in TranData.data" :key="item.id">
            <td>{{ date(item.created_at) }}</td>
            <td>{{ item.tran_id }}</td>
            <td>{{ item.tran_type }}</td>
            <td>{{ item.tran_detail }}</td>
            <td class="text-end">{{ formatPrice(item.price) }} ກີບ</td>
          </tr>
        </tbody>
      </table>
      <Pagination :pagination="TranData" :offset="4" @paginate="GetTran($event)" />
    </div>
  </div>
</div>
</template>
<script>

import moment from 'moment';
import { useStore } from '../Store/auth';
import axios from 'axios';

export default {
    setup(){
        const store = useStore();
        return { store }
    },
    data() {
        return {
            Sort:'desc',
            perpage:10,
            month_type:'m',
            dmy: new Date().toISOString().slice(0,10),
            TranData:[]
        }
    },
    components:{
        moment
    },
    methods: {
        date(value){
            return moment(value).format("DD/MM/YYY");
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
            this.GetTran()
        },
        GetTran(page){
            
            axios.post(`api/transection?page=${page}&perpage=${this.perpage}&sort=${this.Sort}`,{
                month_type: this.month_type,
                dmy: this.dmy
            },{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                this.TranData = res.data
            }).catch((error)=>{
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
    created() {
        this.GetTran()
    },
    watch:{
        dmy(){
            this.GetTran()
        },
        month_type(){
            this.GetTran()
        }
    }
}
</script>
<style lang="">
    
</style>