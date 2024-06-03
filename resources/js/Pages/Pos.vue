<template lang="">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3" >
                <div class="card-body">
                    <input class=" form-control" placeholder="ຄົ້ນຫາ....">
                </div>
            </div>
            <PerfectScrollbar>
            <div class="m-2" style="height:60vh">
                <div class="row">
                    <div class="col-md-3 mb-3" v-for=" item in StoreData.data" :key="item">
                        <div class="card h-100 cursor-pointer" @click="AddProduct(item.id)" style=" position: relative">
                            <span class="num-pos">
                                10
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
                        <input type="text" class=" form-control mb-1" placeholder="...">
                        <label>ເບີໂທ:</label>
                        <input type="text" class=" form-control" placeholder="...">
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
                                                        <span><i class='bx bx-plus-circle text-success cursor-pointer'></i> | <i class='bx bx-minus-circle text-warning cursor-pointer'></i> | <i class='bx bx-trash-alt text-danger cursor-pointer'></i> </span>
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
                        <span>30.000 ກີບ</span>
                    </div>
                    <div class="p-2">
                        <button type="button" class=" w-100 btn rounded-pill btn-success">ຊຳລ່ະເງິນ</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import { useStore } from '../Store/auth';
export default {
    setup(){
        const store = useStore();
        return { store }
    },
    data() {
        return {
            url: window.location.origin,
            StoreData:[],
            ListOrder:[],
            Sort:'asc',
            perpage:20,
            Search:'',
        }
    },
    methods:{
        formatPrice(value) {
            let val = (value / 1).toFixed(0).replace(",", ".");
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        },
        AddProduct(id){

            let item = this.StoreData.data.find((i)=>i.id == id)
            let old_item = this.ListOrder.find((i)=>i.id == id)

            if(old_item){
                old_item.order_qty++
            } else {
                this.ListOrder.push({
                    id: item.id,
                    image: item.image,
                    name: item.name,
                    order_qty: 1,
                    price_sell: item.price_sell
                })
            }

            // console.log(item)
            
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