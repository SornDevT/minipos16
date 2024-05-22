<template lang="">
    <div>
        <h1>Report Page</h1>
        <hr>
        <input type="text" v-model="token_from">
        <button @click="AddTK()">Set Token</button>
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
            token_from:null
        }
    },
    methods:{
        AddTK(){
            this.store.set_token(this.token_from)
        }
    }
}
</script>
<style lang="">
    
</style>