<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Intervenir sur le ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Intervenir sur le ticket </template>
        </template>
        
        <form method="post" class="p-4" @submit.prevent="submit">
            <div class="flex justify-around mb-4">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex-1">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Nom de l'intervention
                    </label>
                    <input v-model="form.libelle_intervention" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" type="text">
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex-1">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Procedure
                    </label>
                    <div class="relative">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="form.id_procedure" >
                            <option></option>
                            <option  v-for="pro in procedure" :key="pro.id_procedure" :value="pro.id_procedure">
                                {{ pro.libelle_procedure}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <button type="button" class=" flex-1 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click="$emit('input', false)">
                    Annuler
                </button>
                <button :class="stateTheme" class="flex-1 ml-4 hover:opacity-80 text-white font-bold py-2 px-4 rounded" type="sumbit">Intervenir</button>
            </div>
            
        </form>
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
        },
    },
    data(){
        return {
            form: this.$inertia.form({
                libelle_intervention: null,
                id_procedure: null,
                id_operateur: null,
                id_ticket: null,
            })
        }
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        },
        procedure() {
            return this.$page.props.procedure;
        },
    },
    methods: {
        submit() {
            this.form.id_operateur = this.ticket.id_operateur;
            this.form.id_ticket = this.ticket.id_ticket;
            this.form.post(this.$route(this.stateTheme == 'responsable' ? "res.add-intervention" : "ope.add-intervention"), {
                onSuccess: () => {
                    this.form.reset();
                    this.$emit("input", false);
                    this.$toaster.success("L'intervention a bien été enregistré.");

                },
            });
        },
    }
}
</script>