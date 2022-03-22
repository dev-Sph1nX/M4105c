<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Rediriger le ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Rediriger le ticket </template>
        </template>
        
        <div class="flex flex-col w-full lg:flex-row" v-if="ticket">
            <div v-if="stateTheme == 'operateur'" class="flex flex-row w-full">
                <div class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center">
                    <a v-if="ticket.nb_redirections < 3" :href="'/operateur/dashboard/redirectOperateur/' + ticket.id_ticket + '/' + ticket.id_operateur" :class="stateTheme" class="inline-flex items-center justify-center px-5 py-3 border border-transparent 
                    text-base font-medium rounded-md text-white hover:opacity-80"> Vers un autre opérateur </a>
                    <p v-else class="text-red-500 text-s">Redirection vers un autre opérateur impossible :<br> Le ticket a déjà trop redirigé</p>
                </div> 
                <div class="divider lg:divider-horizontal"></div> 
                <div class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center">
                    <a :href="'/operateur/dashboard/redirectResponsable/' + ticket.id_ticket" :class="stateTheme" class="inline-flex items-center justify-center px-5 py-3 border border-transparent 
                    text-base font-medium rounded-md text-white hover:opacity-80"> Vers le responsable de service </a>
            
                </div>
            </div>
            <div v-if="stateTheme == 'responsable'" class="w-full">
                <div class="grid flex-grow h-32 card bg-base-300 rounded-box place-items-center w-full">
                    <Link v-if="ticket.nb_redirections < 3" :href="'/responsable/dashboard/redirectOperateur/' + ticket.id_ticket" :class="stateTheme" class="inline-flex items-center justify-center px-5 py-3 border border-transparent 
                    text-base font-medium rounded-md text-white hover:opacity-80"> Vers un opérateur </Link>
                    <p v-else class="text-red-500 text-s">Redirection vers un opérateur impossible :<br> Le ticket a déjà trop redirigé <br> Vous devez vous-même prendre en charge le ticket.</p>
                </div> 
            </div>
        </div>
    </Modal>
</template>

<script>

import Modal from "../Component/Modal.vue";

export default {
    components: {
        Modal,
    },
    props: {
        ticket: {
            type: Object
        }
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        },
    }
}
</script>