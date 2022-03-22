<template>
    <div class="ticket">
        <div :class="stateColor" class="absolute top-4 left-4">Problème {{ ticket.famille.libelle_famille_probleme }}</div>
        <div :class="stateColor" class="absolute top-10 left-4">{{ ticket.type.libelle_type_probleme }}</div>
        <div :class="stateColor" class="absolute top-16 left-4">{{ ticket.probleme.libelle_probleme }}</div>
        <div :class="stateColor" class="absolute bottom-4 left-4 text-2xl font-bold">Ticket n°{{ ticket.id_ticket }}</div>
        <div :class="stateColor" class="absolute bottom-14 left-4 font-bold" v-if="ticket.id_etat == 3">
            <span v-if="ticket.isResolved" class="flex items-center">
                <ion-icon name="checkmark-circle-outline"></ion-icon>
                <span class="ml-1"> Probléme résolu </span>
            </span>
            <span v-else class="flex items-center">
                <ion-icon name="close-circle-outline"></ion-icon>
                <span class="ml-1"> Probléme non résolu </span>
            </span>
        </div>
        <div :class="stateColor" class="absolute top-4 left-1/2 transform translate-x-[-50%] text-2xl font-bold">Poste : {{ ticket.poste_ticket }}</div>

        <!-- demandeur -->
        <button :class="stateTheme" class="absolute top-1/3 left-1/2 transform translate-x-[-50%] hover:opacity-80 text-white font-bold py-2 px-4 rounded" v-if="stateTheme == 'demandeur' && ticket.etat.libelle_etat !== 'Terminé'" @click="$emit('edit')">Compléter</button>
        
        <!-- operateur -->
        <button :class="stateTheme" class="absolute top-2/3 left-1/2 transform translate-x-[-50%] hover:opacity-80 text-white font-bold py-2 px-4 rounded" v-if="(stateTheme == 'operateur' || stateTheme == 'responsable') && ticket.id_etat == 1" @click="$emit('charge')">Prendre en charge</button>
        <button :class="stateTheme" class="absolute top-1/3 left-1/2 transform translate-x-[-50%] hover:opacity-80 text-white font-bold py-2 px-4 rounded" v-if="stateTheme == 'operateur' && ticket.etat.libelle_etat !== 'Terminé'" @click="$emit('redirect')">Rediriger</button>
        <button :class="stateTheme" class="absolute left-1/3 transform translate-x-[-30%] inline-flex items-center justify-center w-10 h-10 text-indigo-100 transition-colors duration-150 rounded-full focus:shadow-outline hover:opacity-80" v-if="(stateTheme == 'operateur' || stateTheme == 'responsable') && ticket.id_etat == 2" @click="$emit('requalifier')"><ion-icon name="create-outline"></ion-icon></button>
        <button :class="stateTheme" class="absolute left-2/3 transform translate-x-[-70%] inline-flex items-center justify-center w-10 h-10 text-indigo-100 transition-colors duration-150 rounded-full focus:shadow-outline hover:opacity-80" v-if="(stateTheme == 'operateur' || stateTheme == 'responsable') && ticket.id_etat == 2" @click="$emit('fermer')"><ion-icon name="close-outline"></ion-icon></button>
        
        <!-- responsable -->
        <button :class="stateTheme" class="absolute top-1/3 left-1/2 transform translate-x-[-50%] hover:opacity-80 text-white font-bold py-2 px-4 rounded" v-if="stateTheme == 'responsable' && ticket.etat.libelle_etat !== 'Terminé'" @click="$emit('transfer')">Transférer</button>
        
        <!-- all -->
        <button :class="stateTheme" class="absolute right-4 inline-flex items-center justify-center w-10 h-10 text-indigo-100 transition-colors duration-150 rounded-full focus:shadow-outline hover:opacity-80" style="top: 4.4rem" v-if="ticket.path_piece_ticket" @click="$emit('photo')"><ion-icon name="document-attach-outline"></ion-icon></button>
        <button :class="stateTheme" class="absolute top-2/3 left-1/2 transform translate-x-[-50%] hover:opacity-80 text-white font-bold py-2 px-4 rounded" @click="$emit('viewSuivi')" v-if="stateTheme == 'demandeur' || ((stateTheme == 'operateur' || stateTheme == 'responsable') && (ticket.id_etat == 2 || ticket.id_etat == 3) )">Voir le suivi</button>

        <div :class="stateColor" class="absolute top-4 right-4">{{ ticket.date_ticket }}</div>
        <div class="absolute top-10 right-4">{{ ticket.urgence.libelle_urgence }}</div>
        <div class="absolute bottom-10 right-4" v-if="ticket.date_resolution_prevu !== null">Fin prévue : {{ ticket.date_resolution_prevu }}</div>
        <div class="absolute bottom-4 right-4">Traitement : {{ ticket.etat.libelle_etat }}</div>
        <div></div>
    </div>
</template>

<script>
export default {
    name:"Ticket",
    props:{
        ticket: {
            type: Object,
            required: true
        }, 
        
    },
    data(){
        return {modalOpen : false}
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
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