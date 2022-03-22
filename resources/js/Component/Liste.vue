<template>
    <div class="list">
        <h1>{{ titleUppercase }}</h1>
        <ul>
            <li v-for="element in items" :key="element">
                {{ element }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name:"List",
    props:{
        title: {
            type: String,
            required: true
        }, 
        items: {
            type: Array,
            required: true
        }
    },
    mounted(){
        console.log(this.items);
    },
    data(){
        return{
        }
    },
    computed: {
        titleUppercase(){
            return this.title.toUpperCase();
        }
    }
}
</script>

<style scoped>
    .list{
        border: 2px solid black;
        border-radius: 1rem;
        padding: 1rem;
        margin-top: 1rem;
    }
</style>