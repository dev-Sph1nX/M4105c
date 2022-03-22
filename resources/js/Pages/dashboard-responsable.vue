<template>
    <div>
        <div class="text-center">
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-if="!src">Tickets retournés</h1>
            <h1 style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold" v-else>Tickets résolus</h1>
            
            <p v-if="!src">Voici la liste des tickets qui vous ont été retournés</p>
            <p v-else>Voici la liste des tickets qui sont résolus</p>
        </div>
        <br>

        <div>
        <div class="flex items-center shadow-md w-4/5 max-w-screen-md rounded-2xl m-auto mb-7 relative animate-fade-in-down" style="padding: 5.7rem" v-for="(ticket, key) in tickets" :key="ticket.id">
                <Ticket :ticket="ticket" @transfer="openRedirect(key)" @charge="openCharge(key)" @viewSuivi="viewSuivi(key)" @photo="photo(key)" @requalifier="openRequalifier(key)" @fermer="openFermer(key)"/>
            </div>
        </div>
        <br>

        <div class="flex items-center text-indigo-50 font-semibold w-4/5 max-w-screen-md m-auto mb-7 relative animate-fade-in-down" v-if="!tickets.length">
            <div class="animate-pulse flex flex-col m-auto">
                <h1 :class="stateColor" style="font-family: 'Dosis', sans-serif" class="leading-tight text-5xl mb-2 mt-5 font-bold">Aucun ticket</h1>
            </div>
        </div>
        <br>

        <ModalRedirection v-model="modalRedirectionOpen" :ticket="tickets[redirectTicket]" ></ModalRedirection>
        <ModalCharge v-model="modalChargeOpen" :ticket="tickets[redirectTicket]"></ModalCharge>
        <ModalSuivi v-model="modalSuiviOpen" :ticket="tickets[editTicket]"></ModalSuivi>
        <ModalImage v-model="modalImageOpen" :ticket="tickets[editTicket]"></ModalImage>
        <ModalFermer v-model="modalFermerOpen" :ticket="tickets[editTicket]"></ModalFermer>
        <ModalRequalifier v-model="modalRequalifierOpen" :ticket="tickets[editTicket]"></ModalRequalifier>
        <ModalForceUser v-model="modalForceUserOpen" @transfer="closeForceModal()"></ModalForceUser>

    </div>
</template>

<script>

import BaseLayout from "../Layout/Baselayout.vue"
import Ticket from "../Component/Ticket.vue"
import ModalRedirection from "../Component/ModalRedirection.vue"
import ModalCharge from "../Component/ModalCharge.vue";
import ModalImage from '../Component/ModalImage.vue';
import ModalSuivi from "../Component/ModalSuivi.vue";
import ModalRequalifier from "../Component/ModalRequalifier.vue";
import ModalFermer from "../Component/ModalFermer.vue";
import ModalForceUser from "../Component/ModalForceUser.vue";

export default {
    name:"Dashboard-responsable",
    layout: BaseLayout,
    props: {
        tickets: Array,
        src: String,
        msg: String,
        procedure: Array
    },
    data(){
        return {
            modalRedirectionOpen : false,
            modalChargeOpen : false,
            modalImageOpen : false,
            modalSuiviOpen : false,
            redirectTicket: null,
            editTicket: null,
            modalRequalifierOpen: null,
            modalFermerOpen: null,
            modalForceUserOpen: null,
        }
    },
    components:{
        Ticket,
        ModalRedirection,
        ModalCharge,
        ModalSuivi,
        ModalImage,
        ModalRequalifier,
        ModalFermer,
        ModalForceUser
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        }
    },
    mounted() {
        if(this.$page.props.flash.success){
            this.$toaster.success(this.$page.props.flash.success);
        }
        if(this.$page.props.flash.error){
            this.$toaster.error(this.$page.props.flash.error);
        }
        if(this.$page.props.flash.action){
            if(this.$page.props.flash.action == 'forceOpenUserModal'){
                this.modalForceUserOpen = true;
            }
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
        viewSuivi(key){
            this.editTicket = key;
            this.modalSuiviOpen = true;
        },
        photo(key){
            this.editTicket = key;
            this.modalImageOpen = true;
        },
        openRequalifier(key){
            this.editTicket = key;
            this.modalRequalifierOpen = true;
        },
        openFermer(key){
            this.editTicket = key;
            this.modalFermerOpen = true;
        },
        closeForceModal(){
            this.modalForceUserOpen = false;
        }
    },
}
</script>