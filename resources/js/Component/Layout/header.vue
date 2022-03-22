<template>
    <nav :class="stateTheme" class="flex items-center justify-center p-2 relative w-full z-10 pin-t">
        <div class="flex items-center flex-no-shrink mr-6">
            <a class="scale-90" :href="'/'+stateTheme+'/dashboard'">
                <img src="/pictures/logo-navbar-white.png" alt="Helpdesk">
            </a>
        </div>

        <div class="flex flex-row" style="width: 45rem">
            <div class="text-white pr-5">
                <Link :href="'/'+stateTheme+'/dashboard'">En Cours</Link>
            </div>   
            <div class="text-white w-auto pr-5">
                <Link :href="'/'+stateTheme+'/finish'">Fermés</Link>
            </div>
             <div class="text-white w-auto">
                <Link :href="'/demandeur/all'" v-if="stateTheme === 'demandeur'">Tous</Link>
                <Link :href="$route('res.rapport')" v-if="stateTheme === 'responsable'">Statistiques</Link>
             </div>
        </div>   

        <div class="w-full flex-grow items-center block pt-0 text-white" id="nav-content">
            <ul class="list-reset flex justify-end flex-1 items-center">
                <li class="mr-3"> 
                    <a href="/demandeur/notifications" v-if="stateTheme === 'demandeur'">
                        Notifications
                        <span v-if="hasNotif" class="inline-block animate-ping rounded-full p-2 bg-teal-400 text-white text-xs">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                        </span>
                    </a>
                    
                    <a class="group inline-block text-white no-underline hover:text-grey-lighter hover:text-underline hover:cursor-default py-2 px-4">
                        {{user.name}} : <span class="text-sm">{{showRole}}</span>
                        <div v-if="stateTheme == 'operateur'" class="fixed bottom-8 right-8 p-4 hidden group-hover:block max-w-xs mx-auto rounded-lg bg-white ring-1 ring-slate-900/5 shadow-lg space-y-3">
                            <div class="flex items-center space-x-3">
                                <h3 class="text-slate-900 text-sm font-semibold">{{user.name}} : <span class="text-sm">{{showRole}}</span></h3>
                            </div>
                            <p class="text-slate-900 text-sm">
                                Compétence(s) :
                            </p>
                            <p class="text-slate-500 text-sm" v-for="familleProbleme in user.familles_problemes" :key="familleProbleme.id_famille_probleme">
                                {{familleProbleme.libelle_famille_probleme}}
                            </p>
                        </div>
                    </a>    
                </li>
                <li class="mr-3">
                    <a class="bg-white hover:bg-white-400 text-black hover:opacity-90 font-bold py-2 px-4 rounded" href="/logout">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Header",
    data(){
        return{

        }
    },
    computed: {
        user() {
            return this.$page.props.user ?? {};  
        },
        hasNotif(){
            return this.$page.props.has_notif;
        },
        stateTheme() {
            return this.$store.state.theme
        },
        showRole(){
            const str = this.$store.state.theme;
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        
    },
    mounted(){
        this.$store.commit('changeTheme', this.user);
        this.$store.commit('changeColor', this.user);
    },
    watch: {
        user: {
            deep:true,
            handler(user){
                this.$store.commit('changeTheme', user);
                this.$store.commit('changeColor', user);
            }
        }
    },
    methods: {
        // haveNotif(){
        //     return true;
        // }
    }
}
</script>