<template>

    <Modal v-bind="$attrs" v-on="$listeners">
        <template #title>
            <template v-if="ticket">
                Requalifier le ticket n°{{ ticket.id_ticket }}
            </template>
            <template v-else> Requalifier le ticket </template>
        </template>
        
        <form method="post" class="p-4" @submit.prevent="submit" v-if="ticket">
            <div class="mb-4">
                <p for="message" class="block mb-2 text-sm font-medium text-gray-900 tracking-wide">Description du probléme par l'utilisateur :</p>
                <p   id="message" name="message" rows="3" class="tracking-wide bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus-visible:ring-blue-500 focus-visible:border-blue-500 block w-full p-2.5">
                    {{ticket.description_ticket}}
                </p>
            </div>
            <div class="flex justify-around mb-4">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex-1">
                    <label class="block tracking-wide text-gray-700 text-xs mb-2">
                        <span class="font-bold uppercase"> Type de problème </span> - Famille : {{ ticket.famille.libelle_famille_probleme}}
                    </label>
                    <div class="relative">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="form.id_type_probleme" >
                            <option></option>
                            <option  v-for="type in filtered_liste_type" :key="type.id_type_probleme" :value="type.id_type_probleme">
                                {{ type.libelle_type_probleme}}
                            </option>
                        </select>
                    </div>                
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0 flex-1">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Urgence
                    </label>
                    <div class="relative">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                        v-model="form.id_urgence" >
                            <option></option>
                            <option 
                            :selected="ticket.id_urgence = urgence.id_urgence" 
                            v-for="urgence in liste_urgence" :key="urgence.id_urgence" 
                            :value="urgence.id_urgence">
                                {{ urgence.libelle_urgence}}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end">
                <button type="button" class=" flex-1 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click="annuler()">
                    Annuler
                </button>
                <button :class="stateTheme" class="flex-1 ml-4 hover:opacity-80 text-white font-bold py-2 px-4 rounded" type="sumbit">Requalifier</button>
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
                id_urgence: null,
                id_type_probleme: null,
                id_ticket: null,
            }),
            id_famille : ""
        }
    },
    computed: {
        stateTheme() {
            return this.$store.state.theme
        },
        stateColor() {
            return this.$store.state.color
        },
        liste_type() {
            return this.$page.props.type_probleme;
        },
        filtered_liste_type() {
            let filteredList = [];
            this.liste_type.forEach((el) => {
                if (el.id_famille_probleme == this.id_famille) {
                filteredList.push(el);
                }
            });
            return filteredList;
        },
        liste_urgence() {
            return this.$page.props.urgence;
        },
    },
    watch: {
        ticket(ticket) {
            this.id_famille = ticket?.id_famille_probleme ?? ""
            this.form = this.$inertia.form({
                id_ticket: ticket?.id_ticket ?? "",
                id_urgence: ticket?.id_urgence ?? "",
                id_type_probleme: ticket?.id_type_probleme ?? "",
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.$route("requalifier-ticket"), {
                onSuccess: () => {
                    this.form.reset();
                    this.$emit("input", false);
                    this.$toaster.success("Le ticket a bien été requalifié.");
                },
            });
        },
        annuler(){
            this.form = this.$inertia.form({
                id_ticket: this.ticket?.id_ticket ?? "",
                id_urgence: this.ticket?.urgence.id_urgence ?? "",
                id_type_probleme: this.ticket?.id_type_probleme ?? "",
            })
            this.$emit('input', false);
        }
    }
}
</script>