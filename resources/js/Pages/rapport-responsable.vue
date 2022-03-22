<template>
  <div>
    <!-- <Link href="/utilisateur" class="m-3.5">
      <ion-icon
        name="arrow-back-circle-outline"
        class="visible align-middle"
      ></ion-icon>
      <span class="align-middle"> Retour au tableau de bord</span>
    </Link> -->

    <div class="text-center">
      <h1
        style="font-family: 'Dosis', sans-serif"
        class="leading-tight text-5xl mb-2 mt-5 font-bold"
      >
        Statistiques
      </h1>
      <p>Voir les statistiques de votre service</p>
    </div>

    <div class="m-auto w-3/5 flex items-center flex-col mt-10">
      <table class="w-full">
        <tbody>
          
            <tr v-for="stat in stats" :key="stat.title" class="animate-fade-in-right">
              <td class="w-1/5 text-right pr-1.5 align-middle pt-1.5">
                <ion-icon :name="stat.icon" class="text-3xl"></ion-icon>
              </td>
              <td class="w-2/5">{{ stat.title }} :</td>
              <td class="w-2/5 mt-6">{{ stat.info }}</td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import BaseLayout from "../Layout/Baselayout.vue";
export default {
  name: "Rapport-responsable",
  layout: BaseLayout,
  props: {
    stats: Array,
  },
};
</script>