<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3" >
                <div class="card-body">
                    <input class=" form-control" placeholder="ຄົ້ນຫາ...." v-model="Search" @keyup.enter="GetStore()">
                </div>
            </div>
            <PerfectScrollbar>
            <div class="m-2" style="height:60vh">
                <div class="row">
                    <div class="col-md-3 mb-3" v-for=" item in StoreData.data" :key="item">
                        <div class="card h-100 cursor-pointer" @click="AddProduct(item.id)" style=" position: relative">
                            <span  v-for="i in ListOrder" :key="i.id">
                                <span class="num-pos" v-if="item.id == i.id" > {{ i.order_qty }} </span>
                            </span>
                                <img class="card-img-top img-pos" v-if="item.image" :src="url + '/assets/img/'+item.image" >
                                <img class="card-img-top img-pos" v-else :src="url + '/assets/img/no_img.jpg'" >
                                <div class="card-body p-1 text-center ">
                                    <h5> {{ item.name }} </h5>
                                    <p class="card-text">
                                    {{ formatPrice(item.price_sell) }} ກີບ
                                     </p>
                                </div>
                                </div>
                    </div>
                   
                </div>
            </div>
            </PerfectScrollbar>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="p-3">
                        <label>ຊື່ສິນຄ້າ:</label>
                        <input type="text" v-model="customer_name" class=" form-control mb-1" placeholder="...">
                        <label>ເບີໂທ:</label>
                        <input type="text" v-model="customer_tel" class=" form-control" placeholder="...">
                    </div>
                    <div class=" p-2 bg-info text-white ">
                        ລາຍການສັ່ງຊື້
                    </div>
                    <PerfectScrollbar>
                        <div class="" style=" height:42vh">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-bordered">
                                    
                                    <tbody>
                                        <tr v-for="list in ListOrder" :key="list">
                                            <td class="p-1 d-flex">
                                                <img class="card-img-top img-list-order " v-if="list.image" :src="url + '/assets/img/'+list.image" >
                                                <img class="card-img-top img-list-order " v-else :src="url + '/assets/img/no_img.jpg'" >
                                            <div class="px-3 w-100">
                                                    <span> {{ list.name }} </span>
                                                    <div class=" d-flex justify-content-end" > {{list.order_qty}} x {{ formatPrice(list.price_sell) }}</div>
                                                    <div class=" d-flex justify-content-between">
                                                        <span>
                                                            <i class='bx bx-plus-circle text-success cursor-pointer' @click="AddProduct(list.id)"></i> | <i class='bx bx-minus-circle text-warning cursor-pointer' @click="RemoveProduct(list.id)"></i> | <i class='bx bx-trash-alt text-danger cursor-pointer' @click="DeleteProduct(list.id)"></i> </span>
                                                        <span>{{ formatPrice(list.order_qty*list.price_sell) }}</span>
                                                    </div>
                                            </div>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                        </div>
                    </PerfectScrollbar>
                    <div class=" d-flex justify-content-between fs-5 bg-info text-white p-2">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAll) }} ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" class=" w-100 btn rounded-pill btn-success" @click="Pay()" :disabled="!TotalAll">ຊຳລ່ະເງິນ</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="dialog_pay" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
              <form class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="backDropModalTitle">ການຊຳລະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                        <div class="col-md-6">
                            <div class=" d-flex justify-content-between">
                                <span>ລວມຍອດເງິນ:</span>
                                <span>{{ formatPrice(TotalAll) }} ກີບ</span>
                            </div>
                            <div class=" d-flex justify-content-between text-danger" v-if="(CashAmount-TotalAll)>0">
                                <span>ເງິນທອນ:</span>
                                <span>{{ formatPrice(CashAmount-TotalAll) }} ກີບ</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <label>ຮັບເງິນນຳລູກຄ້າ</label>
                            <cleave :options="options" v-model="CashAmount" class=" form-control text-end" />
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100" @click="AddNum(500)" >500</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(1000)">1.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(2000)" >2.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(5000)">5.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(10000)">10.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(20000)" >20.000</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(50000)">50.000</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class=" btn btn-primary w-100"  @click="AddNum(100000)" >100.000</button>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>
                <div class="modal-footer">
                  
                  <button type="button" class="btn btn-primary" :disabled="CheckBTPay" @click="ConfirmPay()" >ບັນທຶກ</button>
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ປິດ</button>
                </div>
              </form>
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
            customer_name:'',
            customer_tel:'',
            url: window.location.origin,
            CashAmount:'',
            StoreData:[],
            ListOrder:[],
            Sort:'asc',
            perpage:20,
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
            CheckBTPay(){
                if(this.CashAmount>=this.TotalAll){
                    return false 
                } else {
                    return true
                }
            },
            TotalAll(){
                let val = this.ListOrder.reduce((num, item)=> parseInt(num) + (parseInt(item.order_qty)*parseInt(item.price_sell)),0)
                return val;
            }
    },
    methods:{

        async openLink(link){
            const response = await fetch(`${link}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}});
            const html = await response.text();
            const blob = new Blob([html],{ type: "text/html"});
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, "_blank");
        },
        ConfirmPay(){

            axios.post('api/transection/add',{
                customer_name: this.customer_name,
                customer_tel: this.customer_tel,
                listorder: this.ListOrder
            },{ headers:{ Authorization:'Bearer '+ this.store.get_token }}).then((res)=>{
                    if(res.data.success){

                        this.customer_name = ""
                        this.customer_tel = ""
                        this.ListOrder = []
                        this.CashAmount = 0
                        this.GetStore()

                        $('#dialog_pay').modal('hide')

                        this.$swal({
                                position:'top-end',
                                toast:true,
                                title: res.data.message,
                                showConfirmButton: false,
                                icon:"success",
                                timer:2500
                            });

                        console.log(res.data.bill_id)

                        // window.open(window.location.origin+"/api/bills/print/"+res.data.bill_id, "_blank")
                        this.openLink(window.location.origin+"/api/bills/print/"+res.data.bill_id)

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

        },
        AddNum(num){
            this.CashAmount = parseInt(this.CashAmount?this.CashAmount:0) + parseInt(num) // 1 + 2 = 3
        },
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        Pay(){
            this.CashAmount = '';
            $('#dialog_pay').modal('show')
        },  
        AddProduct(id){

            let item = this.StoreData.data.find((i)=>i.id == id)
            let old_item = this.ListOrder.find((i)=>i.id == id)

            if(item.qty>0){
                if(old_item){
                        if(item.qty - old_item.order_qty>0){
                            old_item.order_qty++
                        } else {
                            this.$swal({
                                        title:"ບໍ່ສາມາດຂາຍສິນຄ້າໄດ້!",
                                        text:"ສິນຄ້າດັ່ງກ່າວບໍ່ພຽງພໍ!",
                                        showConfirmButton: false,
                                        icon:"error",
                                        timer:3500
                                    });
                        }
                        
                    } else {
                        this.ListOrder.push({
                            id: item.id,
                            image: item.image,
                            name: item.name,
                            order_qty: 1,
                            price_sell: item.price_sell
                        })
                    }
            } else {
                this.$swal({
                                        title:"ບໍ່ສາມາດຂາຍສິນຄ້າໄດ້!",
                                        text:"ສິນຄ້າດັ່ງກ່າວໄດ້ໝົດແລ້ວ!",
                                        showConfirmButton: false,
                                        icon:"error",
                                        timer:3500
                                    });
            }


           

            // console.log(item)
            
        },
        RemoveProduct(id){

            let item = this.ListOrder.find((i)=>i.id == id)

            if(item){
                item.order_qty--
                if(item.order_qty < 1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
                    // indexof = 0,1,3,4,5,6
                }
            }
        },
        DeleteProduct(id){

            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)

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
    created() {
        this.GetStore()
    },
    watch:{
        Search(){
            if(this.Search == ""){
                this.GetStore()
            }
        }
    }
}
</script>
<style >
    .img-pos{
        object-fit: cover;
        height: 110px;
        width: 100%;
        object-position: center;
    }
    .num-pos{
        position: absolute;
    background-color: #ff3e1d;
    color: white;
    padding: 5px;
    right: 0px;
    top: 0px;
    border-radius: 0px 8px;
    font-weight: bold;
    }
    .img-list-order{
        width: 90px;
        height: 100%;
        border-radius: 5px;
        object-fit: cover;
        object-position: center;
    }
</style>