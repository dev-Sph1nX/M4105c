<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Cloturer le ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Fermer le ticket </template>
        </template>
        
        <form method="post" class="p-4" @submit.prevent="submit">
            <div class="flex justify-around mb-4">
                <div class="my-4">
                    <span class="block tracking-wide text-gray-700 font-bold mb-2">Avez vous trouvez une solution au ticket ?</span>
                    <div class="mt-2 flex justify-center">
                        <label class="inline-flex items-center text-gray-700 font-bold ">
                            <input type="radio" class="form-radio" name="accountType" :value="true" v-model="form.resolved">
                            <span class="ml-2">Oui</span>
                        </label>
                        <label class="inline-flex items-center ml-6 text-gray-700 font-bold ">
                            <input type="radio" class="form-radio" name="accountType" :value="false" v-model="form.resolved">
                            <span class="ml-2">Non</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <button type="button" class=" flex-1 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click="$emit('input', false)">
                    Annuler
                </button>
                <button :class="stateTheme" class="flex-1 ml-4 hover:opacity-80 text-white font-bold py-2 px-4 rounded" type="sumbit">Cloturer</button>
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
                id_ticket: null,
                resolved: null,
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
    },
    methods: {
        submit() {
            this.form.id_ticket = this.ticket.id_ticket;
            this.form.post(this.$route("fermer-ticket"), {
                onSuccess: () => {
                    this.form.reset();
                    this.$emit("input", false);
                    this.$toaster.success("Le ticket a bien été fermé.");

                },
            });
        },
    }
}
</script>