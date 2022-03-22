<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Prendre en charge le ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Prendre en charge le ticket </template>
        </template>

        <form v-if="ticket" class="relative" @submit.prevent="submit">
        
            <div class="m-7">
                <div class="mb-4">
                    <p for="message" class="block mb-2 text-sm font-medium text-gray-900 tracking-wide">Description du probléme par l'utilisateur :</p>
                    <p   id="message" name="message" rows="3" class="tracking-wide bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus-visible:ring-blue-500 focus-visible:border-blue-500 block w-full p-2.5">
                        {{ticket.description_ticket}}
                    </p>
                </div>
                <div class="mb-4">
                    <h2 class="text-sm font-bold text-gray-900 tracking-wide mb-2">
                        Date de résolution prévue du probléme :
                    </h2>
                    <v-date-picker v-model="form.date" :min-date='new Date()'>
                        <template v-slot="{ inputValue, inputEvents }">
                            <input required
                            class="px-2 py-1 border rounded focus:outline-none focus:border-blue-300"
                            :value="inputValue"
                            v-on="inputEvents"
                            />
                        </template>
                    </v-date-picker>
                </div>
                <div>
                    <p for="commentaire" class="block mb-2 text-sm font-medium text-gray-900 tracking-wide">Votre commentaire : <i>(facultatif)</i> </p>
                    <textarea v-model="form.comment"  id="commentaire" name="commentaire" rows="3" class="tracking-wide bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus-visible:ring-blue-500 focus-visible:border-blue-500 block w-full p-2.5">
                    </textarea>
                </div>

                
            </div>
            
            <div class="p-4 flex justify-center items-center">
                <button type="button" class="flex-1 mx-5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click.prevent="$emit('input', false)">
                    Annuler
                </button>
                <button type="submit" :class="stateTheme" class="flex-1 mx-5 hover:opacity-80 text-white font-bold py-2 px-4 rounded">
                    Prendre en charge
                </button>
            </div>

        </form>
        <div v-else>
            <p class="text-red-500">Erreur 404</p>
        </div>
        
        
    </Modal>
</template>

<script>

import Modal from "../Component/Modal.vue";

export default {
    props: {
        ticket: {
            type: Object,
        },
    },
    data(){
        return{
            form: this.$inertia.form({
                date: null,
                id_ticket: null,
                comment: null
            }),
            time: new Date().getHours() + "-" + new Date().getMinutes() + "-" + new Date().getSeconds(),
        }
    },
    components: {
        Modal,
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
        submit(){
            this.form.id_ticket = this.ticket.id_ticket;
            this.form.post(this.$route(this.stateTheme == 'responsable' ? "res.prendre-charge" : "ope.prendre-charge"), {
                onSuccess: () => {
                    this.form.reset();
                    this.$emit("input", false);
                    this.$toaster.success("Vous avez pris en charge le ticket.");
                }
            })
        }
    }
}
</script>