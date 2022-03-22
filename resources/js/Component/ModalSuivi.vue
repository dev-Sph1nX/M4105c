<template>
  <Modal v-bind="$attrs" v-on="$listeners">
    <template #title>
      <template v-if="ticket">
        Suivre le ticket n°{{ ticket.id_ticket }}
      </template>
      <template v-else> Suivre le ticket </template>
    </template>

    <div class="p-7" v-if="ticket">
      <div class="flex w-full">
        <div class="w-1/2">
          <h1 class="text-xl font-semibold text-gray-9001lg:text-2xl">
            Interventions :
          </h1>
            <div>
              <div v-if="!ticket.interventions.length" class="w-full flex justify-center mt-5">
                <p>Aucune intervention</p>
              </div>
              <div class="bg-white rounded shadow px-4 py-2 my-4 mx-8 flex items-center"
                    v-for="inte in ticket.interventions"
                    :key="inte.id_intervention">
                <div class="p-2 bg-indigo-700 rounded text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div class="ml-6">
                  <h3 class="text-gray-800 font-bold text-l">{{inte.libelle_intervention}}</h3>
                  <p class="text-gray-600 text-sm tracking-normal font-normal leading-5">Fait par {{inte.operateur.name}} <br> Le {{inte.date_intervention}}</p>
                </div>
              </div>
            </div>
        </div>
        <div class="border-l-2 w-1/2 grid justify-items-center">
          <!-- Etat du ticket -->
          <div class="justify-items-center">
              <h1 class="text-xl font-semibold text-gray-9001lg:text-2xl mb-2">
                Etat du ticket :
            </h1>
            <span :class="{ hidden : isEnAttente }" class="text-sm font-semibold inline-block px-2 py-1 uppercase rounded text-orange-600 bg-orange-200 uppercase last:mr-0 mr-1 items-center flex justify-items-center">
                <p class="m-auto">En attente</p>
            </span>
            <span :class="{ hidden: isEnCours }" class="text-sm font-semibold inline-block px-2 py-1 uppercase rounded text-blue-600 bg-blue-200 uppercase last:mr-0 mr-1 items-center flex justify-items-center">
                <p class="m-auto">En cours</p>
            </span>
            <span :class="{ hidden: isTermine }" class="text-sm font-semibold inline-block px-2 py-1 uppercase rounded text-emerald-600 bg-emerald-200 uppercase last:mr-0 mr-1 items-center flex justify-items-center">
                <p class="m-auto">Terminé</p>
            </span>
          </div>
          <!-- Operateur en charge + Commentaire -->
          <div class="flex flex-col mt-4 text-center">
            <div v-if="stateTheme == 'demandeur' && ticket.id_etat == 2">
              <h1 class="text-xl font-semibold text-gray-9001lg:text-2xl mb-2">
                  Operateur en charge du ticket :
              </h1>
              <div v-if="ticket" class="flex mb-10">
                  <p v-if="ticket.id_operateur" class="m-auto">{{ticket.operateur.name}}</p>
                  <p v-else class="m-auto">Aucun opérateur</p>
              </div>
              <div v-if="ticket.commentaire_ticket" >
                <h1 class="text-xl font-semibold">
                  Le commentaire de {{ticket.operateur.name}} :
                </h1>
                <div v-if="ticket" class="flex">
                    <p class="m-auto">{{ticket.commentaire_ticket}}</p>
                </div>
              </div> 
              <div v-if="ticket.date_resolution_prevu 	" >
                <h1 class="text-xl font-semibold">
                  Date de resolution prévue :
                </h1>
                <div v-if="ticket" class="flex">
                    <p class="m-auto">{{ticket.date_resolution_prevu}}</p>
                </div>
              </div> 
            </div>

            <div v-if="(stateTheme == 'operateur' || stateTheme == 'responsable') && ticket.id_etat == 2">
              <h1 class="text-xl font-semibold text-gray-9001lg:text-2xl mb-2">
                  Ajouter une intervention :
              </h1>
                <button :class="stateTheme" class="hover:opacity-80 text-white font-bold py-2 px-4 rounded" v-if="(stateTheme == 'operateur' || stateTheme == 'responsable') && ticket.id_etat == 2" @click="openIntervention()">Intervenir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <ModalIntervention v-model="modalInterventionOpen" :ticket="ticket"></ModalIntervention>
  </Modal>
</template>

<script>
import Modal from "../Component/Modal.vue";
import ModalIntervention from "../Component/ModalIntervention.vue"

export default {
  props: {
    ticket: {
      type: Object,
    },
  },
  components: {
    Modal,
    ModalIntervention,
  },
  data(){
    return{
      modalInterventionOpen : false,
    }
  },
  computed: {
    stateTheme() {
        return this.$store.state.theme
    },
    stateColor() {
        return this.$store.state.color
    },
    isEnAttente() {
        if(this.ticket){
            if (this.ticket.id_etat == 1) {
                return false;
            } else {
                return true;
            }
        }
    },
    isEnCours() {
      if(this.ticket){
            if (this.ticket.id_etat == 2) {
                return false;
            } else {
                return true;
            }
        }
    },
    isTermine() {
      if(this.ticket){
            if (this.ticket.id_etat == 3) {
                return false;
            } else {
                return true;
            }
        }
    },
  },
  methods: {
    openIntervention(){
      this.modalInterventionOpen = true;
    }
  }
};
</script>