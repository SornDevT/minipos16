<template lang="">
    <div>
        <h1>Store Page</h1>
        <hr>
        Token: {{store.get_token}}
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
            
        }
    },
}
</script>
<style lang="">
    
</style>