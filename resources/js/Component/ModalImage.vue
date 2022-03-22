<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Pièce-jointe du ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Pièce-jointe du ticket </template>
        </template>
        
        <div class="flex flex-col w-full lg:flex-row" v-if="ticket">
            <img class="m-auto p-4" v-bind:src="'../storage/' + ticket.path_piece_ticket">
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