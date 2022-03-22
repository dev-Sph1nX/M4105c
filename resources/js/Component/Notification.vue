<template>
    <div class="flex items-center shadow-md w-4/5 max-w-screen-md rounded-2xl m-auto mb-4 p-4 relative">
        <p class="flex-none text-gray-400 w-32">{{notif.date_notification}}</p>
        <p class="flex-1 w-80 ">{{notif.libelle_notification}}</p>
        <svg @click="$emit('read')" class="h-8 w-8 text-red-500 hover:cursor-pointer"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
    </div>
    
</template>

<script>
export default {
    name:"Notification",
    props:{
        notif:{
            type: Object,
        }
    },
}
</script>