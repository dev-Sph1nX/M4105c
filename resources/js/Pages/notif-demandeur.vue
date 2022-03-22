<template>
    <div>
        <div class="text-center">
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold">Vos notifications</h1>
        </div>

        <div class="mt-7" v-if="notifs">
            <div class="flex items-center animate-fade-in-down" v-for="(notif, key) in notifs" :key="notif.id_notification">
                <Notification :notif="notif" @read="isRead(key)"/>
            </div>
        </div>
        <div class="flex items-center text-indigo-50 font-semibold w-4/5 max-w-screen-md m-auto mb-7 relative animate-fade-in-down" v-if="!notifs.length">
            <div class="animate-pulse flex flex-col m-auto">
                <h1 :class="stateColor" style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold">Aucune notification</h1>
            </div>
        </div>

    </div>
</template>

<script>
import BaseLayout from "../Layout/Baselayout.vue";
import Notification from "../Component/Notification.vue";

export default {
    name: "notif-demandeur",
    layout: BaseLayout,
    props: {
        user: Object,
        notifs: Array
    },
    components: {
        Notification
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        }
    },
    methods: {
        isRead(key){
            this.$inertia.reload({ 
                data: { 
                    id_notif: this.notifs[key].id_notification
                } 
            })
            
        }
    }
}
</script>