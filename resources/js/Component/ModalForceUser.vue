<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="id_ticket">
                Transférer le ticket n°{{ id_ticket }}
            </template>
            <template v-else> Transférer le ticket </template>
        </template>
        
        <div class="p-4">
            <div class="text-black font-medium mb-4 pt-2">
                <span class="text-red-600 font-bold"> Transfert impossible -- Aucun opérateur n'est compétent sur cette famille de problème. </span> <br>
                Si vous voulez tener vraiment à transférer ce ticket : <br> 
                Choisissez dans la liste des opérateurs, l'operateur que vous pensez capable de traiter le problème.
            </div>

            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex-1">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                    Opérateurs
                </label>
                <div class="relative">
                    <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="id_operateur" required>
                        <option></option>
                        <option v-for="ope in operateurs" :key="ope.id" :value="ope.id">
                            {{ope.name}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="w-full flex justify-end mt-6">
                <button type="button" class=" flex-1 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click="$emit('input', false)">
                    Annuler
                </button>
                <button :class="stateTheme" class="flex-1 ml-4 hover:opacity-80 text-white font-bold py-2 px-4 rounded" @click="transfer()">Transferer</button>
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
    data(){
        return {
            id_operateur: null,
            operateurs : Array,
        }
    },
    computed: {
        id_ticket() {
            return this.$page.props.flash.action_data?.id;
        },
        liste_operateur(){
            this.operateurs = this.$page.props.flash.action_data?.liste_operateur;
        },
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        },
    },
    methods: {
        transfer(){
            this.$emit('transfer');
            this.$inertia.post(this.$route('res.force.redirect', {id : this.id_ticket}), { id_operateur : this.id_operateur})
        }
    }
}
</script>