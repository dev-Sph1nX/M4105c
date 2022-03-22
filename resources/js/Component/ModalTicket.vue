<template>
  <Modal v-bind="$attrs" v-on="$listeners">
    <template #title>
      <template v-if="ticket">
        Compléter le ticket n°{{ ticket.id_ticket }}
      </template>
      <template v-else> Ajouter un ticket </template>
    </template>
    <!-- Modal body -->
    <form id="add" @submit.prevent="submit" method="post" enctype="multipart/form-data">
      <div class="p-7 bg-white">
        <div class="flex flex-wrap -mx-3 mb-6">
          <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
            <label for="poste" class="block mb-2 text-sm tracking-wide font-medium text-gray-900">Numéro de poste</label>
            <input v-model="form.poste" :disabled="ticket" id="poste" type="text" name="poste" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="D111-S11" required >
          </div>

          <div class="w-full md:w-1/2 px-3">
            <label for="grid-urgence" class="block mb-2 tracking-wide text-sm font-medium text-gray-900">Urgence</label>
            <select :disabled="ticket" v-model="form.urgence" id="urgence" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option></option>
              <option v-for="urg in liste_urgence" :key="urg.id_urgence" :value="urg.id_urgence">
                {{ urg.libelle_urgence }}
              </option>
            </select>
          </div>
        </div>

        <div>
          <label for="message" class="block mb-2 text-sm font-medium text-gray-900 tracking-wide">Description de votre problème</label>
          <textarea v-model="form.message" id="message" name="message" rows="4" placeholder="Vous pouvez laisser une description..." class="tracking-wide bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus-visible:ring-blue-500 focus-visible:border-blue-500 block w-full p-2.5"></textarea>
        </div>

        <div>
          <label class="block mb-2 tracking-wide text-sm font-medium text-gray-900 mt-5" for="piece_jointe">Pièce jointe</label>
          
          <template v-if="ticket && ticket.path_piece_ticket">
            <button :class="stateTheme" class="inline-flex items-center justify-center w-10 h-10 text-indigo-100 transition-colors duration-150 rounded-full focus:shadow-outline hover:opacity-80" style="top: 4.4rem" @click.prevent="photo()"><ion-icon name="document-attach-outline"></ion-icon></button>
          </template>          
          <template v-else>
            <input :disabled="ticket" @input="form.file = $event.target.files[0]" class="bg-gray-50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 file:cursor-pointer focus:outline-none focus:border-transparent py-3 px-4 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold hover:file:bg-gray-100
            " aria-describedby="piece_jointe_help" id="piece_jointe" type="file" accept="image/*">
            <div class="tracking-wide text-black text-xs font-medium mb-4 pt-2" id="user_avatar_help">
              Une pièce jointe est toujours bienvenue pour aider l'opérateur qui sera en charge du ticket
            </div>
          </template>

        </div>

        <div class="flex flex-wrap -mx-3 mb-6 mt-6">
          <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label class="block mb-2 tracking-wide text-sm font-medium text-gray-900" for="famille_probleme">Famille de votre problème</label>
            <select :disabled="ticket" v-model="form.fam_probleme" id="famille_probleme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option :value="null"></option>
              <option v-for="famille in liste_famille" :key="famille.id_famille_probleme" :value="famille.id_famille_probleme">
                {{ famille.libelle_famille_probleme }}
              </option>
            </select>
          </div>

          <div class="w-full md:w-1/3 px-3">
            <label class="block mb-2 tracking-wide text-sm font-medium text-gray-900" for="type_probleme">Type de votre problème</label>
            <select :disabled="filtered_liste_type.length === 0 || ticket" v-model="form.type_probleme" id="type_probleme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option :value="null"></option>
              <option v-for="type in filtered_liste_type" :key="type.id_type_probleme" :value="type.id_type_probleme">
                {{ type.libelle_type_probleme }}
              </option>
            </select>
          </div>

          <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
            <label class="block mb-2 tracking-wide text-sm font-medium text-gray-900" for="probleme">Problème</label>
            <select :disabled="filtered_liste_probleme.length === 0 || ticket" v-model="form.probleme" id="probleme" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
              <option></option>
              <option v-for="prbl in filtered_liste_probleme" :key="prbl.id_probleme" :value="prbl.id_probleme">
                {{ prbl.libelle_probleme }}
              </option>
            </select>
          </div>
        </div>
      </div>
      
      <div class="flex items-center p-5 space-x-2 rounded-b border-t border-gray-200">
        <input :class="stateTheme" type="submit" value="Valider" class="cursor-pointer text-white focus:ring-4 hover:opacity-80 focus:opacity-80 font-medium rounded-lg text-sm px-5 py-2.5 text-center" :disabled="form.processing">
        <button data-modal-toggle="large-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10" @click="$emit('input', false)">
          Annuler
        </button>
      </div>
    </form>

    <ModalImage v-model="modalImageOpen" :ticket="ticket"></ModalImage>
  </Modal>
</template>

<script>
import Modal from "../Component/Modal.vue";
import ModalImage from "../Component/ModalImage.vue";

export default {
  props: {
    ticket: {
      type: Object,
    },
  },
  components: {
    Modal,
    ModalImage,
  },
  data() {
    return {
      form: this.$inertia.form({
        id_ticket: "",
        poste: "",
        urgence: "",
        message: "",
        file: "",
        fam_probleme: "",
        type_probleme: "",
        probleme: "",
        user_id: this.$page.props.user.id,
      }),
      disabled_type_prbl: true,
      disabled_prbl: true,
      famille_id_select: 0,
      right_type_liste: [],
      right_probleme_liste: [],
      modalImageOpen : false,
    };
  },
  computed: {
    stateTheme() {
      return this.$store.state.theme;
    },
    stateColor() {
      return this.$store.state.color;
    },
    liste_type() {
      return this.$page.props.type_probleme;
    },
    liste_urgence() {
      return this.$page.props.urgence;
    },
    liste_famille() {
      return this.$page.props.famille_probleme;
    },
    liste_probleme() {
      return this.$page.props.probleme;
    },
    filtered_liste_type() {
      let filteredList = [];
      this.liste_type.forEach((el) => {
        if (el.id_famille_probleme == this.form.fam_probleme) {
          filteredList.push(el);
        }
      });
      return filteredList;
    },
    filtered_liste_probleme() {
      let filteredList = [];
      this.liste_probleme.forEach((el) => {
        if (el.id_famille_probleme == this.form.fam_probleme) {
          filteredList.push(el);
        }
      });
      return filteredList;
    },
  },
  watch: {
    ticket(ticket) {
      this.form = this.$inertia.form({
        id_ticket: ticket?.id_ticket ?? "",
        poste: ticket?.poste_ticket ?? "",
        urgence: ticket?.id_urgence ?? "",
        message: ticket?.description_ticket ?? "",
        file: "",
        // file: ticket?.path_piece_ticket ?? "",
        fam_probleme: ticket?.id_famille_probleme ?? "",
        type_probleme: ticket?.id_type_probleme ?? "",
        probleme: ticket?.id_probleme ?? "",
        user_id: this.$page.props.user.id,
      });
    },
  },
  methods: {
    submit() {
      this.form.post(this.$route(this.ticket ? "update-ticket" : "add-ticket"), {
          onSuccess: () => {
            this.form.reset();
            this.$emit("input", false);
            this.$toaster.success(this.ticket ? "Le ticket a bien été modifié." : "Le ticket a bien été ajouté.");

          },
        });
    },
    photo(){
      this.modalImageOpen = true;
    },
  },
};
</script>