<template>
    <div>
        <Header></Header>
        <slot>
            
        </slot>
  </div>
</template>

<script>
import Header from "../Component/Layout/header.vue"
export default {
    components: {
        Header
    }
}
</script>