<template>
    <div>
        <!-- TOP -->
        <div class="text-center">
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-if="!src">Tickets déposés</h1>
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-if="src == 'finish'">Tickets résolus</h1>
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-if="src  == 'all'">Tous vos tickets</h1>
            
            <p v-if="!src">Voici la liste de vos tickets déposés</p>
            <p v-if="src == 'finish'">Voici la liste de vos tickets résolus</p>
            <p v-if="src  == 'all'">Voici la liste de tous vos tickets</p>

            <button :class="stateTheme" class="hover:opacity-80 text-white font-bold mt-3 py-2 px-4 rounded" @click="addTicket" v-if="!src">Ajouter un ticket</button>
        </div>
        <br>
        
        <!-- TICKETS -->
        <div class="flex items-center shadow-md w-4/5 max-w-screen-md rounded-2xl m-auto mb-7 relative animate-fade-in-down" style="padding: 5.7rem" v-for="(ticket, key) in tickets" :key="ticket.id">
            <Ticket :ticket="ticket" @edit="openEdit(key)" @viewSuivi="viewSuivi(key)" @photo="photo(key)"/>
        </div>

        <div class="flex items-center text-indigo-50 font-semibold w-4/5 max-w-screen-md m-auto mb-7 relative animate-fade-in-down" v-if="!tickets.length">
            <div class="animate-pulse flex flex-col m-auto">
                <h1 :class="stateColor" style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold">Aucun ticket</h1>
            </div>
        </div>
        <br>

        <!-- MODAL -->
        <ModalTicket v-model="modalTicketOpen" :ticket="tickets[editTicket]"></ModalTicket>
        <ModalSuivi v-model="modalSuiviOpen" :ticket="tickets[editTicket]"></ModalSuivi>
        <ModalImage v-model="modalImageOpen" :ticket="tickets[editTicket]"></ModalImage>
    </div>
</template>

<script>
import BaseLayout from "../Layout/Baselayout.vue";
import Ticket from "../Component/Ticket.vue";
import ModalTicket from "../Component/ModalTicket.vue";
import ModalSuivi from "../Component/ModalSuivi.vue";
import ModalImage from "../Component/ModalImage.vue";


export default {
    name:"Dashboard-demandeur",
    layout: BaseLayout,
    data(){
        return {
            modalTicketOpen : false,
            modalSuiviOpen: false,
            modalImageOpen: false,
            editTicket: null,
        }
    },
    props: {
        tickets: Array,
        type_probleme: Array,
        famille_probleme: Array,
        probleme: Array,
        urgence: Array,
        src: String,
        attr: String,
    },
    components:{
        Ticket,
        ModalTicket,
        ModalSuivi,
        ModalImage,
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        }
    },
    methods:{
        openEdit(key){
            this.editTicket = key;
            this.modalTicketOpen = true;
        },
        addTicket(){
            this.editTicket = null;
            this.modalTicketOpen = true;
        },
        viewSuivi(key){
            this.editTicket = key;
            this.modalSuiviOpen = true;
        },
        photo(key){
            this.editTicket = key;
            this.modalImageOpen = true;
        }
    }
}
</script>