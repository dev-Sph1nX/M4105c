<template>
    <div>
        <div class="text-center">
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-if="!src">Tickets à résoudre</h1>
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-else>Tickets résolus</h1>
            
            <p v-if="!src">Voici la liste des tickets qui vous ont été assignés</p>
            <p v-else>Voici la liste des tickets qui sont résolus</p>

            <div class="pt-2 relative mx-auto text-gray-600">
                <input class="border-2 border-gray-300 bg-white h-10 pl-3 w-60 rounded-lg text-sm focus:outline-none" type="search" name="search" placeholder="Nom du demandeur" v-model="namedemandeur" @input="submit">
                <select class="border-2 border-gray-300 bg-white h-10 px-3 w-30 rounded-lg text-sm focus:outline-none" v-model="id_urgence">
                    <option :value="null"></option>
                    <option v-for="unurgence in urgence" :key="unurgence.id_urgence" :value="unurgence.id_urgence"> {{ unurgence.libelle_urgence }}</option>
                </select>
                <v-date-picker v-model="date_ticket">
                    <template v-slot="{ inputValue, inputEvents }">
                        <input class="text-center border-2 border-gray-300 bg-white h-10 px-3 w-28 rounded-lg text-sm focus:outline-none" :value="inputValue" v-on="inputEvents" placeholder="jj/mm/aaaa">
                    </template>
                </v-date-picker>
            </div>
        </div>
        <br>

        <div>
            <div class="flex items-center shadow-md w-4/5 max-w-screen-md rounded-2xl m-auto mb-7 relative animate-fade-in-down" style="padding: 5.7rem" v-for="(ticket, key) in tickets" :key="ticket.id">
                <Ticket :ticket="ticket" @redirect="openRedirect(key)" @viewSuivi="viewSuivi(key)" @charge="openCharge(key)" @photo="photo(key)" @requalifier="openRequalifier(key)" @fermer="openFermer(key)"/>
            </div>
        </div>
        <br>

        <div class="flex items-center text-indigo-50 font-semibold w-4/5 max-w-screen-md m-auto mb-7 relative animate-fade-in-down" v-if="!tickets.length">
            <div class="animate-pulse flex flex-col m-auto">
                <h1 :class="stateColor" style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold">Aucun ticket</h1>
            </div>
        </div>
        <br>
        <ModalRedirection v-model="modalRedirectionOpen" :ticket="tickets[redirectTicket]"></ModalRedirection>
        <ModalCharge v-model="modalChargeOpen" :ticket="tickets[redirectTicket]"></ModalCharge>
        <ModalSuivi v-model="modalSuiviOpen" :ticket="tickets[editTicket]"></ModalSuivi>
        <ModalFermer v-model="modalFermerOpen" :ticket="tickets[editTicket]"></ModalFermer>
        <ModalRequalifier v-model="modalRequalifierOpen" :ticket="tickets[editTicket]"></ModalRequalifier>
        <ModalImage v-model="modalImageOpen" :ticket="tickets[editTicket]"></ModalImage>
    </div>
</template>

<script>
import BaseLayout from "../Layout/Baselayout.vue"
import Ticket from "../Component/Ticket.vue"
import ModalRedirection from "../Component/ModalRedirection.vue"
import ModalCharge from "../Component/ModalCharge.vue";
import ModalImage from "../Component/ModalImage.vue";
import ModalSuivi from "../Component/ModalSuivi.vue";
import ModalRequalifier from "../Component/ModalRequalifier.vue";
import ModalFermer from "../Component/ModalFermer.vue";

export default {
    name:"Dashboard-operateur",
    layout: BaseLayout,
    data(){
        return {
            modalRedirectionOpen : false,
            modalChargeOpen : false,
            modalImageOpen : false,
            modalSuiviOpen: false,
            modalFermerOpen : false,
            modalRequalifierOpen: false,
            redirectTicket: null,
            editTicket: null,
            id_urgence: null,
            date_ticket: null,
            namedemandeur : "",
            submitTimeout: null,
        }
    },
    props: {
        tickets: Array,
        src: String,
        urgence: Array,
        procedure: Array,
        type_probleme: Array
    },
    components:{
        Ticket,
        ModalRedirection,
        ModalCharge,
        ModalSuivi,
        ModalImage,
        ModalRequalifier,
        ModalFermer,
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        },
    },
    watch: {
        id_urgence(id_urgence){
            this.$inertia.reload({ data: { id_urgence: id_urgence } })
        },
        date_ticket(date_ticket){
            let str;
            if(date_ticket){
                str = date_ticket.getFullYear()+'-'+(("0" + (date_ticket.getMonth() + 1)).slice(-2))+'-'+(("0" + date_ticket.getDate()).slice(-2));
            } else{
                str = null;
            }
            this.$inertia.reload({ data: { date_ticket: str } })
        },
    },
    mounted() {
        if(this.$page.props.flash.success){
            this.$toaster.success(this.$page.props.flash.success);
        }
        if(this.$page.props.flash.error){
            this.$toaster.error(this.$page.props.flash.error);
        }
    },
    methods:{
        openRedirect(key){
            this.redirectTicket = key;
            this.modalRedirectionOpen = true;
        },
        openCharge(key){
            this.redirectTicket = key;
            this.modalChargeOpen = true;
        },
        photo(key){
            this.editTicket = key;
            this.modalImageOpen = true;
        },
        viewSuivi(key){
            this.editTicket = key;
            this.modalSuiviOpen = true;
        },
        openIntervention(key){
            this.editTicket = key;
            this.modalInterventionOpen = true;
        },
        openRequalifier(key){
            this.editTicket = key;
            this.modalRequalifierOpen = true;
        },
        openFermer(key){
            this.editTicket = key;
            this.modalFermerOpen = true;
        },
        submit(){
            if(this.submitTimeout)
                clearTimeout(this.submitTimeout);

            this.submitTimeout = setTimeout(() =>{
                this.$inertia.reload({ data: { name: this.namedemandeur } })
            }, 500)
        }
    }
}
</script>